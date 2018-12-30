<?php

namespace App;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Player_Team;
use App\PlayerStatistic;

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

    public static function savePlayer(Request $request) {
        // Ovaj upit moze da vrati id na kraju
        Cypher::run("CREATE (:Player {name: '$request[name]', height: '$request[height]',
            weight: '$request[weight]', city: '$request[city]', bio: '$request[bio]', image: '$request[image]'})");

        $result = Cypher::run("MATCH (n:Player) WHERE n.name = '$request[name]' return ID(n)")->getRecords();
        $player_id = $result[0]->values()[0];
        $keys_array = ["team_name", "player_number", "player_position", "player_since", "player_until"];

        $count = 0;
        // Dok ne nadje prvi input za vezu tim_igrac koji je prazan
        while($request[$keys_array[0] . '_' . $count] != null)
        {
            $rel = array();
            $rel['player_id'] = $player_id;
            foreach($keys_array as $key)
            {
                $rel[$key] = $request[$key . "_" . $count];
            }
            $plays = new Player_Team($rel);
            $plays->save();

            $count++;
        }

        // Dodavanje globalne statistike za ovog igraca u redis
        PlayerStatistic::saveGlobalStats($player_id);
    }

}
