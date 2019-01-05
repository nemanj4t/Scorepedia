<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use App\Team;

class Match extends Model
{
    public $id;
    public $home;
    public $guest;
    public $statistic;

    public static function getById($id)
    {
        $query = Cypher::Run("MATCH (m:Match) WHERE ID(m) = {$id} RETURN m");

        $properties = $query->firstRecord()->values()[0]->values();
        $match = array_merge($properties, ['id' => $id]);

        $homeTeamQuery = Cypher::Run(
            "MATCH (m:Match)-[:TEAM_MATCH {status: \"home\"}]-(t:Team) 
             WHERE ID(m) = {$id} RETURN t");

        $homeTeamProps = $homeTeamQuery->getRecords()[0]->values()[0]->values();
        $homeTeamId = $homeTeamQuery->getRecords()[0]->values()[0]->identity();
        $homeTeam = array_merge($homeTeamProps, ['id' => $homeTeamId]);

        $guestTeamQuery = Cypher::Run(
            "MATCH (m:Match)-[:TEAM_MATCH {status: \"guest\"}]-(t:Team) 
             WHERE ID(m) = {$id} RETURN t");

        $guestTeamProps = $guestTeamQuery->getRecords()[0]->values()[0]->values();
        $guestTeamId = $guestTeamQuery->getRecords()[0]->values()[0]->identity();
        $guestTeam = array_merge($guestTeamProps, ['id' => $guestTeamId]);

        $match = array_merge($match, ['home' => $homeTeam]);
        $match = array_merge($match, ['guest' => $guestTeam]);

        return $match;
    }

    public static function getAll()
    {
        $query = Cypher::Run("MATCH (m:Match) RETURN m ORDER BY m.date");
        $matches = [];

        foreach($query->getRecords() as $record) {
            $id = $record->values()[0]->identity();
            $properties = $record->values()[0]->values();
            $match = array_merge($properties, ['id' => $id]);

            $homeTeamQuery = Cypher::Run(
                "MATCH (m:Match)-[:TEAM_MATCH {status: \"home\"}]-(t:Team) 
                 WHERE ID(m) = {$id} RETURN t");

            $homeTeam = $homeTeamQuery->getRecords()[0]->values()[0]->values();
            $homeTeamId = $homeTeamQuery->getRecords()[0]->values()[0]->identity();
            $homeTeamScore = Redis::hget("match:{$id}:team:{$homeTeamId}", "points");
            $homeTeam = array_merge($homeTeam, ['points' => $homeTeamScore]);

            $guestTeamQuery = Cypher::Run(
                "MATCH (m:Match)-[:TEAM_MATCH {status: \"guest\"}]-(t:Team) 
                 WHERE ID(m) = {$id} RETURN t");

            $guestTeam = $guestTeamQuery->getRecords()[0]->values()[0]->values();
            $guestTeamId = $guestTeamQuery->getRecords()[0]->values()[0]->identity();
            $guestTeamScore = Redis::hget("match:{$id}:team:{$guestTeamId}", "points");
            $guestTeam = array_merge($guestTeam, ['points' => $guestTeamScore]);

            $match = array_merge($match, ['home' => $homeTeam]);
            $match = array_merge($match, ['guest' => $guestTeam]);

            array_push($matches, $match);
        }
        return $matches;
    }

    public static function saveMatch(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'hometeam' => 'required',
            'guestteam' => 'required'
        ]);

        //neo match
        $query = Cypher::Run(
            "MATCH (t1:Team) WHERE ID(t1) = $request->hometeam
             MATCH (t2:Team) WHERE ID(t2) = $request->guestteam
             CREATE (m:Match {date: '$request->date', time: '$request->time', isFinished: false}),
             (t1)-[:TEAM_MATCH {status: 'home'}]->(m), (t2)-[:TEAM_MATCH {status: 'guest'}]->(m) RETURN m");

        $matchId = $query->firstRecord()->getIdOfNode();
        //team statistic
        Redis::hmset(
            "match:{$matchId}:team:{$request->hometeam}",
            "points", 0,
            "blocks", 0,
            "rebounds", 0,
            "fouls", 0,
            "steals", 0,
            "assists", 0);

        Redis::hmset(
            "match:{$matchId}:team:{$request->guestteam}",
            "points", 0,
            "blocks", 0,
            "rebounds", 0,
            "fouls", 0,
            "steals", 0,
            "assists", 0);

        foreach (Player_Team::getCurrentPlayers($request->hometeam) as $player)
        {
            Redis::hmset(
                "match:{$matchId}:team:{$request->hometeam}:player:{$player['player']['id']}",
                "points", 0,
                "blocks", 0,
                "rebounds", 0,
                "fouls", 0,
                "steals", 0,
                "assists", 0);
        }

        foreach (Player_Team::getCurrentPlayers($request->guestteam) as $player)
        {
            Redis::hmset(
                "match:{$matchId}:team:{$request->guestteam}:player:{$player['player']['id']}",
                "points", 0,
                "blocks", 0,
                "rebounds", 0,
                "fouls", 0,
                "steals", 0,
                "assists", 0);
        }

        Redis::incr("count:matches");
    }

    public static function finishMatch($id, $finished)
    {
        if($finished)
        {
            Cypher::Run(
                "MATCH (m:Match) WHERE ID(m) = $id
                 SET m.isFinished = true");
        }
        else
        {
            Cypher::Run(
                "MATCH (m:Match) WHERE ID(m) = $id
                 SET m.isFinished = false");
        }
    }

    public static function isLive($match)
    {
        return Carbon::now('Europe/Belgrade') > (new Carbon($match['date']." ".$match['time'], 'Europe/Belgrade'));
    }
}
