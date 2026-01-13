<?php

namespace App\Livewire\Traits;

use App\Services\GeminiTranslationService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

trait HasGeminiTranslation
{
    public $translationDuration = null;

    /**
     * Автоперевод на английский через Gemini AI
     */
    public function autoTranslateToEnglish(GeminiTranslationService $translator)
    {
        $startTime = microtime(true);
        $sourceData = $this->getSourceData();
        $fields = array_keys($sourceData);

        if (empty(array_filter($sourceData))) {
            $emptyFields = array_keys(array_filter($sourceData, fn($val) => empty($val)));
            $fieldsList = implode(', ', $emptyFields);
            LivewireAlert::title('Ошибка')
                ->text("Заполните русскую версию перед переводом. (Пустые поля: $fieldsList)")
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        $translations = $translator->translateFields(
            $sourceData,
            'English',
            $this->getTranslationContext()
        );

        foreach ($fields as $field) {
            if (isset($translations[$field])) {
                $this->trans['en'][$field] = $translations[$field];
            }
        }

        LivewireAlert::title('Перевод выполнен')
            ->text('Перевод на английский успешно выполнен!')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();

        $this->dispatch('refresh-quill');
        $this->translationDuration = round(microtime(true) - $startTime, 2);
    }

    /**
     * Автоперевод на корейский через Gemini AI
     */
    public function autoTranslateToKorean(GeminiTranslationService $translator)
    {
        $startTime = microtime(true);
        $sourceData = $this->getSourceData();
        $fields = array_keys($sourceData);

        if (empty(array_filter($sourceData))) {
            $emptyFields = array_keys(array_filter($sourceData, fn($val) => empty($val)));
            $fieldsList = implode(', ', $emptyFields);
            LivewireAlert::title('Ошибка')
                ->text("Заполните русскую версию перед переводом. (Пустые поля: $fieldsList)")
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        $translations = $translator->translateFields(
            $sourceData,
            'Korean',
            $this->getTranslationContext()
        );

        foreach ($fields as $field) {
            if (isset($translations[$field])) {
                $this->trans['ko'][$field] = $translations[$field];
            }
        }

        LivewireAlert::title('Перевод выполнен')
            ->text('Перевод на корейский успешно выполнен!')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();

        $this->dispatch('refresh-quill');
        $this->translationDuration = round(microtime(true) - $startTime, 2);
    }

    /**
     * Автоперевод на все языки сразу
     */
    public function translateToAllLanguages(GeminiTranslationService $translator)
    {
        $startTime = microtime(true);
        $sourceData = $this->getSourceData();
        $fields = array_keys($sourceData);

        if (empty(array_filter($sourceData))) {
            $emptyFields = array_keys(array_filter($sourceData, fn($val) => empty($val)));
            $fieldsList = implode(', ', $emptyFields);
            LivewireAlert::title('Ошибка')
                ->text("Заполните русскую версию перед переводом. (Пустые поля: $fieldsList)")
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        $context = $this->getTranslationContext();

        // Перевод на английский
        $englishTranslations = $translator->translateFields($sourceData, 'English', $context);
        foreach ($fields as $field) {
            if (isset($englishTranslations[$field])) {
                $this->trans['en'][$field] = $englishTranslations[$field];
            }
        }

        // Перевод на корейский
        $koreanTranslations = $translator->translateFields($sourceData, 'Korean', $context);
        foreach ($fields as $field) {
            if (isset($koreanTranslations[$field])) {
                $this->trans['ko'][$field] = $koreanTranslations[$field];
            }
        }

        LivewireAlert::title('Перевод выполнен')
            ->text('Переводы на все языки успешно выполнены!')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();

        $this->dispatch('refresh-quill');
        $this->translationDuration = round(microtime(true) - $startTime, 2);
    }

    /**
     * Сбор данных для перевода из свойств компонента или массива переводов
     */
    protected function getSourceData(): array
    {
        $fallbackLocale = config('app.fallback_locale');
        $fields = $this->getTranslatableFields();
        $sourceData = [];

        foreach ($fields as $field) {
            if (property_exists($this, $field)) {
                $checkVal = $this->$field;
                if (is_string($checkVal))
                    $checkVal = trim($checkVal);
                $sourceData[$field] = $checkVal;
            } else {
                $sourceData[$field] = $this->trans[$fallbackLocale][$field] ?? '';
            }
        }

        \Illuminate\Support\Facades\Log::info('Gemini getSourceData debug:', [
            'component' => static::class,
            'fallback_locale' => $fallbackLocale,
            'sourceData' => $sourceData,
            'this_title' => $this->title ?? 'N/A',
            'this_content' => $this->content ?? 'N/A',
        ]);

        return $sourceData;
    }

    /**
     * Получить список полей для перевода
     * Переопределите этот метод в компоненте
     */
    protected function getTranslatableFields(): array
    {
        return ['name', 'description'];
    }

    /**
     * Получить контекст для перевода
     * Переопределите этот метод в компоненте
     */
    protected function getTranslationContext(): string
    {
        return 'туристический контент';
    }
}
