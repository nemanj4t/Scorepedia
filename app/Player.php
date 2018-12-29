<?php

namespace App;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $id;
    public $name;
    public $city;
    public $current_team;
    public $past_teams;
    public $number;
    public $statistics;
    public $image;
    public $bio;
    public $height;
    public $weight;

    public static function getById($id){
        $query = Cypher::run("MATCH (p:Player) WHERE ID(p) = {$id} RETURN p");
        $playerProps = $query->firstRecord()->values()[0]->values();
        $player = array_merge($playerProps, ['id' => $id]);

        return $player;
    }

}
