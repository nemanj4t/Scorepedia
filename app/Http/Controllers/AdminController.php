<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Support\Facades\Redis;
use App\Match;
use App\Player;

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

    public function matchManager($id)
    {
        return view("admin.matchManager", compact('id'));
    }

    public function data($id)
    {
        $match = Match::getById($id);

        $home = Redis::hgetall("match:{$id}:team:{$match['home']['id']}");
        $guest = Redis::hgetall("match:{$id}:team:{$match['guest']['id']}");

        $homePlayers = [];
        $guestPlayers = [];

        foreach(Redis::keys("*match:{$id}:team:{$match['home']['id']}:*") as $key) {
            $playerIndex = intval(explode(":", $key)[5]);
            $player = Player::getById($playerIndex);
            $stats = Redis::hgetall($key);
            $player = array_merge($player, $stats);
            array_push($homePlayers, $player);
        };

        foreach(Redis::keys("*match:{$id}:team:{$match['guest']['id']}:*") as $key) {
            $playerIndex = intval(explode(":", $key)[5]);
            $player = Player::getById($playerIndex);
            $stats = Redis::hgetall($key);
            $player = array_merge($player, $stats);
            array_push($guestPlayers, $player);
        };

        $data = [
            'match' => $match,
            'home' => $home,
            'guest' => $guest,
            'homePlayers' => $homePlayers,
            'guestPlayers' => $guestPlayers
        ];

        return $data;
    }

    public function postAddition($id, Request $request) {
        Redis::zincrby("players:{$request->key}", $request->value, $request->playerId);
        Redis::hincrby("match:{$id}:team:{$request->teamId}", $request->key, $request->value);
        Redis::hincrby("match:{$id}:team:{$request->teamId}:player:{$request->playerId}", $request->key, $request->value);
    }
}
