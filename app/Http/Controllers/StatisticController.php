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
            $ids = [];
            foreach($records as $set) {
                $ids += array_keys($set);
            }
            $players = Player::getSomeWithCurrentTeam($ids);

            $stats = [];
            foreach($records as $key => $set) 
            {
                $statsSet = [];
                foreach($set as $id => $item)
                {
                    $player = ["id" => $id, "score" => $item];
                    $player += ['name' => $players[$id]['player']['name']];
                    if(isset($players[$id]['team'])) {
                        $player += ['team' => $players[$id]['team']['short_name']];
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
        $records = Player::getAllWithCurrentTeam();
        $players = [];

        foreach($records as $record)
        {
            $player = ['id' => $record['player']['id'], 'name' => $record['player']['name']];
            if(isset($record['team'])) {
                $player += ['team' => 
                    ['id' => $record['team']['id'], 
                    'name' => $record['team']['short_name']]];
            }
            $stats = PlayerStatistic::getById($record['player']['id']);
            $player = array_merge($player, $stats);
            array_push($players, $player);
        }

        return $players;
    }
}
