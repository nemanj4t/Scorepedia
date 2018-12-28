<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Facade;


class Team_Coach
{
    //
    public $team_id;
    public $coach_id;
    public $coached_since;
    public $coached_until;

    public function __construct($props)
    {
        $this->coach_id = $props["coach_id"];
        $this->team_id = $props['team_name'];
        $this->coached_since = $props['coached_since'];
        $this->coached_until = $props['coached_until'];
    }

    public function save()
    {

       // $coached_since = \Carbon\Carbon::createFromFormat("Y-m-d", $this->coached_since)->format("Ymd");
       // $coached_until = \Carbon\Carbon::createFromFormat("Y-m-d", $this->coached_until)->format("Ymd");
        Cypher::Run ("MATCH (t:Team), (c:Coach) WHERE ID(t) = " . $this->team_id . " AND ID(c) = " . $this->coach_id .
            " CREATE (t)-[:TEAM_COACH {
        coached_since: '" . $this->coached_since . "', 
        coached_until: '" . $this->coached_until. "'
        }]->(c)");

    }

    public function update()
    {

        //$coached_since = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_since)->format("Ymd");
        //$coached_until = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_until)->format("Ymd");
        Cypher::Run ("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) 
            WHERE ID(t) = " . $this->team_id . " AND ID(c) = " . $this->coach_id .
            " SET r.coached_since = '" .$this->coached_since . "', 
                r.coached_until = '" . $this->coached_until. "'");
    }


    public static function getByCoachId($id)
    {
        $teamsResult = Cypher::Run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(c) = $id return r, t
                      ORDER BY r.coached_until DESC");

        $team_coach = [];

        foreach ($teamsResult->getRecords() as $record) {
            // Vraca vrednosti za tim za koji igrac igra
            $team = $record->nodeValue('t');
            $team_props = $team->values();
            $team_id = ["id" => $team->identity()];

            // Vraca vrednosti za relaciju PLAYS_FOR_TEAM
            $relationship = $record->relationShipValue('r');
            $relationship_props = $relationship->values();
            $relationship_id = ["id" => $relationship->identity()];

            // Spaja kljuceve i propertije
            $team = array_merge($team_props, $team_id);
            $rel_info = array_merge($relationship_props, $relationship_id);

            // Niz koji sadrzi relaciju i tim
            $one_rel = ['coached' => $rel_info, 'team' => $team];

            array_push($team_coach, $one_rel);
        }
        return $team_coach;
    }

    public static function getByTeamId($id)
    {
        $teamsResult = Cypher::Run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(t) = $id return r, c
                      ORDER BY r.coached_until DESC");

        $team_coach = [];

        foreach ($teamsResult->getRecords() as $record) {
            // Vraca vrednosti za tim za koji igrac igra
            $coach = $record->nodeValue('c');
            $coach_props = $coach->values();
            $coach_id = ["id" => $coach->identity()];

            // Vraca vrednosti za relaciju PLAYS_FOR_TEAM
            $relationship = $record->relationShipValue('r');
            $relationship_props = $relationship->values();
            $relationship_id = ["id" => $relationship->identity()];

            // Spaja kljuceve i propertije
            $coach = array_merge($coach_props, $coach_id);
            $rel_info = array_merge($relationship_props, $relationship_id);

            // Niz koji sadrzi relaciju i tim
            $one_rel = ['coached' => $rel_info, 'coach' => $coach];

            array_push($team_coach, $one_rel);
        }
        return $team_coach;
    }
    public static function delete($team_id, $coach_id)
    {
        Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach)
            WHERE ID(t) = ".$team_id." AND ID(c) = ".$coach_id.
            " DELETE r");
    }

}

