<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $id;
    public $name;
    public $city;
    public $current_team;
    public $past_teams;
    public $number;
    public $statistics;
    public $image;
    public $bio;
    public $height;
    public $weight;
}
