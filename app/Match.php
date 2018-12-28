<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class Match extends Model
{
    public $id;
    public $home;
    public $guest;
    public $statistic;

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
             CREATE (m:Match {date: '$request->date', time: '$request->time'}),
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

        //player statistic


    }
}
