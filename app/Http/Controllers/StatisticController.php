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
                    $player += ['name' => $players[$id]->name];
                    if($players[$id]->current_team) {
                        $player += ['team' => $players[$id]->current_team->short_name];
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
        $players = Player::getAllWithCurrentTeam();
        $data = [];

        foreach($players as $player)
        {
            $row = [
                'id' => $player->id,
                'name' => $player->name
            ];

            if($player->current_team) {
                $row += [
                    'team' => [
                        'id' => $player->current_team->id,
                        'name' => $player->current_team->short_name
                    ]
                ];
            }

            $stats = PlayerStatistic::getById($player->id);
            $row = array_merge($row, $stats);
            array_push($data, $row);
        }

        return $data;
    }
}
