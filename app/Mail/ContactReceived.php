<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 10;

    public $data; // массив с name,email,phone,message, а также данными о туре
    public $tourData; // данные о туре

    /**
     * Create a new message instance.
     */
    public function __construct(array $data, array $tourData = [])
    {
        $this->data = $data;
        $this->tourData = $tourData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Новое сообщение с сайта / New Contact Message';
        if (!empty($this->tourData['tour_title'])) {
            $subject = 'Запрос по туру: ' . $this->tourData['tour_title'];
            if (!empty($this->tourData['tour_group_title'])) {
                $subject .= ' (' . $this->tourData['tour_group_title'] . ')';
            }
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-received',
            with: [
                'name' => $this->data['name'],
                'email' => $this->data['email'],
                'phone' => $this->data['phone'],
                'messageText' => $this->data['message'],
                'tourTitle' => $this->tourData['tour_title'] ?? null,
                'tourGroupId' => $this->tourData['tour_group_id'] ?? null,
                'tourGroupTitle' => $this->tourData['tour_group_title'] ?? null,
                'peopleCount' => $this->tourData['people_count'] ?? null,
                'services' => $this->tourData['services'] ?? [],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
