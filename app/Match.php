<?php

namespace App;

use Ahsan\Neo4j\Facade\Cypher;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class Match
{
    public $id;
    public $isFinished;
    public $date;
    public $time;
    public $team_match;

    /**
     * @param Node $node
     * @return Match
     */
    public static function buildFromNode($node)
    {
        $match = new Match();
        $match->id = $node->identity();
        $match->isFinished = $node->value('isFinished');
        $match->date = $node->value('date');
        $match->time = $node->value('time');

        return $match;
    }

    /**
     * @param $id
     * @return Match|null
     */
    public static function getById($id)
    {
        $query = Cypher::Run("MATCH (m:Match) WHERE ID(m) = {$id} RETURN m");

        if(!$query->hasRecord())
            return null;

        $node = $query->firstRecord()->value('m');
        $match = self::buildFromNode($node);
        $match->team_match = Team_Match::getByMatchIdForShow($id);

        return $match;
    }

    /**
     * @return Match[]
     */
    public static function getAll()
    {
        $query = Cypher::Run("MATCH (m:Match) RETURN m ORDER BY m.date");
        $matches = [];

        foreach($query->getRecords() as $record)
        {
            $node = $record->value('m');
            $match = self::buildFromNode($node);
            $match->team_match = Team_Match::getByMatchId($match->id);

            $matches[] = $match;
        }

        return $matches;
    }

    public static function saveMatch(Request $request)
    {
        /** @var Result $query */
        $query = Cypher::run(
            "MATCH (t1:Team) WHERE ID(t1) = $request->hometeam
             MATCH (t2:Team) WHERE ID(t2) = $request->guestteam
             CREATE (m:Match {date: '$request->date', time: '$request->time', isFinished: false}),
             (t1)-[:TEAM_MATCH {status: 'home'}]->(m), (t2)-[:TEAM_MATCH {status: 'guest'}]->(m) RETURN m");

        $matchId = $query->firstRecord()->getByIndex(0)->identity();
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

        foreach (Player_Team::getCurrentPlayers($request->hometeam) as $current_player)
        {
            Redis::hmset(
                "match:{$matchId}:team:{$request->hometeam}:player:{$current_player->player->id}",
                "points", 0,
                "blocks", 0,
                "rebounds", 0,
                "fouls", 0,
                "steals", 0,
                "assists", 0);
        }

        foreach (Player_Team::getCurrentPlayers($request->guestteam) as $current_player)
        {
            Redis::hmset(
                "match:{$matchId}:team:{$request->guestteam}:player:{$current_player->player->id}",
                "points", 0,
                "blocks", 0,
                "rebounds", 0,
                "fouls", 0,
                "steals", 0,
                "assists", 0);
        }

        Redis::incr("count:matches");
    }
    //Api call for finishing match
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
        return Carbon::now('Europe/Belgrade') > (new Carbon($match->date." ".$match->time, 'Europe/Belgrade'));
    }

    public static function deleteMatch($id)
    {
        Cypher::Run("MATCH (m:Match) WHERE ID(m) = $id DETACH DELETE m");
        foreach(Redis::keys("*match:{$id}:*") as $key)
        {
            Redis::del($key);
        }

        Redis::decr("count:matches");
    }
}
