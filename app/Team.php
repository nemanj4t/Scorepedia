<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;

class Team extends Model
{
    public $id;
    public $name;
    public $short_name;
    public $city;
    public $players;
    public $captain;
    public $trainer;
    public $description;
    public $image;

    // Vraca sve timove
    public static function getTeams()
    {
        $result = Cypher::run("MATCH (n:Team) RETURN n");
        $teams = [];

        foreach($result->getRecords() as $record)
        {
            $properties_array = $record->getPropertiesOfNode();
            $id_array = ["id" =>  $record->getIdOfNode()];
            $team = array_merge($properties_array, $id_array);
            array_push($teams, $team);
        }
        return $teams;
    }
}
