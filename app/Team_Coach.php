<?php

namespace App;

use Carbon\Carbon;
use GraphAware\Neo4j\Client\Formatter\RecordView;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use Ahsan\Neo4j\Facade\Cypher;
use GraphAware\Neo4j\Client\Formatter\Type\Relationship;


class Team_Coach
{
    public $team_id;
    public $coach_id;
    public $coached_since;
    public $coached_until;

    /** @var Team */
    public $team;

    /** @var Coach */
    public $coach;


    /**
     * @param Node $teamNode
     * @param Node $coachNode
     * @param Relationship $relationship
     * @return Team_Coach
     */
    public static function buildFromNodesAndRelationship(Node $teamNode, Node $coachNode, Relationship $relationship)
    {
        $team_coach = new Team_Coach();
        $team_coach->coach_id = $coachNode->identity();
        $team_coach->team_id = $teamNode->identity();
        $team_coach->coached_since = $relationship->value('coached_since');
        $team_coach->coached_until = $relationship->value('coached_until');

        $team_coach->team = Team::buildFromNode($teamNode);
        $team_coach->coach = Coach::buildFromNode($coachNode);

        return $team_coach;
    }

    public function save()
    {
        Cypher::Run ("MATCH (t:Team), (c:Coach) WHERE ID(t) = " . $this->team_id . " AND ID(c) = " . $this->coach_id .
            " CREATE (t)-[:TEAM_COACH {
        coached_since: '" . $this->coached_since . "', 
        coached_until: '" . $this->coached_until. "'
        }]->(c)");

    }

    public function update()
    {
        Cypher::Run ("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) 
            WHERE ID(t) = " . $this->team_id . " AND ID(c) = " . $this->coach_id .
            " SET r.coached_since = '" .$this->coached_since . "', 
                r.coached_until = '" . $this->coached_until. "'");
    }


    /**
     * @param $id
     * @return Team_Coach|null
     */
    public static function getCurrentForCoachId($id)
    {
        $now = Carbon::now()->format('Y-m-d');

        /** @var Result $result */
        $result = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(c) = $id AND r.coached_since <= '$now' AND r.coached_until >= '$now' RETURN r, t, c
                      ORDER BY r.coached_until DESC LIMIT 1");

        try {
            $record = $result->getRecord();
        } catch (\RuntimeException $e) {
            return null;
        }

        $relationship = $record->value('r');
        /** @var Node $nodeTeam */
        $nodeTeam = $record->value('t');
        /** @var Node $nodeCoach */

        $team_coach = new Team_Coach();
        $team_coach->coach_id = $id;
        $team_coach->team_id = $nodeTeam->identity();
        $team_coach->coached_since = $relationship->value('coached_since');
        $team_coach->coached_until = $relationship->value('coached_until');
        $team_coach->team = Team::getTeamById($team_coach->team_id);


        return $team_coach;
    }


    /**
     * @param $id
     * @return Team_Coach|null
     */
    public static function getCurrentForTeamId($id)
    {
        $now = Carbon::now()->format('Y-m-d');

        /** @var Result $result */
        $result = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(t) = $id AND r.coached_since <= '$now' AND r.coached_until >= '$now' RETURN r, t, c
                      ORDER BY r.coached_until DESC LIMIT 1");

        try {
            $record = $result->getRecord();
        } catch (\RuntimeException $e) {
            return null;
        }

        $relationship = $record->value('r');
        /** @var Node $nodeTeam */
        $nodeTeam = $record->value('t');
        /** @var Node $nodeCoach */
        $nodeCoach = $record->value('c');

        $team_coach = new Team_Coach();
        $team_coach->coach_id = $nodeCoach->identity();
        $team_coach->team_id = $id;
        $team_coach->coached_since = $relationship->value('coached_since');
        $team_coach->coached_until = $relationship->value('coached_until');
        $team_coach->coach = Coach::buildFromNode($nodeCoach);
        $team_coach->team = Team::buildFromNode($nodeTeam);

        return $team_coach;
    }


    /**
     * @param $id
     * @return Team_Coach
     */
    public static function getByCoachId($id)
    {
        /** @var Result $result */
        $result= Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(c) = $id return r, t, c
                      ORDER BY r.coached_until DESC");

        /** @var \App\Team_Coach $team_coach_array */
        $team_coach_array = [];

        /** @var RecordView[] $records */
        $records = $result->getRecords();

        foreach ($records as $record) {
            // Vraca vrednosti za tim za koji igrac igra

            /** @var Relationship $relationship */
            $relationship = $record->value('r');

            /** @var Node $teamNode */
            $teamNode = $record->value('t');

            /** @var Node $coachNode */
            $coachNode = $record->value('c');


            $team_coach = new Team_Coach();
            $team_coach->coach_id = $id;
            $team_coach->team_id = $teamNode->identity();
            $team_coach->coached_since = $relationship->value('coached_since');
            $team_coach->coached_until = $relationship->value('coached_until');
            $team_coach->team = Team::buildFromNode($teamNode);


            array_push($team_coach_array, $team_coach);
        }
        return $team_coach_array;
    }

    /**
     * @param $id
     * @return Team_Coach[]
     */
    public static function getByTeamId($id)
    {
        /** @var Result $result */
        $result= Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(t) = $id return r, c, t
                      ORDER BY r.coached_until DESC");

        /** @var \App\Team_Coach[] $team_coach_array */
        $team_coach_array = [];

        /** @var RecordView[] $records */
        $records = $result->getRecords();

        foreach ($records as $record) {
            // Vraca vrednosti za tim za koji igrac igra

            /** @var Relationship $relationship */
            $relationship = $record->value('r');

            /** @var Node $teamNode */
            $teamNode = $record->value('t');

            /** @var Node $coachNode */
            $coachNode = $record->value('c');


            $team_coach = new Team_Coach();
            $team_coach->coach_id = $id;
            $team_coach->team_id = $teamNode->identity();
            $team_coach->coached_since = $relationship->value('coached_since');
            $team_coach->coached_until = $relationship->value('coached_until');
            $team_coach->coach = Coach::buildFromNode($coachNode);


            array_push($team_coach_array, $team_coach);
        }
        return $team_coach_array;

    }

    /**
     * @param $request
     * @param $teamId
     * @return Team_Coach
     */
    public static function createFromRequest($request, $teamId)
    {
        $team_coach = new Team_Coach();
        $team_coach->coached_since = $request->coached_since;
        $team_coach->coached_until = $request->coached_until;
        $team_coach->coach_id = $request->coach;
        $team_coach->team_id = $teamId;

        $team_coach->coach = Coach::getById($team_coach->coach_id);
        $team_coach->team = Team::getById($teamId);

        return $team_coach;
    }

    public static function delete($team_id, $coach_id)
    {
        Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach)
            WHERE ID(t) = ".$team_id." AND ID(c) = ".$coach_id.
            " DELETE r");
    }
}

