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
}
