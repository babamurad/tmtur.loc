<?php

namespace App\Mail;

use App\Models\TourGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GroupBookingRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public TourGroup $tourGroup,
        public array $bookingData
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новая заявка на групповую дату тура',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.group-booking-request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
