<?php

namespace App\Console\Commands;

use App\Services\GeminiTranslationService;
use Illuminate\Console\Command;

class TestGeminiTranslation extends Command
{
    protected $signature = 'gemini:test';
    protected $description = 'Test Gemini translation service';

    public function handle(GeminiTranslationService $translator)
    {
        $this->info('Testing Gemini Translation Service...');

        $testText = 'Горный тур в Ала-Арча';
        $this->info("Original text: {$testText}");

        try {
            $result = $translator->translate($testText, 'English', 'Тур');

            if ($result) {
                $this->info("✓ Translation successful!");
                $this->info("Result: {$result}");
            } else {
                $this->error("✗ Translation returned null");
                $this->error("Check storage/logs/laravel.log for details");
            }
        } catch (\Exception $e) {
            $this->error("✗ Exception occurred: " . $e->getMessage());
        }

        return 0;
    }
}
