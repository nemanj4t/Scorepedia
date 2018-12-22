<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Facade;

class Player_Team
{
    public $position;
    public $number;
    public $team_id;
    public $player_id;
    public $plays_since;
    public $plays_until;

    public function __construct($props)
    {
        $this->player_id = $props["player_id"];
        $this->team_id = $props['team_name'];
        $this->position = $props['player_position'];
        $this->number = $props['player_number'];
        $this->plays_since = $props['player_since'];
        $this->plays_until = $props['player_until'];
    }

    public function save()
    {
        if($this->plays_until)
        {
            $plays_since = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_since)->format("Ymd");
            $plays_until = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_until)->format("Ymd");
            Cypher::Run ("MATCH (n:Player), (t:Team) WHERE ID(n) = " . $this->player_id . " AND ID(t) = " . $this->team_id .
                " CREATE (n)-[:PLAYS_FOR_TEAM {
            position: '" . $this->position . "', 
            number: " . $this->number . ", 
            since: " . $plays_since . ",  
            until: " . $plays_until . "
            }]->(t)");
        }
        else
        {
            $plays_since = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_since)->format("Ymd");
            Cypher::Run ("MATCH (n:Player), (t:Team) WHERE ID(n) = " . $this->player_id . " AND ID(t) = " . $this->team_id .
                " CREATE (n)-[:PLAYS_FOR_TEAM {
            position: '" . $this->position . "', 
            number: " . $this->number . ", 
            since: " . $plays_since . "  
            }]->(t)");
        }
    }

    // Vraca timove u kojima je igrac sa datim '$id' igrao
    public static function getByPlayerId($id)
    {
        $teamsResult = Cypher::Run("MATCH (n:Player)-[r:PLAYS_FOR_TEAM]-(t:Team) WHERE ID(n) = $id return r, t
                      ORDER BY r.until DESC");

        $plays_for_teams = [];

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
            $plays_for_team = array_merge($relationship_props, $relationship_id);

            // Niz koji sadrzi relaciju i tim
            $plays = ['plays_for' => $plays_for_team, 'team' => $team];

            array_push($plays_for_teams, $plays);
        }
        return $plays_for_teams;
    }
}
