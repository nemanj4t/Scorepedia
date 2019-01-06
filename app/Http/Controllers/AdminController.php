<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Team;
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

       $data = [];
        switch ($active) {
            case "Team":
                $data = Team::getTeams();
                break;
            case "Player":
                $data = Player::getAllWithCurrentTeam();
                break;
            case "Coach":
                $data = Coach::getAll();
                break;
            case "Match":
                {
                    $allMatches = Match::getAll();
                    $liveMatches = [];
                    $finishedMatches = [];
                    $upcomingMatches = [];
                    foreach ($allMatches as $match)
                    {
                        if ($match['isFinished'])
                        {
                            array_push($finishedMatches, $match);
                        }
                        elseif (Match::isLive($match))
                        {
                            array_push($liveMatches, $match);
                        }
                        else
                        {
                            array_push($upcomingMatches, $match);
                        }
                    }

                    $data = array_merge(
                        $data,
                        ['live' => $liveMatches],
                        ['upcoming' => $upcomingMatches],
                        ['finished' => $finishedMatches]
                    );
                }
                break;
            case "Overview":
                break;
        }

        $count_visits = Redis::get('user:count');
        $count_matches = Redis::get('count:matches');
        $count_players = Redis::get('count:players');
        $count_coaches = Redis::get('count:coaches');
        $count_teams = Redis::get('count:teams');
        $count_logins = Redis::get('count:logins');

        return view('admin.home', compact('active', 'data', 'count_visits', 'count_coaches', 'count_matches', 'count_players', 'count_teams', 'count_logins'));
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

    public function postAddition($id, Request $request)
    {
        Redis::zincrby("players:{$request->key}", $request->value, $request->playerId);
        Redis::hincrby("match:{$id}:team:{$request->teamId}", $request->key, $request->value);
        Redis::hincrby("match:{$id}:team:{$request->teamId}:player:{$request->playerId}", $request->key, $request->value);
    }

}
