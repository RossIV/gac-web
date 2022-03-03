<?php

namespace App\Observers;

use App\Mail\TeamRegistrationConfirmation;
use App\Mail\TeamRegistrationParticipant;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EventRegistrationObserver
{
    /**
     * Handle the EventRegistration "created" event.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return void
     */
    public function created(EventRegistration $eventRegistration)
    {
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

    /**
     * Handle the EventRegistration "updated" event.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return void
     */
    public function updated(EventRegistration $eventRegistration)
    {
        //
    }

    /**
     * Handle the EventRegistration "deleted" event.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return void
     */
    public function deleted(EventRegistration $eventRegistration)
    {
        //
    }

    /**
     * Handle the EventRegistration "restored" event.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return void
     */
    public function restored(EventRegistration $eventRegistration)
    {
        //
    }

    /**
     * Handle the EventRegistration "force deleted" event.
     *
     * @param  \App\Models\EventRegistration  $eventRegistration
     * @return void
     */
    public function forceDeleted(EventRegistration $eventRegistration)
    {
        //
    }
}
