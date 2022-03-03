<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $team, $teamMembers, $eventName, $paymentMethod;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($team, $teamMembers, $eventName, $paymentMethod)
    {
        $this->team = $team;
        $this->teamMembers = $teamMembers;
        $this->eventName = $eventName;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->markdown('emails.team-registration-confirmation')
            ->subject('Team Registration Confirmation');
    }
}
