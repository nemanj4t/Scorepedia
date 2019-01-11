<?php

namespace App;

use Ahsan\Neo4j\Facade\Cypher;

class Team_Match
{
    /** @var Team $home*/
    public $home;
    /** @var Team  $guest*/
    public $guest;
    /** @var TeamStatistic $home_statistic */
    public $home_statistic;
    /** @var TeamStatistic $guest_statistic*/
    public $guest_statistic;


    /**
     * @param $matchId
     * @return Team_Match
     */
    public static function getByMatchId($matchId)
    {
        $query = Cypher::run("MATCH (t:Team)-[r:TEAM_MATCH]->(m:Match) WHERE ID(m) = $matchId RETURN r, t");

        $team_match = new Team_Match();

        foreach($query->getRecords() as $record)
        {
            $node = $record->value('t');
            $relationship = $record->value('r');
            $status = $relationship->value('status');

            if($status === 'home')
            {
                $team_match->home = Team::buildFromNode($node);
                $team_match->home_statistic = TeamStatistic::getPointsForTeamMatch(
                    $node->identity(), $matchId);
            }
            else {
                $team_match->guest = Team::buildFromNode($node);
                $team_match->guest_statistic = TeamStatistic::getPointsForTeamMatch(
                    $node->identity(), $matchId);
            }
        }

        return $team_match;
    }

    /**
     * @param $matchId
     * @return Team_Match
     */
    public static function getByMatchIdForShow($matchId)
    {
        $query = Cypher::run("MATCH (t:Team)-[r:TEAM_MATCH]->(m:Match) WHERE ID(m) = $matchId RETURN r, t");

        $team_match = new Team_Match();

        foreach($query->getRecords() as $record)
        {
            $node = $record->value('t');
            $relationship = $record->value('r');
            $status = $relationship->value('status');

            if($status === 'home')
            {
                $team_match->home = Team::getById($node->identity());
                $team_match->home_statistic = TeamStatistic::getStatisticForTeamMatch(
                    $node->identity(), $matchId);
            }
            else {
                $team_match->guest = Team::getById($node->identity());
                $team_match->guest_statistic = TeamStatistic::getStatisticForTeamMatch(
                    $node->identity(), $matchId);
            }
        }

        return $team_match;
    }
}
