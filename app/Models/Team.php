<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Mpociot\Teamwork\TeamworkTeam;

class Team extends TeamworkTeam
{
    use CrudTrait;

    protected $guarded = ['id'];
}
