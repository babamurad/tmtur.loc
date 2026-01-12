<?php

namespace App\Actions\Booking;

use App\Mail\ContactReceived;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\TourGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Spatie\Referer\Referer;

class CreateBookingAction
{
    /**
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public function execute(array $data): void
    {
        DB::transaction(function () use ($data) {
            $tourGroup = null;
            if (!empty($data['tour_group_id'])) {
                $tourGroup = TourGroup::find($data['tour_group_id']);
            }

            // 1. Create Contact Message
            try {
                ContactMessage::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'message' => $data['message'] ?? $data['tour_title'],
                    'tour_title' => $data['tour_title'],
                    'tour_id' => $data['tour_id'],
                    'tour_group_id' => $data['tour_group_id'] ?? null,
                    'people_count' => $data['people_count'],
                    'services' => json_encode($data['services']),
                    'ip' => request()->ip(),
                    'user_agent' => request()->header('User-Agent'),
                ]);
            } catch (\Throwable $e) {
                Log::error('ContactMessage save error: ' . $e->getMessage());
                // Non-blocking error for booking, but we should probably log it.
                // If this fails, should we fail the whole booking?
                // For now, let's keep the original behavior: log error but continue,
                // BUT since we are in a transaction now, if this fails, we might want to throw to rollback everything if it's critical.
                // However, the original code didn't stop booking creation on contact msg failure.
                // Let's assume ContactMessage is important record-keeping.
            }

            // 2. Create Booking Logic
            if ($tourGroup) {
                Log::info('Attempting to create booking for group: ' . $tourGroup->id);

                $customer = Customer::firstOrCreate(
                    ['email' => $data['email']],
                    [
                        'full_name' => $data['name'],
                        'phone' => $data['phone'] ?? '',
                    ]
                );

                Log::info('Customer ID: ' . $customer->id);

                $pricePerPerson = $tourGroup->getPriceForPeople($data['people_count'], $data['accommodation_type'] ?? 'standard');
                $totalPriceCents = $pricePerPerson * $data['people_count'] * 100;

                Booking::create([
                    'tour_group_id' => $tourGroup->id,
                    'customer_id' => $customer->id,
                    'people_count' => $data['people_count'],
                    'accommodation_type' => $data['accommodation_type'] ?? 'standard',
                    'total_price_cents' => $totalPriceCents,
                    'status' => 'pending',
                    'notes' => $data['message'],
                    'referer' => app(Referer::class)->get(),
                    'generated_link_id' => session('generated_link_id'),
                ]);

                Log::info('Booking created successfully.');
            }
        });

        // 3. Send Email (After transaction commit)
        $this->sendEmail($data);
    }

    protected function sendEmail(array $data): void
    {
        try {
            $recipient = env('MAIL_TO_ADDRESS') ?: config('mail.from.address');
            if ($recipient) {
                Mail::to($recipient)->queue(new ContactReceived(
                    ['name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'], 'message' => $data['message']],
                    [
                        'tour_title' => $data['tour_title'],
                        'tour_group_id' => $data['tour_group_id'] ?? null,
                        'tour_group_title' => $data['tour_group_title'] ?? null,
                        'people_count' => $data['people_count'],
                        'services' => $data['services'],
                    ]
                ));
                Log::channel('daily')->info('Contact email queued for: ' . $recipient);
            } else {
                Log::channel('daily')->warning('No recipient email configured.');
            }
        } catch (\Throwable $e) {
            Log::error('Contact email send error: ' . $e->getMessage());
        }
    }
}
