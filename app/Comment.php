<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $id;
    public $publisher;
    public $content;
    public $timestamp;
}
