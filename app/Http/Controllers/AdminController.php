<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Support\Facades\Redis;
use App\Match;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['active'])) {
            $active = $_GET['active'];
        }
        else {
            $active = "Overview";
        }

        $result = Cypher::run("MATCH (n:$active) RETURN n");
        $data = [];
        switch ($active) {
            case "Team":
                foreach($result->getRecords() as $record) {
                    $id = $record->getIdOfNode();
                    $properties = $record->getPropertiesOfNode();
                    $team = new \App\Team;
                    $team->id = $id;
                    $team->name = $properties['name'];
                    $team->city = $properties['city'];
                    $team->image = $properties['image'];
                    array_push($data, $team);
                }
                break;
            case "Player":
                foreach($result->getRecords() as $record) {
                    $id = $record->getIdOfNode();
                    $properties = $record->getPropertiesOfNode();
                    $player = new \App\Player;
                    $player->id = $id;
                    $player->name = $properties['name'];
                    $player->city = $properties['city'];
                    $player->image = $properties['image'];
                    array_push($data, $player);
                }
                break;
            case "Coach":
                foreach($result->getRecords() as $record) {
                    $id = $record->getIdOfNode();
                    $properties = $record->getPropertiesOfNode();
                    $coach = new \App\Coach;
                    $coach->id = $id;
                    $coach->name = $properties['name'];
                    $coach->city = $properties['city'];
                    $coach->image = $properties['image'];
                    array_push($data, $coach);
                }
                break;
            case "Match":
                $data = Match::getAll();
                break;
            case "Overview":
                break;
        }

        $count = Redis::get('user:count');

        return view('admin.home', compact('active', 'data', 'count'));
    }
}
