<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team_Match extends Model
{
    public $team_id;
    public $match_id;
    public $points;
}
