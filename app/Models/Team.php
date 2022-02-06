<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mpociot\Teamwork\TeamworkTeam;

class Team extends TeamworkTeam
{
    use CrudTrait;

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
}
