<?php

namespace App\Http\Controllers;

use App\Comment;
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

    // Axios gadja ovo
    public function getData()
    {
        $matches = Match::getAll();

        $liveMatches = [];
        $finishedMatches = [];
        $upcomingMatches = [];

        foreach ($matches as $match)
        {
            $match->carbon = (new Carbon($match->date." ".$match->time, 'Europe/Belgrade'))->diffForHumans();
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

        return compact('liveMatches', 'finishedMatches', 'upcomingMatches');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Testiranje
        return view('matches.indexvue');
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
        $comments = Comment::getAllCommentsByMatchId($id);

        return view("matches.show", compact('match', 'comments'));
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
