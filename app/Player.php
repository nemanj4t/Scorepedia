<?php

namespace App;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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
        //counter players
        Redis::incr("count:players");
        // Dodavanje globalne statistike za ovog igraca u redis
        PlayerStatistic::saveGlobalStats($player_id);
    }

    public static function getCurrentTeam($id)
    {
        // Vraca igracev trenutni tim
        $response = Cypher::Run
        ("MATCH (p:Player)-[:PLAYS]-(t:Team) WHERE ID(p) = {$id} return t")->getRecords();
        if($response != null) {
            $rec = $response[0];
            $current_team = array_merge(["id" => $rec->getIdOfNode()],
                $rec->getPropertiesOfNode());
            return $current_team;
        }
        else {
            return null;
        }
    }

    public static function getAllWithCurrentTeam()
    {
        $result = Cypher::run("MATCH (p:Player) OPTIONAL MATCH (p)-[:PLAYS]-(t:Team) return p, t");
        $players = [];

        foreach ($result->getRecords() as $record) {
            $player = $record->nodeValue('p');
            $player_props = $player->values();
            $player_id = ["id" => $player->identity()];
            $player = array_merge($player_id, $player_props);
            $player_team = ['player' => $player];

            if($record->value('t') != null) {
                $team = $record->nodeValue('t');
                $team_props = $team->values();
                $team_id = ["id" => $team->identity()];
                $team = array_merge($team_id, $team_props);
                $player_team += ['team' => $team];
            }
            array_push($players, $player_team);
        }

        return $players;
    }

    public static function getSomeWithCurrentTeam(array $ids)
    {
        $id_array = implode(', ', $ids);
        $result = Cypher::run("MATCH (p:Player) WHERE ID(p) IN [{$id_array}] OPTIONAL MATCH (p)-[:PLAYS]-(t:Team) return p, t");
        $players = [];

        foreach ($result->getRecords() as $record) {
            $player = $record->nodeValue('p');
            $player_props = $player->values();
            $player_id = ["id" => $player->identity()];
            $player = array_merge($player_id, $player_props);
            $player_team = ['player' => $player];

            if($record->value('t') != null) {
                $team = $record->nodeValue('t');
                $team_props = $team->values();
                $team_id = ["id" => $team->identity()];
                $team = array_merge($team_id, $team_props);
                $player_team += ['team' => $team];
            }
            $players += [$player['id'] => $player_team];
        }

        return $players;
    }

    public static function deletePlayer($id)
    {
        // Brise cvor i sve njegove veze
        Cypher::Run("MATCH (n:Player) WHERE ID(n) = $id DETACH DELETE n");
        PlayerStatistic::deleteStats($id);

        foreach(Redis::keys("match:*:team:*:{$id}") as $key) {
            Redis::del($key);
        };

        Redis::decr("count:players");
    }
}
