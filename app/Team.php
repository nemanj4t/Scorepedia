<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $id;
    public $name;
    public $short_name;
    public $city;
    public $players;
    public $captain;
    public $trainer;
    public $description;
    public $image;
}
