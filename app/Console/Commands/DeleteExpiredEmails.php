<?php

namespace App\Console\Commands;

use App\Models\ChangeEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpiredEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired_emails:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete rows older than 2 hour';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ChangeEmail::where('created_at', '<', Carbon::now()->subHours(2))->delete();
        $this->info('Expired Emails Deleted!');
    }
}
