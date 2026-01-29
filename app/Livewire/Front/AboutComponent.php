<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Artesaos\SEOTools\Facades\SEOTools;

class AboutComponent extends Component
{
    public bool $showModal = false;
    public bool $success = false;

    // Form fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public ?string $hp = ''; // honeypot

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->guests = '1';
        $this->message = '';
        $this->hp = '';
        $this->success = false;
        $this->resetValidation();
    }

    public function submit()
    {
        // Honeypot check
        if (!empty($this->hp)) {
            $this->hp = '';
            return; // Silent fail for bots
        }

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'guests' => 'nullable|integer|min:1',
            'message' => 'nullable|string|max:2000',
        ]);

        try {
            $msgBody = "Запрос программы и цены (About Us Page).\n" .
                "Количество гостей: " . $this->guests . "\n\n" .
                $this->message;

            // Create ContactMessage
            \App\Models\ContactMessage::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'message' => $msgBody,
            ]);

            // Send Email to Admin
            $adminEmail = config('mail.from.address');
            if ($adminEmail) {
                \Illuminate\Support\Facades\Mail::raw(
                    "Получен новый запрос с страницы 'О нас'.\n\nИмя: {$this->name}\nEmail: {$this->email}\nТелефон: {$this->phone}\nГостей: {$this->guests}\nСообщение: {$this->message}",
                    function ($msg) use ($adminEmail) {
                        $msg->to($adminEmail)
                            ->subject('Запрос программы и цены (About Us)');
                    }
                );
            }

            $this->success = true;

        } catch (\Exception $e) {
            \Log::error('About Us Contact Form Error: ' . $e->getMessage());
            $this->addError('general', 'Something went wrong. Please try again later.');
        }
    }

    public function render()
    {
        SEOTools::setTitle(__('titles.about') ?? 'About Us');
        SEOTools::setDescription('Learn more about TMTourism, our mission and history.');
        SEOTools::opengraph()->setUrl(route('about'));

        return view('livewire.front.about-component')
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}
