<?php

namespace App\Livewire\Traits;

use App\Services\GeminiTranslationService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

trait HasGeminiTranslation
{
    /**
     * Автоперевод на английский через Gemini AI
     */
    public function autoTranslateToEnglish(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        $fields = $this->getTranslatableFields();
        $sourceData = [];

        foreach ($fields as $field) {
            $sourceData[$field] = $this->trans[$fallbackLocale][$field] ?? '';
        }

        if (empty(array_filter($sourceData))) {
            LivewireAlert::title('Ошибка')
                ->text('Заполните русскую версию перед переводом.')
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
    }

    /**
     * Автоперевод на корейский через Gemini AI
     */
    public function autoTranslateToKorean(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        $fields = $this->getTranslatableFields();
        $sourceData = [];

        foreach ($fields as $field) {
            $sourceData[$field] = $this->trans[$fallbackLocale][$field] ?? '';
        }

        if (empty(array_filter($sourceData))) {
            LivewireAlert::title('Ошибка')
                ->text('Заполните русскую версию перед переводом.')
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
    }

    /**
     * Автоперевод на все языки сразу
     */
    public function translateToAllLanguages(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        $fields = $this->getTranslatableFields();
        $sourceData = [];

        foreach ($fields as $field) {
            $sourceData[$field] = $this->trans[$fallbackLocale][$field] ?? '';
        }

        if (empty(array_filter($sourceData))) {
            LivewireAlert::title('Ошибка')
                ->text('Заполните русскую версию перед переводом.')
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
