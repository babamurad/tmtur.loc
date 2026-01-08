<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;
use Exception;
use Illuminate\Support\Facades\Log;

class GeminiTranslationService
{
    private array $imageMap = [];

    /**
     * Универсальный метод для перевода текста.
     */
    public function translate(string $text, string $targetLanguage, string $context = 'туристический контент'): ?string
    {
        if (empty($text)) {
            return null;
        }

        // Максимально строгий промпт - только перевод, никаких вариантов
        $prompt = "You are a translator. Translate to {$targetLanguage}. Output ONLY the translated text with no explanations, no variants, no numbering:\n\n{$text}";

        try {
            // Используем актуальную быструю модель (gemini-2.5-flash)
            $result = Gemini::generativeModel(model: 'gemini-2.5-flash')
                ->generateContent($prompt);

            $translation = trim($result->text());

            // Агрессивная очистка от вводных фраз (если AI дал варианты или начал болтать)
            if (preg_match('/^\d+\.\s+\*\*(.+?)\*\*/u', $translation, $matches)) {
                // Если есть нумерованный список с жирным текстом - берем первое
                $translation = $matches[1];
            } elseif (preg_match('/^(?:Here.*?:|Translation:|Перевод:)\s*(.+)/isu', $translation, $matches)) {
                $translation = trim($matches[1]);
            }

            // Удаляем кавычки и звездочки (markdown) только если это явно одна строка и похоже на мусор
            // Но для описаний markdown может быть нужен. Пока оставим базовую чистку оберток
            $translation = preg_replace('/^["\'«]+|["\'»]+$/u', '', $translation);

            return $translation;
        } catch (Exception $e) {
            Log::error("Gemini Translation Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Метод для массового перевода массива полей за один запрос.
     * Принимает ассоциативный массив ['key' => 'text'].
     * Возвращает ассоциативный массив ['key' => 'translated_text'].
     */
    public function translateFields(array $fields, string $targetLanguage, string $type = 'туристический контент'): array
    {
        // 1. Фильтруем пустые значения
        $itemsToTranslate = array_filter($fields, fn($value) => !empty($value));

        if (empty($itemsToTranslate)) {
            return [];
        }

        // 1.1 Маскируем изображения (Base64), чтобы не отправлять их в API
        $this->imageMap = []; // Сброс карты изображений
        array_walk($itemsToTranslate, function (&$value) {
            $value = $this->maskImages($value);
        });

        // 2. Формируем JSON-структуру для запроса
        $jsonInput = json_encode($itemsToTranslate, JSON_UNESCAPED_UNICODE);

        // 3. Промпт для JSON-ответа
        $prompt = "You are a professional translator for a tourism website. 
        Translate the values in the following JSON object to {$targetLanguage}. 
        Context: {$type}.
        
        Rules:
        1. Keep the same keys.
        2. Translate values accurately. 
        3. Do not translate technical keys or IDs.
        4. Output ONLY valid JSON.
        5. KEEP placeholders like [[IMG_...]] EXACTLY as they are. Do not change or remove them.
        
        Input JSON:
        {$jsonInput}";

        try {
            // Используем модель 1.5-flash (более стабильная) с повторными попытками
            $attempt = 0;
            $maxAttempts = 3;
            $result = null;

            while ($attempt < $maxAttempts) {
                try {
                    $result = Gemini::generativeModel(model: 'gemini-2.5-flash')
                        ->generateContent($prompt);

                    // Если успех - выходим из цикла
                    break;
                } catch (\Exception $e) {
                    $attempt++;
                    Log::warning("Gemini Batch Attempt $attempt failed: " . $e->getMessage());

                    if ($attempt >= $maxAttempts) {
                        throw $e; // Пробрасываем ошибку после всех попыток
                    }

                    sleep(2); // Пауза перед повтором
                }
            }

            if (!$result) {
                return [];
            }

            $responseText = trim($result->text());

            // 4. Очистка от Markdown-оберток
            $responseText = $this->cleanJson($responseText);

            // 5. Декодируем ответ
            $translatedItems = json_decode($responseText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Gemini JSON Decode Error: " . json_last_error_msg() . " | Response: " . $responseText);
                return [];
            }

            // 6. Восстанавливаем изображения
            array_walk($translatedItems, function (&$value) {
                $value = $this->restoreImages($value);
            });

            return $translatedItems;

        } catch (Exception $e) {
            Log::error("Gemini Batch Translation Error: " . $e->getMessage());
            // Возвращаем пустой массив в случае ошибки
            return [];
        }
    }

    /**
     * Заменяет <img> теги на плейсхолдеры.
     */
    private function maskImages(string $text): string
    {
        return preg_replace_callback('/<img\s+[^>]*>/i', function ($matches) {
            $placeholder = "[[IMG_" . uniqid() . "]]";
            $this->imageMap[$placeholder] = $matches[0];
            return $placeholder;
        }, $text);
    }

    /**
     * Восстанавливает <img> теги из плейсхолдеров.
     */
    private function restoreImages(string $text): string
    {
        return str_replace(array_keys($this->imageMap), array_values($this->imageMap), $text);
    }

    private function cleanJson(string $text): string
    {
        // Удаляем ```json и ``` в начале и конце
        $text = preg_replace('/^```json\s*/i', '', $text);
        $text = preg_replace('/^```\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);

        return $text;
    }
}
