<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Carbon\Carbon;
use Illuminate\Console\Command;

#[Signature('generate:userstatus')]
#[Description('Generates User Status table from previous user dates')]
class GenerateUserStatus extends Command
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
    public function handle()
    {
        $this->info('Generating user status...');

        // ensure status table is empty, otherwise abort

        if (\DB::table('user_statuses')->count() != 0) {
            $this->error('User status table is not empty, aborting');

            return false;
        }

        // get all users
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            $this->info('Processing '.$user->get_name());

            if ($user->date_applied != null) {
                $rec = new \App\Models\UserStatus([
                    'user_id' => $user->id,
                    'status' => 'applicant',
                    'updated_by' => 0,
                    'created_at' => $user->date_applied,
                    'updated_at' => Carbon::now(),
                ]);

                $rec->save(['timestamps' => false]);
                unset($rec);
            }

            if ($user->date_admitted != null) {
                $rec = new \App\Models\UserStatus([
                    'user_id' => $user->id,
                    'status' => 'active',
                    'updated_by' => 0,
                    'created_at' => $user->date_admitted,
                    'updated_at' => Carbon::now(),
                ]);

                $rec->save(['timestamps' => false]);
                unset($rec);
            } else {
                if ($user->status != 'applicant') {
                    $this->error('No date admitted for '.$user->get_name());
                }
            }

            if ($user->date_withdrawn != null) {
                $rec = new \App\Models\UserStatus([
                    'user_id' => $user->id,
                    'status' => 'inactive',
                    'updated_by' => 0,
                    'created_at' => $user->date_withdrawn,
                    'updated_at' => Carbon::now(),
                ]);

                $rec->save(['timestamps' => false]);
                unset($rec);
            }

            if (($user->date_hiatus_start != null) && ($user->date_hiatus_end != null)) {
                $rec = new \App\Models\UserStatus([
                    'user_id' => $user->id,
                    'status' => 'hiatus',
                    'updated_by' => 0,
                    'created_at' => $user->date_hiatus_start,
                    'updated_at' => Carbon::now(),
                ]);

                $rec->save(['timestamps' => false]);

                $rec = new \App\Models\UserStatus([
                    'user_id' => $user->id,
                    'status' => 'active',
                    'updated_by' => 0,
                    'created_at' => $user->date_hiatus_end,
                    'updated_at' => Carbon::now(),
                    'note' => 'Ending Hiatus',
                ]);

                $rec->save(['timestamps' => false]);

                unset($rec);
            }
        }
    }
}
