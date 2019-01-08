<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class TeamStatistic
{
    //Match Statistic
    public $points;
    public $blocks;
    public $rebounds;
    public $steals;
    public $fouls;
    public $assists;

    public static function getStatisticForTeamMatch($teamId, $matchId)
    {
        $team_statistic = new TeamStatistic();
        $stats = Redis::hgetall("match:$matchId:team:$teamId");

        $team_statistic->points = $stats['points'];
        $team_statistic->blocks = $stats['blocks'];
        $team_statistic->assists = $stats['assists'];
        $team_statistic->steals = $stats['steals'];
        $team_statistic->fouls = $stats['fouls'];
        $team_statistic->rebounds = $stats['rebounds'];

        return $team_statistic;
    }

    public static function getPointsForTeamMatch($teamId, $matchId)
    {
        $team_statistic = new TeamStatistic();
        $team_statistic->points = Redis::hget("match:$matchId:team:$teamId", "points");

        return $team_statistic;
    }
}
