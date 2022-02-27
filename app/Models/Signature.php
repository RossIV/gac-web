<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Signature extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, LogsActivity;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = [
        'documentURL'
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Defines relationship between Signature and User models
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines relationship between Signature and EventRegistration models
     *
     * @return BelongsTo
     */
    public function eventRegistration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->whereNotNull('requested_at')->whereNull('signed_at');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRequested(Builder $query): Builder
    {
        return $query->whereNotNull('requested_at');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeViewed(Builder $query): Builder
    {
        return $query->whereNotNull('viewed_at');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeSigned(Builder $query): Builder
    {
        return $query->whereNotNull('signed_at');
    }

    /**
     * Defines the documentURL attribute
     *
     * @return string
     */
    public function getDocumentURLAttribute(): string
    {
        return $this->eventRegistration->event->participant_waiver_url ?: '';
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
