<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReceived;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email sending functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing email configuration...');
        
        $testData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+123456789',
            'message' => 'This is a test message from the contact form.',
        ];

        try {
            $recipient = env('MAIL_TO_ADDRESS') ?: config('mail.from.address');
            
            if (!$recipient) {
                $this->error('No recipient email configured in .env file!');
                return 1;
            }

            $this->info("Sending test email to: {$recipient}");
            
            Mail::to($recipient)->send(new ContactReceived($testData));
            
            $this->info('✓ Email sent successfully!');
            $this->info('Please check your inbox at: ' . $recipient);
            
            return 0;
        } catch (\Exception $e) {
            $this->error('✗ Failed to send email!');
            $this->error('Error: ' . $e->getMessage());
            
            return 1;
        }
    }
}
