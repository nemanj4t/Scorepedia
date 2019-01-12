<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class PlayerStatistic
{
    public $points;
    public $blocks;
    public $rebounds;
    public $steals;
    public $assists;
    public $fouls;

    public static function getById($id)
    {
        $points = Redis::zscore("players:points", $id);
        $blocks = Redis::zscore("players:blocks", $id);
        $rebounds = Redis::zscore("players:rebounds", $id);
        $steals = Redis::zscore("players:steals", $id);
        $assists = Redis::zscore("players:assists", $id);
        $fouls = Redis::zscore("players:fouls", $id);

        return [
            "points" => $points,
            "blocks" => $blocks,
            "rebounds" => $rebounds,
            "steals" => $steals,
            "assists" => $assists,
            "fouls" => $fouls
        ];
    }

    public static function getTopOfEach($number)
    {
        $points = Redis::zrevrange("players:points", 0, $number - 1, "WITHSCORES");
        $blocks = Redis::zrevrange("players:blocks", 0, $number - 1, "WITHSCORES");
        $rebounds = Redis::zrevrange("players:rebounds", 0, $number - 1, "WITHSCORES");
        $steals = Redis::zrevrange("players:steals", 0, $number - 1, "WITHSCORES");
        $assists = Redis::zrevrange("players:assists", 0, $number - 1, "WITHSCORES");
        $fouls = Redis::zrevrange("players:fouls", 0, $number - 1, "WITHSCORES");

        return [
            "points" => $points,
            "blocks" => $blocks,
            "rebounds" => $rebounds,
            "steals" => $steals,
            "assists" => $assists,
            "fouls" => $fouls
        ];
    }

    public static function saveByTeamId($teamId, $playerId) {
        Redis::zadd(
            "players:team:{$teamId}:points",
            0,
            $playerId
        );

        Redis::zadd(
            "players:team:{$teamId}:blocks",
            0,
            $playerId
        );

        Redis::zadd(
            "players:team:{$teamId}:rebounds",
            0,
            $playerId
        );

        Redis::zadd(
            "players:team:{$teamId}:steals",
            0,
            $playerId
        );

        Redis::zadd(
            "players:team:{$teamId}:assists",
            0,
            $playerId
        );

        Redis::zadd(
            "players:team:{$teamId}:fouls",
            0,
            $playerId
        );
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

    public static function deleteStats($id)
    {
        Redis::zrem("players:points", $id);
        Redis::zrem("players:blocks", $id);
        Redis::zrem("players:rebounds", $id);
        Redis::zrem("players:steals", $id);
        Redis::zrem("players:assists", $id);
        Redis::zrem("players:fouls", $id);
    }

    public static function getStatsForMatch($matchId, $teamId, $playerId)
    {
        $player_statistic = new PlayerStatistic();

        $stats = Redis::hgetall("match:$matchId:team:$teamId:player:$playerId");

        $player_statistic->points = $stats['points'];
        $player_statistic->assists = $stats['assists'];
        $player_statistic->rebounds = $stats['rebounds'];
        $player_statistic->steals = $stats['steals'];
        $player_statistic->fouls = $stats['fouls'];
        $player_statistic->blocks = $stats['blocks'];

        return $player_statistic;
    }
}
