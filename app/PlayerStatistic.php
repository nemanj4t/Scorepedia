<?php

namespace App;

use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;

class PlayerStatistic extends Model
{
    public $points;
    public $blocks;
    public $rebounds;
    public $steals;
    public $assists;
    public $fouls;

    public static function saveGlobalStats($id) {
        Redis::zadd(
            "players:points",
            0,
            "player:{$id}"
        );

        Redis::zadd(
            "players:blocks",
            0,
            "player:{$id}"
        );

        Redis::zadd(
            "players:rebounds",
            0,
            "player:{$id}"
        );

        Redis::zadd(
            "players:steals",
            0,
            "player:{$id}"
        );

        Redis::zadd(
            "players:assists",
            0,
            "player:{$id}"
        );

        Redis::zadd(
            "players:fouls",
            0,
            "player:{$id}"
        );
    }
}
