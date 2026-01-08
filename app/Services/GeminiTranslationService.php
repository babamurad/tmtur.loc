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
