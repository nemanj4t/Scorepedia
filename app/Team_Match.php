<?php

namespace App;

use Ahsan\Neo4j\Facade\Cypher;

class Team_Match
{
    public $home;
    public $guest;
    public $home_statistic;
    public $guest_statistic;

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
