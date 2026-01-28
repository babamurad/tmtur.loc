<?php

namespace App\Console\Commands;

use App\Services\GeminiTranslationService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Facades\File;

class TranslateContentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:content 
                            {--model= : Specific model to translate (e.g. Tour, Post)} 
                            {--id= : Specific ID to translate}
                            {--langs= : Comma-separated list of languages to process (e.g. it,fr)}';

    protected $description = 'Batch translate content using Gemini AI';

    protected $gemini;

    protected $modelMap = [
        'Tour' => \App\Models\Tour::class,
        'Post' => \App\Models\Post::class,
        'Hotel' => \App\Models\Hotel::class,
        'Service' => \App\Models\Service::class,
        'Inclusion' => \App\Models\Inclusion::class,
        'Tag' => \App\Models\Tag::class,
        'Category' => \App\Models\Category::class,
        'TourCategory' => \App\Models\TourCategory::class,
        'TourItineraryDay' => \App\Models\TourItineraryDay::class,
        'Place' => \App\Models\Place::class,
        'Location' => \App\Models\Location::class,
        'Page' => \App\Models\Page::class,
        'CarouselSlide' => \App\Models\CarouselSlide::class,
        'TurkmenistanGallery' => \App\Models\TurkmenistanGallery::class,
        'ContactInfo' => \App\Models\ContactInfo::class,
        'TourAccommodation' => \App\Models\TourAccommodation::class,
    ];

    public function __construct(GeminiTranslationService $gemini)
    {
        parent::__construct();
        $this->gemini = $gemini;
    }

    public function handle()
    {
        // 1. Determine which models to process
        $modelsToProcess = $this->getModelsToProcess();

        if (empty($modelsToProcess)) {
            $this->error('No valid models found or specified.');
            return;
        }

        $allLocales = config('app.available_locales');

        // Filter by --langs option if provided
        if ($langsOption = $this->option('langs')) {
            $requestedLangs = explode(',', $langsOption);
            $allLocales = array_intersect($allLocales, $requestedLangs);

            if (empty($allLocales)) {
                $this->error("No valid languages found in request: $langsOption");
                return;
            }
        }

        $this->info('Languages to process: ' . implode(', ', $allLocales));

        foreach ($modelsToProcess as $className) {
            $this->processModel($className, $allLocales);
        }

        $this->info('All Done!');
    }

    protected function getModelsToProcess()
    {
        $inputModel = $this->option('model');

        if ($inputModel) {
            $className = $this->modelMap[$inputModel] ?? $inputModel;
            if (class_exists($className)) {
                return [$className];
            }
            // Try namespace 'App\Models\'
            $className = 'App\\Models\\' . $inputModel;
            if (class_exists($className)) {
                return [$className];
            }
            return [];
        }

        // Default: Scan for models using Translatable trait
        // For simplicity, using the predefined map, or we could scan directory
        return array_values($this->modelMap);
    }

    protected function processModel(string $className, array $locales)
    {
        $shortName = class_basename($className);
        $this->info("Processing model: {$shortName}");

        $query = $className::query();
        if ($id = $this->option('id')) {
            $query->where('id', $id);
        }

        $items = $query->get();
        $count = $items->count();

        if ($count === 0) {
            $this->warn("No records found for {$shortName}");
            return;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($items as $item) {
            $this->translateItem($item, $locales);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
    }

    protected function translateItem(Model $item, array $locales)
    {
        // Check if model has Translatable trait
        if (!method_exists($item, 'translations')) {
            return;
        }

        // Determine source language (most filled)
        [$sourceLocale, $sourceData] = $this->getSmartSourceData($item, $locales);

        if (!$sourceLocale || empty($sourceData)) {
            // Nothing to translate from
            return;
        }

        foreach ($locales as $targetLocale) {
            if ($targetLocale === $sourceLocale) {
                continue;
            }

            // Determine what is missing
            $missingData = $this->getMissingFields($item, $sourceData, $targetLocale);

            if (empty($missingData)) {
                continue;
            }

            // Translate
            $targetLangName = $this->getLanguageName($targetLocale);
            // Context could be model name
            $context = "content for " . class_basename($item);

            try {
                $translations = $this->gemini->translateFields($missingData, $targetLangName, $context);

                if (!empty($translations)) {
                    foreach ($translations as $field => $value) {
                        $item->setTr($field, $targetLocale, $value);
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error translating {$item->id} to {$targetLocale}: " . $e->getMessage());
            }
        }
    }

    protected function getSmartSourceData(Model $item, array $locales): array
    {
        // Usually models define public $translatable or we inspect schema?
        // Translatable trait doesn't explicitly list fields, usually livewire component does.
        // But the trait uses `tr($field)`. We need to know WHICH fields to translate.
        // We can inspect 'translations' table for existing keys for this item?
        // Or assume standard fields like 'title', 'description', 'content', 'body', 'name'.

        // Let's look for a property or method on model
        $fields = ['title', 'description', 'content', 'body', 'name', 'text', 'short_description'];

        if (property_exists($item, 'fields')) {
            $fields = $item->fields;
        } elseif (property_exists($item, 'translatable_fields')) {
            $fields = $item->translatable_fields;
        }

        $bestLocale = null;
        $maxFilled = -1;
        $bestData = [];

        foreach ($locales as $locale) {
            $currentData = [];
            $filledCount = 0;

            foreach ($fields as $field) {
                // To get raw value without fallback, we might need to bypass accessor or use attributes
                // But $item->tr($field, $locale) fetches from cache/db.
                // However, tr() implementation in trait might return original value if translation missing?
                // Actually tr() returns null or original value.
                // Let's rely on Translation model directly to be sure it IS a translation.

                // WAIT. Translatable trait:
                // tr($field, $locale) -> checks Cache -> Translation table. If null, returns $this->$field.

                // If we check the BASE fields (columns in DB), they are usually the fallback content (e.g. Ru or En).
                // We should check what IS actually filled.

                $val = $item->tr($field, $locale);

                // If it equals the attribute value, it might be fallback.
                // Let's just check length.
                if (!empty($val) && strlen(strip_tags($val)) > 1) {
                    $filledCount++;
                    $currentData[$field] = $val;
                }
            }

            if ($filledCount > $maxFilled) {
                $maxFilled = $filledCount;
                $bestLocale = $locale;
                $bestData = $currentData;
            }
        }

        return [$bestLocale, $bestData];
    }

    protected function getMissingFields(Model $item, array $sourceData, string $targetLocale): array
    {
        $missing = [];
        foreach ($sourceData as $field => $val) {
            // Check if translation exists
            $exists = false;

            if (method_exists($item, 'hasTranslation')) {
                $exists = $item->hasTranslation($field, $targetLocale);
            } else {
                // Default: Check DB table
                $exists = \App\Models\Translation::where([
                    'translatable_type' => get_class($item),
                    'translatable_id' => $item->id,
                    'locale' => $targetLocale,
                    'field' => $field,
                ])->exists();
            }

            if (!$exists) {
                $missing[$field] = $val;
            }
        }
        return $missing;
    }

    protected function getLanguageName(string $code)
    {
        $map = [
            'ru' => 'Russian',
            'en' => 'English',
            'ko' => 'Korean',
            'de' => 'German',
            'fr' => 'French',
            'es' => 'Spanish',
            'pl' => 'Polish',
            'it' => 'Italian',
            'tr' => 'Turkish',
        ];
        return $map[$code] ?? $code;
    }
}
