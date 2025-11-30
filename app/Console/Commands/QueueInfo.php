<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class QueueInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show current queue configuration and status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📊 Queue Configuration Info');
        $this->newLine();

        // Current queue driver
        $driver = config('queue.default');
        $this->line("Queue Driver: <fg=yellow>{$driver}</>");
        
        // Queue connection details
        $connection = config("queue.connections.{$driver}");
        
        if ($driver === 'database') {
            $this->line("Connection: <fg=green>Database</>");
            $this->line("Table: <fg=cyan>{$connection['table']}</>");
            
            // Count pending jobs
            try {
                $pendingJobs = \DB::table($connection['table'])->count();
                $this->line("Pending Jobs: <fg=yellow>{$pendingJobs}</>");
            } catch (\Exception $e) {
                $this->error("Could not count jobs: " . $e->getMessage());
            }
            
            // Count failed jobs
            try {
                $failedJobs = \DB::table('failed_jobs')->count();
                $this->line("Failed Jobs: <fg=red>{$failedJobs}</>");
            } catch (\Exception $e) {
                $this->warn("Could not count failed jobs");
            }
            
        } elseif ($driver === 'redis') {
            $this->line("Connection: <fg=green>Redis</>");
            $this->line("Host: <fg=cyan>{$connection['host']}</>");
            $this->line("Port: <fg=cyan>{$connection['port']}</>");
            
        } elseif ($driver === 'sync') {
            $this->line("Connection: <fg=yellow>Synchronous (No Queue)</>");
            $this->warn("⚠️  Emails are sent immediately, users may experience delays");
        }
        
        $this->newLine();
        
        // Mail configuration
        $this->info('📧 Mail Configuration');
        $this->line("Mailer: <fg=yellow>" . config('mail.default') . "</>");
        $this->line("Host: <fg=cyan>" . config('mail.mailers.smtp.host') . "</>");
        $this->line("Port: <fg=cyan>" . config('mail.mailers.smtp.port') . "</>");
        $this->line("From: <fg=cyan>" . config('mail.from.address') . "</>");
        
        $mailTo = env('MAIL_TO_ADDRESS');
        if ($mailTo) {
            $this->line("To: <fg=cyan>{$mailTo}</>");
        }
        
        $this->newLine();
        
        // Recommendations
        $this->info('💡 Recommendations');
        
        if ($driver === 'sync') {
            $this->warn("Consider using 'database' queue for better performance:");
            $this->line("1. Set QUEUE_CONNECTION=database in .env");
            $this->line("2. Run: php artisan config:clear");
            $this->line("3. Setup cron: * * * * * cd /path/to/project && php artisan queue:work --stop-when-empty");
        } elseif ($driver === 'database') {
            $this->info("✓ Using database queue - good choice for shared hosting!");
            $this->line("Make sure you have a cron job running:");
            $this->line("* * * * * cd /path/to/project && php artisan queue:work --stop-when-empty --tries=3 --timeout=50");
        }
        
        return 0;
    }
}
