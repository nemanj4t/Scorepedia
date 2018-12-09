<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    public $id;
    public $name;
    public $city;
    public $current_team;
    public $bio;
    public $image;
}
