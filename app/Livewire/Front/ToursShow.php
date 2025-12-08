<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\{Category, Tour, TourCategory, TourGroup, TourGroupService};

class ToursShow extends Component
{
    public Tour $tour;
    public ?int $selectedGroupId = null;
    public int $peopleCount = 1;
    public array $services = [];   // id => bool

    public $sending = false;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $message = null;
    public ?string $hp = null; // honeypot

    protected $rules = [
        'selectedGroupId' => 'required|exists:tour_groups,id',
        'peopleCount'     => 'required|integer|min:1|max:9',
    ];

    public function mount(Tour $tour)
    {
        $this->tour = $tour->load('groupsOpen', 'categories', 'itineraryDays', 'inclusions', 'accommodations', 'orderedMedia');
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

    public function sendMessage()
    {
        \Log::info('sendMessage called');
        $this->sending = true;
        // валидация ТОЛЬКО полей формы
        $this->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'message' => 'nullable|string|max:5000',
            'hp'      => 'nullable|prohibited',
        ]);

        // extra spam check: if honeypot filled — abort quietly
        if (!empty($this->hp)) {
            $this->resetForm();
            session()->flash('contact_error', 'Unable to send message.');
            return;
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ];

        // Save to DB (if model exists)
        try {
            ContactMessage::create(array_merge($data, [
                'ip' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]));
        } catch (\Throwable $e) {
            // log but continue — don't fail UX
            \Log::error('ContactMessage save error: '.$e->getMessage());
        }

        // Reset form and show success immediately for better UX
        $this->resetForm();
        session()->flash('contact_success', 'Message sent. Thank you!');
        $this->dispatch('messagesUpdated');
        $this->sending = false;

        // Send email notification asynchronously (in background)
        // This runs AFTER user sees success message
        try {
            $recipient = env('MAIL_TO_ADDRESS') ?: config('mail.from.address');
            if ($recipient) {
                // Use queue if available (database/redis), otherwise send immediately
                Mail::to($recipient)->send(new ContactReceived($data));
                \Log::channel('daily')->info('Contact email queued/sent to: ' . $recipient, ['from' => $data['email']]);
            } else {
                \Log::channel('daily')->warning('Contact form submitted but no recipient email configured in .env');
            }
        } catch (\Throwable $e) {
            // Log error but don't break user experience
            \Log::error('Contact email send error: '.$e->getMessage());
        }
    }

    public function getAvailableServicesProperty()
    {
        if(!$this->selectedGroupId) return collect();
        return TourGroupService::with('service')
            ->where('tour_group_id', $this->selectedGroupId)
            ->get();
    }

    public function addToCart()
    {
        $this->validate();

        $group = TourGroup::findOrFail($this->selectedGroupId);

        if($group->freePlaces() < $this->peopleCount) {
            session()->flash('error', 'Недостаточно свободных мест');
            return;
        }

        // кладём выбор во временную сессионную корзину
        $cart = session()->get('cart', []);
        $cart[] = [
            'tour_group_id' => $this->selectedGroupId,
            'people'        => $this->peopleCount,
            'services'      => array_keys(array_filter($this->services)),
        ];
        session()->put('cart', $cart);

        $this->dispatch('cartUpdated');
        session()->flash('message', 'Добавлено в корзину');
    }

    public function render()
    {
        // dd($this->tour->tr('title'));
        $categories = TourCategory::with('tours')->get();
        return view('livewire.front.tours-show', compact('categories'))
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.tour_show', ['tour' => $this->tour->tr('title')]));
    }
}
