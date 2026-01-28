<?php

namespace App\Console\Commands;

use App\Services\GeminiTranslationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class TranslateLangFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:lang-files 
                            {--langs= : Comma-separated list of target languages (e.g. de,fr,es,pl,it)}
                            {--force : Overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate Laravel language files (php arrays) from EN to other languages using Gemini.';

    protected GeminiTranslationService $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        parent::__construct();
        $this->gemini = $gemini;
    }

    public function handle()
    {
        $allLocales = config('app.available_locales');
        // Filter out source (en) and existing manual ones if we want to skip them by default? 
        // User asked for "other languages". 
        // Let's rely on --langs or default to all except en, ru, ko (assuming ru/ko are done or manual).
        // Actually, let's just default to "all except en".

        $requestedLangs = $this->option('langs');
        if ($requestedLangs) {
            $targetLocales = explode(',', $requestedLangs);
        } else {
            // Default targets: all except 'en'
            $targetLocales = array_diff($allLocales, ['en']);
        }

        $sourceDir = lang_path('en');
        if (!File::isDirectory($sourceDir)) {
            $this->error("Source directory lang/en does not exist.");
            return;
        }

        $files = File::files($sourceDir);
        $totalFiles = count($files);

        $this->info("Found {$totalFiles} files in lang/en.");
        $this->info("Target languages: " . implode(', ', $targetLocales));

        foreach ($targetLocales as $locale) {
            $this->newLine();
            $this->info("Processing language: {$locale}");

            $targetDir = lang_path($locale);
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $bar = $this->output->createProgressBar($totalFiles);
            $bar->start();

            foreach ($files as $file) {
                $filename = $file->getFilename();
                $targetPath = $targetDir . '/' . $filename;

                if (File::exists($targetPath) && !$this->option('force')) {
                    // Skip if exists
                    $bar->advance();
                    continue;
                }

                $this->translateFile($file->getPathname(), $targetPath, $locale);
                $bar->advance();
            }

            $bar->finish();
        }

        $this->newLine(2);
        $this->info("Translation process completed.");
    }

    protected function translateFile(string $sourcePath, string $targetPath, string $locale)
    {
        $data = require $sourcePath;
        if (!is_array($data)) {
            return;
        }

        // Flatten array for better batch translation
        $flatData = Arr::dot($data);

        // Filter out empty strings
        $flatData = array_filter($flatData, fn($val) => is_string($val) && !empty($val));

        if (empty($flatData)) {
            File::put($targetPath, "<?php\n\nreturn [];\n");
            return;
        }

        $targetLangName = $this->getLanguageName($locale);
        $context = "Laravel localization file. Keep keys exactly field-names. 
        Preserve Laravel placeholders starting with ':' (e.g. :attribute, :min, :max). 
        Do not translate these placeholders. preserve HTML tags.";

        // Translate
        $translatedFlat = $this->gemini->translateFields($flatData, $targetLangName, $context);

        if (empty($translatedFlat)) {
            // Fallback: create empty or copy english? Let's create empty to valid file.
            // Or better, copy English content as fallback?
            // Let's just create what we have.
            $translatedFlat = [];
        }

        // Unflatten
        $translatedData = Arr::undot($translatedFlat);

        // Write to file
        $content = "<?php\n\nreturn " . $this->exportArray($translatedData) . ";\n";
        File::put($targetPath, $content);
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

    protected function exportArray(array $array, int $indent = 1): string
    {
        $output = "[\n";
        $indentStr = str_repeat('    ', $indent);

        foreach ($array as $key => $value) {
            $output .= $indentStr . var_export($key, true) . ' => ';

            if (is_array($value)) {
                $output .= $this->exportArray($value, $indent + 1);
            } else {
                $output .= var_export($value, true);
            }

            $output .= ",\n";
        }

        $output .= str_repeat('    ', $indent - 1) . "]";
        return $output;
    }
}
