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
        $this->team_id = $props['team_id'];
        $this->position = $props['player_position'];
        $this->number = $props['player_number'];
        $this->plays_since = $props['player_since'];
        $this->plays_until = $props['player_until'];
    }

    public function save()
    {
        $plays_since = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_since)->format("Ymd");


        if($this->plays_until)
        {
            $plays_until = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_until)->format("Ymd");

            // umesto TEAM_PLAYER je PLAYED ili PLAYS
            Cypher::Run ("MATCH (n:Player), (t:Team) WHERE ID(n) = " . $this->player_id . " AND ID(t) = " . $this->team_id .
                " CREATE (n)-[:PLAYED {
            position: '" . $this->position . "', 
            number: " . $this->number . ", 
            since: " . $plays_since . ",  
            until: " . $plays_until . "
            }]->(t)");
        }
        else
        {
            Cypher::Run ("MATCH (n:Player), (t:Team) WHERE ID(n) = " . $this->player_id . " AND ID(t) = " . $this->team_id .
                " CREATE (n)-[:PLAYS {
            position: '" . $this->position . "', 
            number: " . $this->number . ", 
            since: " . $plays_since . "  
            }]->(t)");
        }
    }

    public function update()
    {
        $plays_since = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_since)->format("Ymd");
        // Proveri se koja je veza bila ranije
        $relType = Cypher::Run ("MATCH (p:Player)-[r]-(t:Team) WHERE ID(p) = " . $this->player_id .
            " AND ID(t) = " . $this->team_id . " RETURN type(r)")->getRecords()[0]->value("type(r)");

        if($this->plays_until)
        {
            $plays_until = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_until)->format("Ymd");
            // Ako je i ranije bila PLAYED onda se samo menja atribut "until"
            if($relType == "PLAYED")
            {
                Cypher::Run ("MATCH (p:Player)-[r:PLAYED]-(t:Team) 
                WHERE ID(p) = " . $this->player_id . " AND ID(t) = " . $this->team_id .
                    " SET r.position = '" . $this->position . "', 
                    r.number = " . $this->number . ", 
                    r.since = " . $plays_since . ",  
                    r.until = " . $plays_until);
            }
            else
            {
                // Ako je bila PLAYS onda se prethodna veza zamenjuje vezom PLAYED
                Cypher::Run ("MATCH (p:Player)-[r:PLAYS]-(t:Team) WHERE ID(p) = ". $this->player_id .
                    " AND ID(t) = ". $this->team_id .
                    " CREATE (p)-[r2:PLAYED]->(t) 
                        SET r2 = r,
                        r2.position = '" . $this->position . "',
                        r2.number = " . $this->number . ",
                        r2.since = " . $plays_since . ",
                        r2.until = " . $plays_until .
                        " WITH r
                        DELETE r");
            }
        }
        else
        {
            // Ako je bilo PLAYED i a treba da se promeni u PLAYS
            if($relType == "PLAYED")
            {
                Cypher::Run ("MATCH (p:Player)-[r:PLAYED]-(t:Team) WHERE ID(p) = ". $this->player_id .
                    " AND ID(t) = ". $this->team_id .
                    " CREATE (p)-[r2:PLAYS]->(t) 
                        SET r2 = r,
                        r2.position = '" . $this->position . "',
                        r2.number = " . $this->number . ",
                        r2.since = " . $plays_since . ",
                        r2.until = null 
                         WITH r
                        DELETE r");
            }
            else
            {
                // Ako je bilo PLAYED i ako je i dalje PLAYS
                Cypher::Run("MATCH (p:Player)-[r:PLAYS]-(t:Team) 
                WHERE ID(p) = " . $this->player_id . " AND ID(t) = " . $this->team_id .
                    " SET r.position = '" . $this->position . "', 
                    r.number = " . $this->number . ", 
                    r.since = " . $plays_since);
            }

        }
    }

    // Vraca timove u kojima je igrac sa datim '$id' igrao
    public static function getByPlayerId($id)
    {
        $teamsResult = Cypher::Run("MATCH (n:Player)-[r:PLAYS|PLAYED]-(t:Team) WHERE ID(n) = $id return r, t
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

    // Brisanje veze
    public static function delete($player_id, $team_id)
    {
        Cypher::run("MATCH (n:Player)-[r:PLAYS|PLAYED]-(t:Team)
            WHERE ID(n) = ".$player_id." AND ID(t) = ".$team_id.
            " DELETE r");
    }
}
