<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('userflag:remove {--email= : Removes flag for specific user by email address (if omitted, flag will be removed from all users)} {flag}')]
#[Description('Removes a user flag for one or all users')]
class UserFlagRemove extends Command
{
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

        // ensure user flag is defined in kos config
        if (array_key_exists($this->argument('flag'), config('kwartzlabos.user_flags'))) {
            if ($this->option('email')) {                   // specific user
                // lookup email address
                $user = \App\Models\User::where('email', $this->option('email'))->first();
                if ($user != null) {

                    // remove flag
                    if ($user->flags->contains('flag', $this->argument('flag'))) {
                        $this->info('Removing flag *'.$this->argument('flag').'* for '.$user->get_name());
                        $user->flags()->where('flag', $this->argument('flag'))->delete();
                    } else {
                        $this->info('Removing flag *'.$this->argument('flag').'* for '.$user->get_name().' - not set, skipping');
                    }
                } else {
                    $this->error('No user found with email address '.$this->option('email'));
                }
            } else {                                        // all users

                if ($this->confirm('WARNING: You are about to remove the user flag *'.$this->argument('flag').'* from ALL kOS users and will take effect immediately. Do you wish to continue?')) {
                    $this->info('Removing flag *'.$this->argument('flag').'* for all users...');

                    // get all users
                    $users = \App\Models\User::orderby('first_name')->orderby('last_name')->get();
                    foreach ($users as $user) {
                        // skip if flag already exists
                        if ($user->flags->contains('flag', $this->argument('flag'))) {
                            $this->info('Removing flag *'.$this->argument('flag').'* for '.$user->get_name());
                            $user->flags()->where('flag', $this->argument('flag'))->delete();
                        } else {
                            $this->info('Removing flag *'.$this->argument('flag').'* for '.$user->get_name().' - not set, skipping');
                        }
                    }
                }
            }
        } else {
            $this->error('Unknown user flag: '.$this->argument('flag'));
        }
    }
}
