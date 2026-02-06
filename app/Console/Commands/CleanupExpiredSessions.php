<?php

namespace App\Console\Commands;

use App\Models\LoginSession;
use Illuminate\Console\Command;

class CleanupExpiredSessions extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sessions:cleanup';

    /**
     * The console command description.
     */
    protected $description = 'Clean up expired login sessions from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = LoginSession::cleanupExpired();
        
        $this->info("Cleaned up {$deleted} expired session(s).");
        
        return Command::SUCCESS;
    }
}
