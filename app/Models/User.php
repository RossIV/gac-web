<?php

namespace App\Models;

use App\Mail\MagicLoginLink;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasApiTokens, HasFactory, Notifiable, UserHasTeams, MustVerifyEmail, HasRoles, CausesActivity, LogsActivity;
    use HasRelationships;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns combined first and last names as a single string
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    /**
     * Defines relationship between User and EventRegistration model
     *
     * @return HasManyDeep
     */
    public function eventRegistrations(): HasManyDeep
    {
        return $this->hasManyDeep(
            EventRegistration::class, ['team_user', Team::class],
            ['user_id', 'id', 'team_id'], ['id', 'team_id', 'id']
        );
    }

    /**
     * Defines relationship between User and Event model
     *
     * @return HasManyDeep
     */
    public function events(): HasManyDeep
    {
        return $this->hasManyDeep(
          Event::class, ['team_user', Team::class, EventRegistration::class],
            ['user_id', 'id', 'team_id', 'id'], ['id', 'team_id', 'id', 'event_id']
        );
    }

    /**
     * Define relationship between User and Signature models
     *
     * @return HasMany
     */
    public function signatures(): HasMany
    {
        return $this->hasMany(Signature::class);
    }

    /**
     * @return HasMany
     */
    public function signaturesPending(): HasMany
    {
        return $this->signatures()->pending();
    }

    /**
     * Define relationship between User and Affiliation models
     *
     * @return BelongsTo
     */
    public function affiliation(): BelongsTo
    {
        return $this->belongsTo(Affiliation::class);
    }

    /**
     * Define relationship between User and Team model
     * Separate from User <-> Team relationship defined in Teamwork trait because it does weird things
     *
     * @return BelongsToMany
     */
    public function nativeTeams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * Return native teams that are owned by the current user
     * Separate from User <-> Team relationship defined in Teamwork trait because it does weird things
     *
     * @return BelongsToMany
     */
    public function ownedNativeTeams(): BelongsToMany
    {
        return $this->nativeTeams()->where('owner_id', $this->id);
    }

    /**
     * Define relationship between User and LoginToken models
     *
     * @return HasMany
     */
    public function loginTokens(): HasMany
    {
        return $this->hasMany(LoginToken::class);
    }

    /**
     * Sends the user a magic login link by email to authenticate into the application
     *
     * @return void
     */
    public function sendLoginLink(): void
    {
        $plaintext = Str::random(32);
        $token = $this->loginTokens()->create([
            'token' => hash('sha256', $plaintext),
            'expires_at' => now()->addMinutes(15),
        ]);
        Mail::to($this->email)->queue(new MagicLoginLink($plaintext, $token->expires_at));
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
}
