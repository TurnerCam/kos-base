<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('generate:memberids')]
#[Description('Generates a unique membership ID for all users based on date_admitted (sorted alphabetically)')]
class GenerateMemberID extends Command
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
        $this->info('Generating membership IDs');

        // get all users
        $users = \App\Models\User::where('date_admitted', '!=', null)->orderby('date_admitted')->orderby('first_preferred')->get();

        $member_id = 1;
        foreach ($users as $user) {
            $this->info('Processing '.$user->get_name());
            $user->member_id = $member_id;
            $user->save();
            $member_id++;
        }
    }
}
