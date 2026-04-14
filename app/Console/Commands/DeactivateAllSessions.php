<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoginSession;

class DeactivateAllSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:deactivate-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set is_active=0 for all login_sessions (force logout all users)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = LoginSession::where('is_active', true)->update(['is_active' => false]);
        $this->info("Deactivated $count active sessions.");
        return 0;
    }
}
