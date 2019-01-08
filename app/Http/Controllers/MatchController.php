<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Ahsan\Neo4j\Facade\Cypher;
use App\Team;
use App\PlayerStatistic;
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
            if ($match->isFinished)
            {
                $finishedMatches[] = $match;
            }
            elseif (Match::isLive($match))
            {
                $liveMatches[] = $match;
            }
            else
            {
                $upcomingMatches[] = $match;
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
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'hometeam' => 'required',
            'guestteam' => 'required'
        ]);
        //can't pick a past date
        if(Carbon::now() > (new Carbon($request->date." ".$request->time)))
        {
            return redirect('/matches/create');
        }

        Match::saveMatch($request);

        return redirect('/apanel/matches');
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
        if($match === null)
        {
            return abort(404);
        }

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

        return view("matches.show", compact('match'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
        Match::deleteMatch($id);

        return redirect('/apanel/matches');
    }
}
