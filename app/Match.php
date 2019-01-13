<?php

namespace App;

use Ahsan\Neo4j\Facade\Cypher;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Illuminate\Session;

class Match
{
    public $id;
    public $isFinished;
    public $date;
    public $time;
    public $team_match;

    public static $loserPreviousStreak;


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

    /**
     * @param Team $winner
     * @param  Team $loser
     * @param Team_Match $team_match
     * @param Match $match
     */
    public static function assignMatchResult($winner, $loser, $team_match, $match)
    {
        Redis::zincrby("points", 3, $winner->id);
        Redis::zincrby("wins", 1, $winner->id);
        Redis::zincrby("losses", 1, $loser->id);

        $winsWinner = intval(Redis::zscore("wins", $winner->id));
        $lossesWinner = intval(Redis::zscore("losses", $winner->id));
        Redis::zadd("percentage", round((100 * $winsWinner) / ($winsWinner + $lossesWinner)), $winner->id);

        $winsLoser = intval(Redis::zscore("wins", $loser->id));
        $lossesLoser = intval(Redis::zscore("losses", $loser->id));
        Redis::zadd("percentage", round((100*$winsLoser)/($winsLoser + $lossesLoser)), $loser->id);

        if ($winner->id == $team_match->home->id)
            Redis::zincrby("home", 1, $winner->id);
        else
            Redis::zincrby("road", 1, $winner->id);

        Redis::zincrby("streak", 1, $winner->id);
        \Session::put('loserPreviousStreak:' . $match->id, intval(Redis::zscore('streak', $loser->id)));
        Redis::zadd("streak", 0, $loser->id);


        Redis::hmset(
            "team:standings:{$winner->id}",
            "points", intval(Redis::zscore("points", $winner->id)),
            "wins", $winsWinner,
            "losses", $lossesWinner,
            "percentage", intval(Redis::zscore("percentage", $winner->id)),
            "home", intval(Redis::zscore("home", $winner->id)),
            "road", intval(Redis::zscore("road", $winner->id)),
            "streak", intval(Redis::zscore("streak", $winner->id)));

        Redis::hmset(
            "team:standings:{$loser->id}",
            "losses", intval(Redis::zscore("losses", $loser->id)),
            "percentage", intval(Redis::zscore("percentage", $loser->id)),
            "streak", Redis::zscore("streak", $loser->id));
    }

    /**
     * @param Team $winner
     * @param Team $loser
     * @param Team_Match $team_match
     * @param Match $match
     */
    public static function annulMatchResult($winner, $loser, $team_match, $match)
    {

        Redis::zincrby("points", -3, $winner->id);
        Redis::zincrby("wins", -1, $winner->id);
        Redis::zincrby("losses", -1, $loser->id);

        $winsWinner = intval(Redis::zscore("wins", $winner->id));
        $lossesWinner = intval(Redis::zscore("losses", $winner->id));
        Redis::zadd("percentage", round((100 * $winsWinner) / ($winsWinner + $lossesWinner)), $winner->id);

        $winsLoser = intval(Redis::zscore("wins", $loser->id));
        $lossesLoser = intval(Redis::zscore("losses", $loser->id));
        Redis::zadd("percentage", round((100*$winsLoser)/($winsLoser + $lossesLoser)), $loser->id);

        if ($winner->id == $team_match->home->id)
            Redis::zincrby("home", -1, $winner->id);
        else
            Redis::zincrby("road", -1, $winner->id);

        Redis::zincrby("streak", -1, $winner->id);

        Redis::zadd("streak", \Session::get('loserPreviousStreak:' . $match->id), $loser->id);


        Redis::hmset(
            "team:standings:{$winner->id}",
            "points", intval(Redis::zscore("points", $winner->id)),
            "wins", $winsWinner,
            "losses", $lossesWinner,
            "percentage", intval(Redis::zscore("percentage", $winner->id)),
            "home", intval(Redis::zscore("home", $winner->id)),
            "road", intval(Redis::zscore("road", $winner->id)),
            "streak", intval(Redis::zscore("streak", $winner->id)));

        Redis::hmset(
            "team:standings:{$loser->id}",
            "losses", intval(Redis::zscore("losses", $loser->id)),
            "percentage", intval(Redis::zscore("percentage", $loser->id)),
            "streak", intval(Redis::zscore("streak", $loser->id)));

    }


    //Api call for finishing match
    public static function finishMatch($id, $finished)
    {
        $team_match = Team_Match::getByMatchIdForShow($id);


        if($finished)
        {
            Cypher::Run(
                "MATCH (m:Match) WHERE ID(m) = $id
                 SET m.isFinished = true");

            if ($team_match->home_statistic->points > $team_match->guest_statistic->points) {
                Redis::zincrby("points", 3, $team_match->home->id);
                Redis::zincrby("wins", 1, $team_match->home->id);
                Redis::zincrby("losses", 1, $team_match->guest->id);

                $winsWinner = intval(Redis::zscore("wins", $team_match->home->id));
                $lossesWinner = intval(Redis::zscore("losses", $team_match->home->id));
                Redis::zadd("percentage", round((100 * $winsWinner) / ($winsWinner + $lossesWinner)), $team_match->home->id);

                $winsLoser = intval(Redis::zscore("wins", $team_match->guest->id));
                $lossesLoser = intval(Redis::zscore("losses", $team_match->guest->id));
                Redis::zadd("percentage", round((100*$winsLoser)/($winsLoser + $lossesLoser)), $team_match->guest->id);

                Redis::zincrby("home", 1, $team_match->home->id);

                Redis::zincrby("streak", 1, $team_match->home->id);
                \Session::put('loserPreviousStreak:' . $id, intval(Redis::zscore('streak', $team_match->guest->id)));
                Redis::zadd("streak", 0, $team_match->guest->id);


                Redis::hmset(
                    "team:standings:{$team_match->home->id}",
                    "points", intval(Redis::zscore("points", $team_match->home->id)),
                    "wins", $winsWinner,
                    "losses", $lossesWinner,
                    "percentage", intval(Redis::zscore("percentage", $team_match->home->id)),
                    "home", intval(Redis::zscore("home", $team_match->home->id)),
                    "road", intval(Redis::zscore("road", $team_match->home->id)),
                    "streak", intval(Redis::zscore("streak", $team_match->home->id)));

                Redis::hmset(
                    "team:standings:{$team_match->guest->id}",
                    "losses", intval(Redis::zscore("losses", $team_match->guest->id)),
                    "percentage", intval(Redis::zscore("percentage", $team_match->guest->id)),
                    "streak", Redis::zscore("streak", $team_match->guest->id));
            }
            else {
                Redis::zincrby("points", 3, $team_match->guest->id);
                Redis::zincrby("wins", 1, $team_match->guest->id);
                Redis::zincrby("losses", 1, $team_match->home->id);

                $winsWinner = intval(Redis::zscore("wins", $team_match->guest->id));
                $lossesWinner = intval(Redis::zscore("losses", $team_match->guest->id));
                Redis::zadd("percentage", round((100 * $winsWinner) / ($winsWinner + $lossesWinner)), $team_match->guest->id);

                $winsLoser = intval(Redis::zscore("wins", $team_match->home->id));
                $lossesLoser = intval(Redis::zscore("losses", $team_match->home->id));
                Redis::zadd("percentage", round((100*$winsLoser)/($winsLoser + $lossesLoser)), $team_match->home->id);

                Redis::zincrby("road", 1, $team_match->guest->id);

                Redis::zincrby("streak", 1, $team_match->guest->id);
                \Session::put('loserPreviousStreak:' . $id, intval(Redis::zscore('streak', $team_match->home->id)));
                Redis::zadd("streak", 0, $team_match->home->id);


                Redis::hmset(
                    "team:standings:{$team_match->guest->id}",
                    "points", intval(Redis::zscore("points", $team_match->guest->id)),
                    "wins", $winsWinner,
                    "losses", $lossesWinner,
                    "percentage", intval(Redis::zscore("percentage", $team_match->guest->id)),
                    "home", intval(Redis::zscore("home", $team_match->guest->id)),
                    "road", intval(Redis::zscore("road", $team_match->guest->id)),
                    "streak", intval(Redis::zscore("streak", $team_match->guest->id)));

                Redis::hmset(
                    "team:standings:{$team_match->home->id}",
                    "losses", intval(Redis::zscore("losses", $team_match->home->id)),
                    "percentage", intval(Redis::zscore("percentage", $team_match->home->id)),
                    "streak", Redis::zscore("streak", $team_match->home->id));
            }

        }
        else
        {
            Cypher::Run(
                "MATCH (m:Match) WHERE ID(m) = $id
                 SET m.isFinished = false");

            if ($team_match->home_statistic->points > $team_match->guest_statistic->points)
            {
                Redis::zincrby("points", -3, $team_match->home->id);
                Redis::zincrby("wins", -1, $team_match->home->id);
                Redis::zincrby("losses", -1, $team_match->guest->id);

                $winsWinner = intval(Redis::zscore("wins", $team_match->home->id));
                $lossesWinner = intval(Redis::zscore("losses", $team_match->home->id));
                Redis::zadd("percentage", round((100 * $winsWinner) / ($winsWinner + $lossesWinner)), $team_match->home->id);

                $winsLoser = intval(Redis::zscore("wins", $team_match->guest->id));
                $lossesLoser = intval(Redis::zscore("losses", $team_match->guest->id));
                Redis::zadd("percentage", round((100*$winsLoser)/($winsLoser + $lossesLoser)), $team_match->guest->id);

                Redis::zincrby("home", -1, $team_match->home->id);

                Redis::zincrby("streak", -1, $team_match->home->id);
                Redis::zadd("streak", \Session::get('loserPreviousStreak:' . $id), $team_match->guest->id);

                Redis::hmset(
                    "team:standings:{$team_match->home->id}",
                    "points", intval(Redis::zscore("points", $team_match->home->id)),
                    "wins", $winsWinner,
                    "losses", $lossesWinner,
                    "percentage", intval(Redis::zscore("percentage", $team_match->home->id)),
                    "home", intval(Redis::zscore("home", $team_match->home->id)),
                    "road", intval(Redis::zscore("road", $team_match->home->id)),
                    "streak", intval(Redis::zscore("streak", $team_match->home->id)));

                Redis::hmset(
                    "team:standings:{$team_match->guest->id}",
                    "losses", intval(Redis::zscore("losses", $team_match->guest->id)),
                    "percentage", intval(Redis::zscore("percentage", $team_match->guest->id)),
                    "streak", intval(Redis::zscore("streak", $team_match->guest->id)));
            }

            else
            {
                Redis::zincrby("points", -3, $team_match->guest->id);
                Redis::zincrby("wins", -1, $team_match->guest->id);
                Redis::zincrby("losses", -1, $team_match->home->id);

                $winsWinner = intval(Redis::zscore("wins", $team_match->guest->id));
                $lossesWinner = intval(Redis::zscore("losses", $team_match->guest->id));
                Redis::zadd("percentage", round((100 * $winsWinner) / ($winsWinner + $lossesWinner)), $team_match->guest->id);

                $winsLoser = intval(Redis::zscore("wins", $team_match->home->id));
                $lossesLoser = intval(Redis::zscore("losses", $team_match->home->id));
                Redis::zadd("percentage", round((100*$winsLoser)/($winsLoser + $lossesLoser)), $team_match->home->id);

                Redis::zincrby("road", -1, $team_match->guest->id);

                Redis::zincrby("streak", -1, $team_match->guest->id);
                Redis::zadd("streak", \Session::get('loserPreviousStreak:' . $id), $team_match->home->id);

                Redis::hmset(
                    "team:standings:{$team_match->guest->id}",
                    "points", intval(Redis::zscore("points", $team_match->guest->id)),
                    "wins", $winsWinner,
                    "losses", $lossesWinner,
                    "percentage", intval(Redis::zscore("percentage", $team_match->guest->id)),
                    "home", intval(Redis::zscore("home", $team_match->guest->id)),
                    "road", intval(Redis::zscore("road", $team_match->guest->id)),
                    "streak", intval(Redis::zscore("streak", $team_match->guest->id)));

                Redis::hmset(
                    "team:standings:{$team_match->home->id}",
                    "losses", intval(Redis::zscore("losses", $team_match->home->id)),
                    "percentage", intval(Redis::zscore("percentage", $team_match->home->id)),
                    "streak", intval(Redis::zscore("streak", $team_match->home->id)));
            }

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
