<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamRegistrationParticipant extends Mailable
{
    use Queueable, SerializesModels;

    public $teamMember, $team, $eventName, $teamLeader;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable, $team, $eventName, $teamLeader)
    {
        $this->teamMember = $notifiable;
        $this->team = $team;
        $this->eventName = $eventName;
        $this->teamLeader = $teamLeader;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->markdown('emails.team-registration-participant')
            ->subject('[Action Required] Participant Registration');
    }
}
