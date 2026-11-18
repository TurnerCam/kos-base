<?php

namespace App\Console\Commands;

use App\Mail\MemberAppInterviewConfirmation;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

#[Signature('email:memberappconfirmation {--email= : Member email address (will re-send latest application) } {--recipient= : Recipient address to send emails (overrides pre-configured options)}')]
#[Description('Resends a membership application')]
class ResendMembersAppConfirmation extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('email')) {

            // retrieve user account
            $user = User::where('email', $this->option('email'))->first();

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
                'photo' => URL::to('/storage/images/users/'.$user->photo.'.jpeg'),
                'skip_fields' => ['first_name', 'last_name', 'first_preferred', 'last_preferred', 'email', 'phone', 'address', 'city', 'province', 'postal', 'photo', 'pronouns'],
                'recipient' => $recipient,
                'form_data' => $responses,
            ];

            Mail::send(new MemberAppInterviewConfirmation($email_data));

            $this->info('Membership Application Confirmation emails for '.$user->get_name().' sent.');
        } else {
            $this->error('No member email address specified.');
        }

        return 0;
    }
}
