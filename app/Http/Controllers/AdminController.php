<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Match;
use App\PlayerStatistic;
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
        $count_visits = Redis::get('user:count');
        $count_matches = Redis::get('count:matches');
        $count_players = Redis::get('count:players');
        $count_coaches = Redis::get('count:coaches');
        $count_teams = Redis::get('count:teams');
        $count_logins = Redis::get('count:logins');

        return view('admin.home', compact(
            'count_visits', 'count_coaches', 'count_matches', 'count_players', 'count_teams', 'count_logins'));
    }
    //Return page where renders MatchManager.vue
    public function matchManager($id)
    {
        return view("admin.matchManager", compact('id'));
    }

    /**
     * @param $id
     * App\Match as json
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($id)
    {
        $match = Match::getById($id);

        foreach($match->team_match->guest->current_players as $player_team)
        {
            $player_team->player->statistics = PlayerStatistic::getStatsForMatch(
                $id, $match->team_match->guest->id, $player_team->player->id);
        }

        foreach($match->team_match->home->current_players as $player_team)
        {
            $player_team->player->statistics = PlayerStatistic::getStatsForMatch(
                $id, $match->team_match->home->id, $player_team->player->id);
        }

        return response()->json($match);
    }
    //Post request for statistic increment
    public function postAddition($id, Request $request)
    {
        Redis::zincrby("players:{$request->key}", $request->value, $request->playerId);
        Redis::hincrby("match:{$id}:team:{$request->teamId}", $request->key, $request->value);
        Redis::hincrby("match:{$id}:team:{$request->teamId}:player:{$request->playerId}", $request->key, $request->value);

        // Publishovanje izmenjenih poena nekog live matcha
        if($request->key === 'points') {
            $data = [
                'matchId' => $id,
                'teamId' => $request->teamId,
                'key' => $request->key,
                'value' => Redis::hget("match:{$id}:team:{$request->teamId}", $request->key),
            ];
            Redis::publish("liveMatches", json_encode($data));
        }
    }

    public function adminPlayers()
    {
        $data = Player::getAllWithCurrentTeam();

        return view('admin.players', compact('data'));
    }

    public function adminTeams()
    {
        $data = Team::getTeams();

        return view('admin.teams', compact('data'));
    }

    public function adminCoaches()
    {
        $data = Coach::getAll();

        return view('admin.coaches', compact('data'));
    }

    public function adminMatches()
    {
        $allMatches = Match::getAll();

        $liveMatches = [];
        $finishedMatches = [];
        $upcomingMatches = [];

        foreach ($allMatches as $match)
        {
            if ($match->isFinished)
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

        return view('admin.matches', compact('upcomingMatches', 'finishedMatches', 'liveMatches'));
    }
}
