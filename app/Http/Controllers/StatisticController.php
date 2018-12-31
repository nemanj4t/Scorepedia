<?php

namespace App\Http\Controllers;

use App\PlayerStatistic;
use Illuminate\Http\Request;
use App\Player;

class StatisticController extends Controller
{
    public function index()
    {
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
                array_push($statsSet, $player);
            }
            $stats += [$key => $statsSet];
        }
        return view('stats.index', compact('stats'));
    }

    public function full()
    {
        // Full stats
    }
}
