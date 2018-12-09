<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public $id;
    public $home;
    public $guest;
    public $statistic;
}
