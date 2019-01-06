<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;

class Player_Match extends Model
{
    public $player_id;
    public $match_id;

    public static function savePlayerMatch($playerId, $matchId)
    {
        Cypher::Run("MATCH (p:Player), (m:Match) WHERE ID(p)=$playerId AND ID(m)=$matchId CREATE (p)-[r:PLAYER_MATCH]->(m)");
    }
}
