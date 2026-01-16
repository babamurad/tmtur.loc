<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\Config;

class MockComponent
{
    use HasGeminiTranslation;

    public $name;
    public $description;
    public $trans = [];

    public function __construct()
    {
        $this->trans = [];
        foreach (['ru', 'en', 'ko'] as $l) {
            $this->trans[$l] = ['name' => '', 'description' => ''];
        }
    }

    protected function getTranslatableFields(): array
    {
        return ['name', 'description'];
    }

    // Check access to protected method for testing
    public function testGetSmartSourceData()
    {
        return $this->getSmartSourceData();
    }
}

// Mock Config
Config::set('app.available_locales', ['ru', 'en', 'ko']);
Config::set('app.fallback_locale', 'ru');

$component = new MockComponent();

// Case 1: All empty
echo "Case 1: All empty\n";
print_r($component->testGetSmartSourceData());

// Case 2: RU filled (properties)
$component->name = 'Ru Name';
$component->description = 'Ru Desc';
echo "\nCase 2: RU filled\n";
print_r($component->testGetSmartSourceData());

// Case 3: EN filled (trans array)
$component = new MockComponent();
$component->trans['en']['name'] = 'En Name';
$component->trans['en']['description'] = 'En Desc';
echo "\nCase 3: EN filled\n";
print_r($component->testGetSmartSourceData());

// Case 4: Mixed - EN has more
$component = new MockComponent();
$component->name = 'Ru Name'; // RU has 1
$component->trans['en']['name'] = 'En Name';
$component->trans['en']['description'] = 'En Desc'; // EN has 2
echo "\nCase 4: Mixed (EN should win)\n";
print_r($component->testGetSmartSourceData());
