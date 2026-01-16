<?php

namespace App\Livewire\Front;

use Livewire\Component;

class VisaComponent extends Component
{
    // Модальное окно
    public bool $showBookingModal = false;

    // Поля формы
    public string $booking_name = '';
    public string $booking_email = '';
    public string $booking_phone = '';
    public string $booking_message = '';


    protected function rules(): array
    {
        return [
            'booking_name' => ['required', 'string', 'max:255'],
            'booking_email' => ['required', 'email', 'max:255'],
            'booking_phone' => ['nullable', 'string', 'max:50'],
            'booking_message' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function openBookingModal(): void
    {
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

        $this->booking_message = '';


        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function submitBooking(): void
    {
        $validated = $this->validate();

        $messageBody = "Новое сообщение со страницы Визы.\n\n"
            . "Имя клиента: {$validated['booking_name']}\n"
            . "Email: {$validated['booking_email']}\n"
            . "Телефон: {$validated['booking_phone']}\n\n"
            . "Сообщение:\n"
            . ($validated['booking_message'] ?: '-');

        \App\Models\ContactMessage::create([
            'name' => $validated['booking_name'],
            'email' => $validated['booking_email'],
            'phone' => $validated['booking_phone'],
            'message' => $messageBody,
        ]);

        \App\Models\Customer::updateOrCreate(
            ['email' => $validated['booking_email']],
            [
                'full_name' => $validated['booking_name'],
                'phone' => $validated['booking_phone'],
                'gdpr_consent_at' => now(),
            ]
        );

        $adminEmail = config('mail.from.address');

        if ($adminEmail) {
            \Illuminate\Support\Facades\Mail::raw($messageBody, function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                    ->subject('Новое сообщение со страницы Визы');
            });
        }

        $this->showBookingModal = false;
        $this->resetBookingForm();

        session()->flash('success', __('messages.booking_request_sent_successfully'));
    }

    public function render()
    {
        \Artesaos\SEOTools\Facades\SEOTools::setTitle(__('titles.visa') ?? 'Visa Information');
        \Artesaos\SEOTools\Facades\SEOTools::setDescription('Visa requirements and support for Turkmenistan.');
        \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl(route('visa'));

        return view('livewire.front.visa-component')
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}
