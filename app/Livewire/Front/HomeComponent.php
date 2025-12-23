<?php

namespace App\Livewire\Front;

use App\Models\Guide;
use App\Models\Tour;
use App\Models\TourGroup;
use App\Models\ContactMessage;
use App\Models\Customer;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Artesaos\SEOTools\Facades\SEOTools;

class HomeComponent extends Component
{
    public bool $showBookingModal = false;
    public ?TourGroup $selectedGroup = null;

    public string $booking_name = '';
    public string $booking_email = '';
    public string $booking_phone = '';
    public string $booking_guests = '1';
    public string $booking_message = '';
    public bool $gdpr_consent = false;

    protected function rules(): array
    {
        return [
            'booking_name' => ['required', 'string', 'max:255'],
            'booking_email' => ['required', 'email', 'max:255'],
            'booking_phone' => ['nullable', 'string', 'max:50'],
            'booking_guests' => ['required', 'integer', 'min:1'],
            'booking_message' => ['nullable', 'string', 'max:2000'],
            'gdpr_consent' => ['accepted'],
        ];
    }

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
        $this->gdpr_consent = false;

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
        $guests = (int) $validated['booking_guests'];

        if ($available <= 0 || $guests > max($available, 0)) {
            $this->addError('booking_guests', __('messages.not_enough_free_places'));
            return;
        }

        $tourTitle = $this->selectedGroup->tour?->tr('title')
            ?? $this->selectedGroup->tour?->title
            ?? '';
        $startDate = $this->selectedGroup->starts_at
            ? \Carbon\Carbon::parse($this->selectedGroup->starts_at)->format('d.m.Y')
            : '';

        $messageBody = "Новая заявка на групповую дату тура.\n\n"
            . "Тур: {$tourTitle}\n"
            . "Дата выезда: {$startDate}\n"
            . "ID группы: {$this->selectedGroup->id}\n"
            . "Количество гостей: {$guests}\n\n"
            . "Имя клиента: {$validated['booking_name']}\n"
            . "Email: {$validated['booking_email']}\n"
            . "Телефон: {$validated['booking_phone']}\n\n"
            . "Сообщение клиента:\n"
            . ($validated['booking_message'] ?: '-');

        ContactMessage::create([
            'name' => $validated['booking_name'],
            'email' => $validated['booking_email'],
            'phone' => $validated['booking_phone'],
            'message' => $messageBody,
        ]);

        Customer::updateOrCreate(
            ['email' => $validated['booking_email']],
            [
                'full_name' => $validated['booking_name'],
                'phone' => $validated['booking_phone'],
                'gdpr_consent_at' => now(),
            ]
        );

        $adminEmail = config('mail.from.address');

        if ($adminEmail) {
            Mail::raw($messageBody, function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                    ->subject('Новая заявка на групповую дату тура');
            });
        }

        $this->showBookingModal = false;
        $this->resetBookingForm();

        session()->flash('success', __('messages.booking_request_sent_successfully'));
    }

    public function render()
    {
        SEOTools::setTitle(__('titles.home') ?? 'Home');
        SEOTools::setDescription(__('messages.home_description') ?? 'Discover the beauty of Turkmenistan with TmTourism.');
        SEOTools::opengraph()->setUrl(route('home'));

        $tours = Tour::with('media', 'groupsOpen')->orderBy('id', 'desc')->limit(3)->get();
        $fotos = \App\Models\TurkmenistanGallery::where('is_featured', 1)->orderBy('order')->get();
        // Ближайшие групповые туры (5 записей)
        $groups = TourGroup::with('tour')
            ->where('status', 'open')
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->limit(5)
            ->get();

        //        $guides = Guide::where('is_active', true)->orderBy('sort_order')->get();
        return view('livewire.front.home-component', compact('tours', 'fotos', 'groups'))
            ->layout('layouts.front-app');
    }
}
