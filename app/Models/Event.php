<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Event extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, LogsActivity, SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [ 'id' ];

    /**
     * Defines the relationship between the Event and EventRegistration models
     *
     * @return HasMany
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Defines the relationship between the Event and Team models
     *
     * @return HasManyThrough
     */
    public function registeredTeams(): HasManyThrough
    {
        return $this->hasManyThrough(Team::class, EventRegistration::class, 'event_id', 'id', 'id', 'team_id');
    }

    /**
     * Scope a query to only include events with a start date after the given date
     *
     * @param  Builder  $query
     * @param  mixed $date
     * @return void
     */
    public function scopeStartsAfter(Builder $query, $date): void
    {
        $query->where('starts_at', '>=', Carbon::parse($date));
    }

    /**
     * Scope a query to only include active events (currently happening).
     *
     * @param  Builder  $query
     * @return void
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>=', Carbon::now());
    }

    /**
     * Scope a query to only include events with active registration (currently open for registration).
     *
     * @param  Builder  $query
     * @return void
     */
    public function scopeActiveRegistration(Builder $query): void
    {
        $query->where('registration_starts_at', '<=', Carbon::now())
            ->where('registration_ends_at', '>=', Carbon::now());
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
