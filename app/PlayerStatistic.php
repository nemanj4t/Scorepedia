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

    public static function getTopOfEach($number)
    {
        $points = Redis::zrange("players:points", 0, $number - 1, "WITHSCORES");
        $blocks = Redis::zrange("players:blocks", 0, $number - 1, "WITHSCORES");
        $rebounds = Redis::zrange("players:rebounds", 0, $number - 1, "WITHSCORES");
        $steals = Redis::zrange("players:steals", 0, $number - 1, "WITHSCORES");
        $assists = Redis::zrange("players:assists", 0, $number - 1, "WITHSCORES");
        $fouls = Redis::zrange("players:fouls", 0, $number - 1, "WITHSCORES");

        return [
            "points" => $points,
            "blocks" => $blocks,
            "rebounds" => $rebounds,
            "steals" => $steals,
            "assists" => $assists,
            "fouls" => $fouls
        ];
    }

    public static function saveGlobalStats($id) {
        Redis::zadd(
            "players:points",
            0,
            $id
        );

        Redis::zadd(
            "players:blocks",
            0,
            $id
        );

        Redis::zadd(
            "players:rebounds",
            0,
            $id
        );

        Redis::zadd(
            "players:steals",
            0,
            $id
        );

        Redis::zadd(
            "players:assists",
            0,
            $id
        );

        Redis::zadd(
            "players:fouls",
            0,
            $id
        );
    }
}
