<?php

namespace App\Console\Commands;

use App\Traits\UserStatusTrait;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('process:userstatus')]
#[Description('Processes status updates for all users')]
class ProcessUserStatusUpdates extends Command
{
    use UserStatusTrait;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('['.date('Y-m-d G:i:s').'] Processing user status...');

        // grab all users and start processing statuses
        $users = \App\Models\User::all();

        $bar = $this->output->createProgressBar(count($users));

        $changes = [];
        foreach ($users as $user) {
            $bar->advance();
            $result = $this->check_current_userstatus($user);
            if ($result != null) {
                $changes[] = $result;
            }
        }
        $bar->finish();
        $this->info(null);
        $this->info(null);
        if (count($changes) > 0) {
            $this->info('['.date('Y-m-d G:i:s').'] Processing complete - changes made:');
            foreach ($changes as $change) {
                $this->info($change);
            }
        } else {
            $this->info('['.date('Y-m-d G:i:s').'] Processing complete - no changes made');
        }
    }
}
