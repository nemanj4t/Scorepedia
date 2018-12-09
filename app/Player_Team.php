<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player_Team extends Model
{
    public $position;
    public $captain;
    public $plays_from;
    public $plays_to;
}
