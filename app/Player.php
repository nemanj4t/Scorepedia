<?php

namespace App;

use Ahsan\Neo4j\Facade\Cypher;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class Player
{
    public $id;
    public $name;
    public $city;
    public $image;
    public $bio;
    public $height;
    public $weight;

    /** @var Team */
    public $current_team;
    public $past_teams;
    public $statistics = [];

    public static function buildFromNode(Node $node)
    {
        $player = new Player();
        $player->id = $node->identity();
        $player->name = $node->value('name');
        $player->city = $node->value('city', null);
        $player->image = $node->value('image', null);
        $player->bio = $node->value('bio', null);
        $player->height = $node->value('height', null);
        $player->weight = $node->value('weight', null);

        return $player;
    }

    public static function getById($id){
        $query = Cypher::run("MATCH (p:Player) WHERE ID(p) = {$id} RETURN p");
        $node = $query->firstRecord()->nodeValue('p');
        $player = self::buildFromNode($node);

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

    /**
     * @param $id
     * @return Team|null
     */
    public static function getCurrentTeam($id)
    {
        /** @var Result $result */
        $result = Cypher::run("MATCH (p:Player)-[:PLAYS]-(t:Team) WHERE ID(p) = {$id} return t");

        try {
            $record = $result->getRecord();
        } catch (\RuntimeException $exception) {
            return null;
        }

        $node = $record->value('t');

        $team = Team::buildFromNode($node);

        return $team;
    }

    /**
     * @return Player[]
     */
    public static function getAllWithCurrentTeam()
    {
        /** @var Result $result */
        $result = Cypher::run("MATCH (p:Player) OPTIONAL MATCH (p)-[:PLAYS]-(t:Team) return p, t");
        $players = [];

        foreach ($result->getRecords() as $record) {
            $playerNode = $record->value('p');
            $player = self::buildFromNode($playerNode);
            $player->current_team = null;

            if ($record->value('t')) {
                $teamNode = $record->value('t');
                $team = Team::buildFromNode($teamNode);

                $player->current_team = $team;
            }

            $players[] = $player;
        }

        return $players;
    }

    /**
     * @param array $ids
     * @return Player[]
     */
    public static function getSomeWithCurrentTeam(array $ids)
    {
        $id_array = implode(', ', $ids);
        $result = Cypher::run("MATCH (p:Player) WHERE ID(p) IN [{$id_array}] OPTIONAL MATCH (p)-[:PLAYS]-(t:Team) return p, t");
        $players = [];

        foreach ($result->getRecords() as $record) {
            $playerNode = $record->nodeValue('p');

            $player = Player::buildFromNode($playerNode);

            if($record->value('t') != null) {
                $teamNode = $record->nodeValue('t');
                $team = Team::buildFromNode($teamNode);
                $player->current_team = $team;
            }

            $players[$player->id] = $player;
        }

        return $players;
    }
}
