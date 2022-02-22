<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;
use Mpociot\Teamwork\TeamworkTeam;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends TeamworkTeam
{
    use CrudTrait, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'owner_id', 'motto', 'accept_additional_members'];

    /**
     * Defines the termsAccepted attribute
     *
     * @return bool
     */
    public function getTermsAgreedAttribute() {
        return $this->terms_agreed_at !== null;
    }

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
     * Defines the relationship between Team and User models through TeamInvite
     *
     * @return HasManyThrough
     */
    public function invitedUsers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, TeamInvite::class, 'team_id', 'email', 'id', 'email');
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
