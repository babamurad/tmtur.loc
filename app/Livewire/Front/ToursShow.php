<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Mail\ContactReceived;
use App\Models\{Category, ContactMessage, Tour, TourCategory, TourGroup, TourGroupService, Booking, Customer};
use Illuminate\Support\Facades\Mail;

class ToursShow extends Component
{
    public Tour $tour;
    public ?int $selectedGroupId = null;
    public int $peopleCount = 1;
    public string $accommodationType = 'standard'; // 'standard' or 'comfort'
    public array $services = [];   // id => bool

    public $sending = false;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $message = null;
    public ?string $hp = null; // honeypot

    protected $rules = [
        'selectedGroupId' => 'required|exists:tour_groups,id',
        'peopleCount' => 'required|integer|min:1|max:9',
        'accommodationType' => 'required|in:standard,comfort',
    ];

    public function mount(Tour $tour)
    {
        // Загружаем связи, для groupsOpen берем все записи
        $this->tour = $tour->load([
            'groupsOpen',
            'categories',
            'itineraryDays',
            'inclusions',
            'accommodations',
            'orderedMedia',
            'tags'
        ]);
    }

    public function resetForm()
    {
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->message = null;
        $this->hp = null;
    }

    public function closeModal()
    {
        $this->resetForm();
    }

    public function openBookModal($groupId)
    {
        \Log::info('openBookModal called with ID: ' . $groupId);
        $this->selectedGroupId = $groupId;
        $this->dispatch('open-modal');
    }

    public function sendMessage(\App\Actions\Booking\CreateBookingAction $createBookingAction)
    {
        \Log::info('sendMessage called. SelectedGroupId: ' . var_export($this->selectedGroupId, true));
        $this->sending = true;
        // валидация ТОЛЬКО полей формы
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:5000',
            'hp' => 'nullable|prohibited',
        ]);

        // extra spam check: if honeypot filled — abort quietly
        if (!empty($this->hp)) {
            $this->resetForm();
            session()->flash('contact_error', 'Unable to send message.');
            return;
        }

        $tourGroup = null;
        if ($this->selectedGroupId) {
            $tourGroup = TourGroup::find($this->selectedGroupId);
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'tour_id' => $this->tour->id,
            'tour_title' => $this->tour->tr('title'),
            'tour_group_id' => $this->selectedGroupId,
            'tour_group_title' => $tourGroup ? ($tourGroup->tour?->tr('title') ?? $tourGroup->tour?->title) : null,
            'people_count' => $this->peopleCount,
            'accommodation_type' => $this->accommodationType,
            'services' => array_keys(array_filter($this->services)),
        ];

        try {
            $createBookingAction->execute($data);

            // Reset form and show success
            $this->resetForm();
            session()->flash('contact_success', 'Message sent. Thank you!');
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            \Log::error('Booking Error: ' . $e->getMessage());
            session()->flash('contact_error', 'Something went wrong. Please try again.');
        }

        $this->sending = false;
    }

    public function getAvailableServicesProperty()
    {
        if (!$this->selectedGroupId)
            return collect();
        return TourGroupService::with('service')
            ->where('tour_group_id', $this->selectedGroupId)
            ->get();
    }

    public function getTotalOpenGroupsCountProperty()
    {
        return TourGroup::where('tour_id', $this->tour->id)
            ->where('status', 'open')
            ->where('starts_at', '>', now())
            ->count();
    }

    public function getCalculatedPriceProperty()
    {
        if (!$this->selectedGroupId)
            return 0;

        $group = TourGroup::find($this->selectedGroupId);
        if (!$group)
            return 0;

        return $group->getPriceForPeople($this->peopleCount, $this->accommodationType);
    }

    public function addToCart()
    {
        $this->validate();

        $group = TourGroup::findOrFail($this->selectedGroupId);

        if ($group->freePlaces() < $this->peopleCount) {
            session()->flash('error', 'Недостаточно свободных мест');
            return;
        }

        // кладём выбор во временную сессионную корзину
        $cart = session()->get('cart', []);
        $cart[] = [
            'tour_group_id' => $this->selectedGroupId,
            'people' => $this->peopleCount,
            'accommodation_type' => $this->accommodationType,
            'services' => array_keys(array_filter($this->services)),
        ];
        session()->put('cart', $cart);
        session()->save(); // Force save just in case

        \Log::info('Added to cart', ['cart' => $cart]);

        $this->dispatch('cartUpdated');
        session()->flash('message', 'Добавлено в корзину');
    }

    public function render()
    {
        // 1. Попытка взять данные из таблицы seo_metas (Poly relation)
        $seo = $this->tour->loadMissing('seo')->seo;

        if ($seo) {
            $title = $seo->title ?: $this->tour->tr('title');
            $description = $seo->description ?: ($this->tour->tr('short_description') ?? $title);
            $image = $seo->og_image ? asset('storage/' . $seo->og_image) : $this->tour->first_media_url;
        } else {
            // 2. Фоллбэк на данные модели
            $title = $this->tour->tr('title');
            $description = $this->tour->tr('short_description') ?? $title;
            // Accessor getFirstMediaUrlAttribute
            $image = $this->tour->first_media_url;
        }

        \Artesaos\SEOTools\Facades\SEOTools::setTitle($title);
        \Artesaos\SEOTools\Facades\SEOTools::setDescription($description);
        \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl(route('tours.show', $this->tour->slug));
        \Artesaos\SEOTools\Facades\SEOTools::opengraph()->addImage($image);

        $categories = TourCategory::with('tours')->get();
        return view('livewire.front.tours-show', compact('categories'))
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}
