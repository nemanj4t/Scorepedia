<?php

namespace App\Http\Controllers;

use App\PlayerStatistic;
use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;
use App\Player;

class StatisticController extends Controller
{
    public function index()
    {
        if(isset($_GET['show'])) {
            $show = $_GET['show'];
        }
        else {
            $show = 'short';
        }

        if($show == 'short') {
            // Top 5 stats
            $records = PlayerStatistic::getTopOfEach(5);
            $stats = [];
            foreach($records as $key => $set)
            {
                $statsSet = [];
                foreach($set as $id => $item)
                {
                    $result = Player::getById($id);
                    $player = [
                        "id" => $id,
                        "name" => $result['name'],
                        "score" => $item
                    ];
                    $team = Player::getCurrentTeam($id);
                    if($team != null) {
                        $player += ['team' => $team['short_name']];
                    }
                    array_push($statsSet, $player);
                }
                $stats += [$key => $statsSet];
            }
    
            return view('stats.index', compact('stats'));
        }
        else {
            return view('stats.full');
        }
    }

    public function full()
    {
        $result = Cypher::run("MATCH (n:Player) RETURN n");
        $players = [];

        foreach($result->getRecords() as $record)
        {
            $properties_array = $record->getPropertiesOfNode();
            unset($properties_array['image'], 
            $properties_array['city'],
            $properties_array['bio'],
            $properties_array['height'],
            $properties_array['weight']);
            $id = $record->getIdOfNode();
            $id_array = ["id" =>  $id];
            $stats = PlayerStatistic::getById($id);
            $player = array_merge($properties_array, $id_array, $stats);
            $team = Player::getCurrentTeam($id);
            if($team != null) {
                $player += ["team" => 
                    ["id" => $team['id'], "name" => $team['short_name']]];
            }
            array_push($players, $player);
        }

        return $players;
    }
}
