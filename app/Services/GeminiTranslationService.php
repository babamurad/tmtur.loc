<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;
use Exception;
use Illuminate\Support\Facades\Log;

class GeminiTranslationService
{
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
            // Используем актуальную быструю модель
            $result = Gemini::generativeModel(model: 'gemini-2.5-flash')
                ->generateContent($prompt);

            $translation = trim($result->text());

            // Агрессивная очистка от лишнего текста
            // Удаляем все до первого перевода (если AI дал варианты)
            if (preg_match('/^\d+\.\s+\*\*(.+?)\*\*/u', $translation, $matches)) {
                // Если есть нумерованный список с жирным текстом
                $translation = $matches[1];
            } elseif (preg_match('/^(?:Here.*?:|Translation:|Перевод:)\s*(.+)/isu', $translation, $matches)) {
                // Если есть вводные слова
                $translation = trim($matches[1]);
            } elseif (preg_match('/^\d+\.\s+(.+?)(?:\n|$)/u', $translation, $matches)) {
                // Если просто нумерованный список
                $translation = trim($matches[1]);
            }

            // Удаляем кавычки и звездочки (markdown)
            $translation = preg_replace('/^["\'«\*]+|["\'»\*]+$/u', '', $translation);

            // Берем только первую строку, если AI вернул несколько вариантов
            $lines = explode("\n", $translation);
            $translation = trim($lines[0]);

            return $translation;
        } catch (Exception $e) {
            Log::error("Gemini Translation Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Метод для массового перевода (например, перевод всего объекта сразу).
     */
    public function translateFields(array $fields, string $targetLanguage, string $type = 'тур'): array
    {
        $translated = [];
        foreach ($fields as $key => $value) {
            $translated[$key] = $this->translate($value, $targetLanguage, "Описание объекта типа: {$type}");
        }
        return $translated;
    }
}
