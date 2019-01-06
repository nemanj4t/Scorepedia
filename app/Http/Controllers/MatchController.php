<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Ahsan\Neo4j\Facade\Cypher;
use App\Team;
use App\Match;
use App\Player;
use Carbon\Carbon;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = Match::getAll();
        $liveMatches = [];
        $finishedMatches = [];
        $upcomingMatches = [];
        foreach ($matches as $match)
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

        return view('matches.index', compact('liveMatches', 'finishedMatches', 'upcomingMatches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::getTeams();

        return view('matches.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //can't pick a past date
        if(Carbon::now() > (new Carbon($request->date." ".$request->time)))
        {
            return redirect('/matches/create');
        }

        Match::saveMatch($request);

        return redirect('/apanel?active=Match&route=matches');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $match = Match::getById($id);

        $home = Redis::hgetall("match:{$id}:team:{$match['home']['id']}");
        $guest = Redis::hgetall("match:{$id}:team:{$match['guest']['id']}");

        $homePlayers = [];
        $guestPlayers = [];

        foreach(Redis::keys("*match:{$id}:team:{$match['home']['id']}:*") as $key) {
            $playerIndex = intval(explode(":", $key)[5]);
            $player = Player::getById($playerIndex);
            $player->statistics = Redis::hgetall($key);
            array_push($homePlayers, $player);
        };

        foreach(Redis::keys("*match:{$id}:team:{$match['guest']['id']}:*") as $key) {
            $playerIndex = intval(explode(":", $key)[5]);
            $player = Player::getById($playerIndex);
            $player->statistics = Redis::hgetall($key);
            array_push($guestPlayers, $player);
        };

        return view("matches.show", compact('match', 'home', 'guest', 'homePlayers', 'guestPlayers'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Match::finishMatch($request->matchId, $request->finished);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Brise cvor i sve njegove veze
        Cypher::Run("MATCH (m:Match) WHERE ID(m) = $id DETACH DELETE m");

        // Fali brisanje tog cvora iz redisa

        return redirect('/apanel?active=Match&route=matches');
    }
}
