<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Teamwork;
use Mpociot\Teamwork\TeamworkTeam;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends TeamworkTeam
{
    use CrudTrait, LogsActivity;

    protected $guarded = ['id'];

    /**
     * Defines the relationship between Team and EventRegistration models
     *
     * @return HasMany
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Sets options for ActivityLog
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Invite a user to join this team
     *
     * @param string $email
     * @return bool
     * @throws \Exception
     */
    public function invite(string $email): bool
    {
        if (!Teamwork::hasPendingInvite($email, $this->id)) {
            Teamwork::inviteToTeam($email, $this, function ($invite) {
                Mail::send('teamwork.emails.invite',
                    ['team' => $invite->team, 'invite' => $invite], function ($m) use ($invite) {
                    $m->to($invite->email)->subject('Invitation to join team '.$invite->team->name);
                });
            });
            return true;
        } else {
            return false;
        }
    }
}
