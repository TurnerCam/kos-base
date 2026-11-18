<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('email:memberapp {--email= : Member email address (will re-send latest application) } {--recipient= : Recipient address to send emails (overrides pre-configured options)}')]
#[Description('Resends a membership application')]
class ResendMembersApp extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('email')) {

            // retrieve user account
            $user = \App\Models\User::where('email', $this->option('email'))->first();

            if ($user == null) {
                $this->error('No member found with that email address.');
            }

            if ($this->option('recipient')) {
                $recipient = $this->option('recipient');
            } else {
                $recipient = null;
            }

            // retrieve latest membership application for this email address
            $form = $user->memberapp()->latest()->first();

            $responses = json_decode($form->data, true);

            // build array for email use
            $email_data = [
                'name' => $user->get_name(),
                'photo' => \URL::to('/storage/images/users/'.$user->photo.'.jpeg'),
                'skip_fields' => ['first_name', 'last_name', 'first_preferred', 'last_preferred', 'email', 'phone', 'address', 'city', 'province', 'postal', 'photo', 'pronouns'],
                'recipient' => $recipient,
                'form_data' => $responses,
            ];

            // send email to members (limited contact info)
            \Mail::send(new \App\Mail\MemberApp($email_data, 'members'));

            // send email to admins (full contact info)
            \Mail::send(new \App\Mail\MemberApp($email_data, 'admin'));

            $this->info('Membership Application emails for '.$user->get_name().' sent.');

        } else {
            $this->error('No member email address specified.');
        }

        return 0;
    }
}
