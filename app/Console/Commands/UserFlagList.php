<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('userflag:list {--email= : List flags for specific user by email address (if omitted, will list all users)}')]
#[Description('Lists user flags for one or all users')]
class UserFlagList extends Command
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
        if ($this->option('email')) {                   // specific user
            // lookup email address
            $user = \App\Models\User::where('email', $this->option('email'))->first();
            if ($user != null) {
                $flags = null;
                foreach ($user->flags as $set_flag) {
                    $flags .= ' *'.$set_flag->flag.'* ';
                }

                if ($flags == null) {
                    $this->info($user->get_name().': <no flags set>');
                } else {
                    $this->info($user->get_name().':'.$flags);
                }
            } else {
                $this->error('No user found with email address '.$this->option('email'));
            }
        } else {                                        // all users
            $this->info('Showing flags for all users...');

            // get all users
            $users = \App\Models\User::orderby('first_name')->orderby('last_name')->get();
            foreach ($users as $user) {
                $flags = null;
                foreach ($user->flags as $set_flag) {
                    $flags .= ' *'.$set_flag->flag.'* ';
                }

                if ($flags == null) {
                    $this->info($user->get_name().': <no flags set>');
                } else {
                    $this->info($user->get_name().':'.$flags);
                }
            }
        }
    }
}
