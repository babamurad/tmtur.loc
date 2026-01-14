<?php

namespace App\Livewire\Traits;

use App\Services\GeminiTranslationService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

trait HasGeminiTranslation
{
    public $translationDuration = null;

    protected array $localeMap = [
        'ru' => 'Russian',
        'en' => 'English',
        'ko' => 'Korean',
        'de' => 'German',
        'fr' => 'French',
        'es' => 'Spanish',
        'it' => 'Italian',
        'tr' => 'Turkish',
    ];

    /**
     * Автоперевод на английский через Gemini AI
     */
    public function autoTranslateToEnglish(GeminiTranslationService $translator)
    {
        $this->translateToLocale($translator, 'en');
    }

    /**
     * Автоперевод на корейский через Gemini AI
     */
    public function autoTranslateToKorean(GeminiTranslationService $translator)
    {
        $this->translateToLocale($translator, 'ko');
    }

    /**
     * Общий метод перевода на конкретный язык
     */
    protected function translateToLocale(GeminiTranslationService $translator, string $targetLocale)
    {
        $startTime = microtime(true);

        // 1. Определяем исходный язык (где больше всего данных)
        [$sourceLocale, $sourceData] = $this->getSmartSourceData();

        if (empty($sourceData)) {
            $this->showErrorToast("Заполните хотя бы один язык перед переводом.");
            return;
        }

        // Если целевой язык совпадает с исходным - проверяем заполненность
        // Ноль смысла переводить, если это источник, но для консистентности проверим
        if ($sourceLocale === $targetLocale) {
            // Если это реально самый заполненный язык, то, вероятно, нечего делать.
            // Но может быть partial update. В любом случае, переводить EN -> EN это странно.
            // Только если мы хотим дозаполнить пропуски? Но откуда? 
            // Если это source, значит нет другого более полного языка.
            $this->showSuccessToast("Данные уже заполнены на этом языке (это источник).");
            return;
        }

        // 2. Определяем, какие поля нужно перевести (только пустые)
        $dataToTranslate = $this->prepareDataForTranslation($sourceData, $targetLocale);

        if (empty($dataToTranslate)) {
            $this->showSuccessToast("Все поля для целевого языка уже заполнены.");
            return;
        }

        // 3. Переводим
        $targetLanguageName = $this->getLanguageName($targetLocale);
        $translations = $translator->translateFields(
            $dataToTranslate,
            $targetLanguageName,
            $this->getTranslationContext()
        );

        // 4. Применяем
        $this->applyTranslations($translations, $targetLocale);

        $this->dispatch('refresh-quill');
        $this->translationDuration = round(microtime(true) - $startTime, 2);

        $this->showSuccessToast("Перевод на $targetLanguageName выполнен!");
    }

    /**
     * Автоперевод на все языки сразу
     */
    public function translateToAllLanguages(GeminiTranslationService $translator)
    {
        $startTime = microtime(true);

        // 1. Определяем исходный язык
        [$sourceLocale, $sourceData] = $this->getSmartSourceData();

        if (empty($sourceData)) {
            $this->showErrorToast("Заполните хотя бы один язык перед переводом.");
            return;
        }

        $translatedCount = 0;
        $context = $this->getTranslationContext();

        // 2. Перебираем все доступные языки
        foreach (config('app.available_locales') as $targetLocale) {
            // Пропускаем исходный язык
            if ($targetLocale === $sourceLocale) {
                continue;
            }

            // Определяем недостающие поля
            $dataToTranslate = $this->prepareDataForTranslation($sourceData, $targetLocale);

            if (empty($dataToTranslate)) {
                continue;
            }

            // Переводим
            $targetLanguageName = $this->getLanguageName($targetLocale);
            $translations = $translator->translateFields($dataToTranslate, $targetLanguageName, $context);

            if (!empty($translations)) {
                $this->applyTranslations($translations, $targetLocale);
                $translatedCount++;
            }
        }

        $this->dispatch('refresh-quill');
        $this->translationDuration = round(microtime(true) - $startTime, 2);

        if ($translatedCount > 0) {
            $this->showSuccessToast("Переводы выполнены и добавлены.");
        } else {
            $this->showSuccessToast("Все поля уже заполнены, перевод не требуется.");
        }
    }

    /**
     * Умный поиск источника данных:
     * Возвращает [$locale, $data] для языка, где заполнено больше всего полей.
     */
    protected function getSmartSourceData(): array
    {
        $fields = $this->getTranslatableFields();
        $bestLocale = null;
        $maxFilled = -1;
        $bestData = [];

        foreach (config('app.available_locales') as $locale) {
            $currentData = [];
            $filledCount = 0;

            foreach ($fields as $field) {
                // Извлекаем значение из массива trans или property (если это fallback)
                $val = $this->getFieldValue($field, $locale);

                if (!empty($val) && is_string($val) && trim($val) !== '') {
                    $filledCount++;
                }
                $currentData[$field] = $val;
            }

            // Если этот язык полнее предыдущего лидера - запоминаем
            if ($filledCount > $maxFilled) {
                $maxFilled = $filledCount;
                $bestLocale = $locale;
                $bestData = $currentData;
            }
        }

        if ($maxFilled <= 0) {
            return [null, []];
        }

        \Illuminate\Support\Facades\Log::info('Gemini SmartSource:', [
            'selected' => $bestLocale,
            'filled' => $maxFilled,
            'data' => $bestData
        ]);

        return [$bestLocale, $bestData];
    }

    /**
     * Получить значение поля для конкретной локали
     * Учитывает, что fallback локаль может быть в $this->field, а остальные в $this->trans
     */
    protected function getFieldValue(string $field, string $locale)
    {
        // 1. Если локаль совпадает с fallback, проверяем свойство верхнего уровня
        // Это приоритет, так как UI обычно привязан к public свойству (напр. $title), а не к трансу
        if ($locale === config('app.fallback_locale') && property_exists($this, $field)) {
            $val = $this->$field;
            if (is_string($val))
                return trim($val);
            return $val;
        }

        // 2. Иначе смотрим в массив trans
        if (isset($this->trans[$locale][$field])) {
            $val = $this->trans[$locale][$field];
            if (is_string($val))
                return trim($val);
            return $val;
        }

        return '';
    }

    /**
     * Подготовить массив данных для перевода:
     * Берет исходные данные и оставляет только те ключи, которые ПУСТЫ в целевом языке.
     */
    protected function prepareDataForTranslation(array $sourceData, string $targetLocale): array
    {
        $dataToTranslate = [];

        foreach ($sourceData as $key => $sourceValue) {
            // Если исходное значение пустое - нечего переводить
            if (empty($sourceValue)) {
                continue;
            }

            // Проверяем значение в целевом языке
            $targetValue = $this->getFieldValue($key, $targetLocale);

            // Если в целевом пусто - добавляем в список на перевод
            if (empty($targetValue)) {
                $dataToTranslate[$key] = $sourceValue;
            }
        }

        return $dataToTranslate;
    }

    /**
     * Применить полученные переводы
     */
    protected function applyTranslations(array $translations, string $locale)
    {
        foreach ($translations as $field => $value) {
            $this->trans[$locale][$field] = $value;

            // Если это fallback локаль, обновляем и свойство уровня компонента
            if ($locale === config('app.fallback_locale') && property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }

    protected function getLanguageName(string $locale): string
    {
        return $this->localeMap[$locale] ?? ucfirst($locale);
    }

    protected function showErrorToast(string $message)
    {
        LivewireAlert::title('Внимание')
            ->text($message)
            ->warning()
            ->toast()
            ->position('top-end')
            ->show();
    }

    protected function showSuccessToast(string $message)
    {
        LivewireAlert::title('Успешно')
            ->text($message)
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
