<?php

namespace App\Listeners;

use App\Events\TeamRegistered;
use App\Mail\TeamRegistrationConfirmation;
use App\Mail\TeamRegistrationParticipant;
use App\Models\EventRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTeamRegistrationNotifications implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
       //
    }

    /**
     * Handle the event.
     *
     * @param  TeamRegistered  $event
     * @return void
     */
    public function handle(TeamRegistered $event)
    {
        $eventRegistration = $event->eventRegistration;

        $team = $eventRegistration->team;
        $teamLeader = $team->owner;
        $teamMembers = $team->users;
        if ($teamMembers == null) {
            Log::error(get_class() . ': No team members found on event registration creation');
            return;
        }
        $teamMemberNames = $teamMembers->pluck('name')->all();
        $teamMembersString = implode(', ', $teamMemberNames);
        $eventName = $eventRegistration->event->name;
        $paymentMethod = $eventRegistration->payments[0]->method->name;

        // Send email to team leader confirming registration
        Mail::to($teamLeader)
            ->bcc(config('app.admin_email'))
            ->send(new TeamRegistrationConfirmation($team, $teamMembersString, $eventName, $paymentMethod));

        // Send email to team members with next steps
        foreach ($teamMembers as $notifiable) {
            Mail::to($notifiable)
                ->bcc(config('app.admin_email'))
                ->send(new TeamRegistrationParticipant($notifiable, $team, $eventName, $teamLeader));
        }
    }
}
