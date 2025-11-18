<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;

class TranslationCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove orphaned translation rows';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //php artisan translation:cleanup
        $cnt = 0;
        foreach (Translation::cursor() as $tr) {
            if (! $tr->translatable_type::find($tr->translatable_id)) {
                $tr->delete();
                $cnt++;
            }
        }
        $this->info("Deleted {$cnt} orphaned translations.");
    }
}
