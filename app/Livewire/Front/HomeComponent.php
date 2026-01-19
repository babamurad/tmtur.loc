<?php

namespace App\Livewire\Front;

use App\Enums\TourGroupStatus;
use App\Mail\GroupBookingRequest;
use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\TourGroup;
use App\Models\Review;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Rule;
use Livewire\Component;

class HomeComponent extends Component
{
    public bool $showBookingModal = false;
    public ?TourGroup $selectedGroup = null;

    #[Rule('required|string|max:255')]
    public string $booking_name = '';

    #[Rule('required|email|max:255')]
    public string $booking_email = '';

    #[Rule('nullable|string|max:50')]
    public string $booking_phone = '';

    #[Rule('required|integer|min:1')]
    public string $booking_guests = '1';

    #[Rule('nullable|string|max:2000')]
    public string $booking_message = '';

    public function openBookingModal(int $groupId): void
    {
        $this->selectedGroup = TourGroup::with('tour')->findOrFail($groupId);
        $this->resetBookingForm(clearContactData: false);
        $this->showBookingModal = true;
    }

    public function closeBookingModal(): void
    {
        $this->showBookingModal = false;
    }

    public function resetBookingForm(bool $clearContactData = false): void
    {
        if ($clearContactData) {
            $this->booking_name = '';
            $this->booking_email = '';
            $this->booking_phone = '';
        }

        $this->booking_guests = '1';
        $this->booking_message = '';

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function submitBooking(): void
    {
        if (!$this->selectedGroup) {
            $this->addError('booking_general', __('messages.no_tour_group_selected'));

            return;
        }

        $validated = $this->validate();

        $available = (int) $this->selectedGroup->freePlaces();
        $guests = (int) $this->booking_guests;

        if ($available <= 0 || $guests > max($available, 0)) {
            $this->addError('booking_guests', __('messages.not_enough_free_places'));

            return;
        }

        // Logic to construct the message body for DB storage (optional if we only want email, but keeping for ContactMessage)
        $tourTitle = $this->selectedGroup->tour?->tr('title')
            ?? $this->selectedGroup->tour?->title
            ?? '';
        $startDate = $this->selectedGroup->starts_at
            ? $this->selectedGroup->starts_at->format('d.m.Y')
            : '';

        $messageBody = "Новая заявка на групповую дату тура.\n\n"
            . "Тур: {$tourTitle}\n"
            . "Дата выезда: {$startDate}\n"
            . "ID группы: {$this->selectedGroup->id}\n"
            . "Количество гостей: {$guests}\n\n"
            . "Имя клиента: {$this->booking_name}\n"
            . "Email: {$this->booking_email}\n"
            . "Телефон: {$this->booking_phone}\n\n"
            . "Сообщение клиента:\n"
            . ($this->booking_message ?: '-');

        ContactMessage::create([
            'name' => $this->booking_name,
            'email' => $this->booking_email,
            'phone' => $this->booking_phone,
            'message' => $messageBody,
        ]);

        Customer::updateOrCreate(
            ['email' => $this->booking_email],
            [
                'full_name' => $this->booking_name,
                'phone' => $this->booking_phone,
                'gdpr_consent_at' => now(),
            ]
        );

        $adminEmail = config('mail.from.address');

        if ($adminEmail) {
            $bookingData = [
                'name' => $this->booking_name,
                'email' => $this->booking_email,
                'phone' => $this->booking_phone,
                'guests' => $this->booking_guests,
                'message' => $this->booking_message,
            ];

            Mail::to($adminEmail)->queue(new GroupBookingRequest($this->selectedGroup, $bookingData));
        }

        $this->showBookingModal = false;
        $this->resetBookingForm();

        session()->flash('success', __('messages.booking_request_sent_successfully'));
    }

    public function render()
    {
        SEOTools::setTitle(__('titles.home') ?? 'Home');
        SEOTools::setDescription(__('messages.seo_home_description') ?? 'Discover the beauty of Turkmenistan with TmTourism.');
        SEOTools::opengraph()->setUrl(route('home'));

        $tours = Cache::remember('home_tours', 3600, function () {
            return Tour::with('media', 'groupsOpen')->orderBy('id', 'desc')->limit(3)->get();
        });

        $fotos = Cache::remember('home_gallery', 3600, function () {
            return \App\Models\TurkmenistanGallery::where('is_featured', 1)->orderBy('order')->get();
        });

        // Ближайшие групповые туры (5 записей)
        $groups = Cache::remember('home_groups', 3600, function () {
            return TourGroup::with('tour')
                ->where('status', TourGroupStatus::OPEN)
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at')
                ->limit(5)
                ->get();
        });

        $reviews = Cache::remember('home_reviews', 3600, function () {
            return Review::with('user.avatar')
                ->active()
                ->latest()
                ->limit(3)
                ->get();
        });

        return view('livewire.front.home-component', compact('tours', 'fotos', 'groups', 'reviews'))
            ->layout('layouts.front-app');
    }
}
