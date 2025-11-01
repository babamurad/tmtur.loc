<?php

namespace App\Livewire\Tours;


use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Media; // Если вы будете использовать отдельную таблицу для медиа
use Carbon\Carbon;
use App\Models\TourItineraryDay;
use App\Models\TourInclusion;
use App\Models\TourAccommodation;

class TourCreateComponent extends Component
{
    use WithFileUploads; // Добавляем трейт

    // Основные поля тура
    public $title;
    public $slug;
    public $category_id;
    public $short_description = ''; // Инициализируем пустой строкой
    public $image = '';
    public $is_published = true;
    public $base_price_cents;
    public $duration_days;

    // Поля для итинерария (массив для хранения дней)
    public $itinerary_days = [];

    // Поля для включений (массив для хранения включений/невключений)
    public $inclusions = [];

    // Поля для аккомодаций (массив для хранения вариантов)
    public $accommodations = [];

    protected function rules()
    {
        return [
            // Правила для основного тура
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug',
            'category_id' => 'required|exists:tour_categories,id',
            'short_description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'base_price_cents' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',

            // Правила для дней итинерария
            'itinerary_days.*.day_number' => 'required|integer|min:1',
            'itinerary_days.*.title' => 'required|string|max:255',
            'itinerary_days.*.description' => 'required|string', // Quill возвращает HTML

            // Правила для включений/невключений
            'inclusions.*.type' => 'required|in:included,not_included',
            'inclusions.*.item' => 'required|string', // Если item будет содержать HTML, убедитесь, что валидация это учитывает, например, 'inclusions.*.item' => 'required|html'

            // Правила для аккомодаций
            'accommodations.*.location' => 'required|string|max:255',
            'accommodations.*.nights_count' => 'required|integer|min:1',
            'accommodations.*.standard_options' => 'nullable|string',
            'accommodations.*.comfort_options' => 'nullable|string',
        ];
    }

    public function render()
    {
        $categories = TourCategory::all();
        return view('livewire.tours.tour-create-component', [
            'categories' => $categories,
        ]);
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title, language: 'ru');
    }

    public function addItineraryDay()
    {
        $this->itinerary_days[] = [
            'day_number' => count($this->itinerary_days) + 1,
            'title' => '',
            'description' => '' // Инициализируем пустой строкой
        ];
    }

    public function removeItineraryDay($index)
    {
        unset($this->itinerary_days[$index]);
        $this->itinerary_days = array_values($this->itinerary_days); // Переиндексация
    }

    public function addInclusion()
    {
        $this->inclusions[] = [
            'type' => 'included', // По умолчанию
            'item' => ''
        ];
    }

    public function removeInclusion($index)
    {
        unset($this->inclusions[$index]);
        $this->inclusions = array_values($this->inclusions); // Переиндексация
    }

    public function addAccommodation()
    {
        $this->accommodations[] = [
            'location' => '',
            'nights_count' => 1,
            'standard_options' => '',
            'comfort_options' => ''
        ];
    }

    public function removeAccommodation($index)
    {
        unset($this->accommodations[$index]);
        $this->accommodations = array_values($this->accommodations); // Переиндексация
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;
        $imageName = null;
        if ($this->image) {
            $imageName = 'tours/' . Carbon::now()->timestamp . '.' . $this->image->extension();
            $imagePath = Storage::disk('public_uploads')->putFileAs(
                path: 'tours',
                file: $this->image,
                name: Carbon::now()->timestamp . '.' . $this->image->extension()
            );
        }

        // Создаем основной тур
        $tour = Tour::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'tour_category_id' => $this->category_id,
            'is_published' => $this->is_published,
            'base_price_cents' => $this->base_price_cents,
            'duration_days' => $this->duration_days,
            'short_description' => $this->short_description, // Используем новое поле
        ]);

        // Создаем связанные дни итинерария
        foreach ($this->itinerary_days as $dayData) {
            TourItineraryDay::create([
                'tour_id' => $tour->id,
                'day_number' => $dayData['day_number'],
                'title' => $dayData['title'],
                'description' => $dayData['description'], // HTML из Quill
            ]);
        }

        // Создаем связанные включения/невключения
        foreach ($this->inclusions as $incData) {
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => $incData['type'],
                'item' => $incData['item'], // HTML из Quill (если используется)
            ]);
        }

        // Создаем связанные аккомодации
        foreach ($this->accommodations as $accData) {
            TourAccommodation::create([
                'tour_id' => $tour->id,
                'location' => $accData['location'],
                'nights_count' => $accData['nights_count'],
                'standard_options' => $accData['standard_options'],
                'comfort_options' => $accData['comfort_options'],
            ]);
        }

        // Сохранение изображения (пример с отдельной таблицей Media)
        if ($imagePath) {
            Media::create([
                'model_type' => Tour::class,
                'model_id' => $tour->id, // Используем ID созданного тура
                'file_path' => $imagePath,
                'file_name' => $imageName,
                'mime_type' => $this->image->getClientMimeType(),
            ]);
        }

        session()->flash('saved', [
            'title' => 'Тур создан!',
            'text' => 'Создан новый тур!',
        ]);
        return redirect()->route('tours.index');
    }
}
