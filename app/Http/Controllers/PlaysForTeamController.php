<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player_Team;

class PlaysForTeamController extends Controller
{
    public function edit($id)
    {
        $plays_for_teams = Player_Team::getByPlayerId($id);
        $player_id = $id;
        //dd($plays_for_teams);
        return view('players.playsForTeams', compact('plays_for_teams', 'player_id'));

    }

    public function update($id, Request $request)
    {

    }

    public function destroy()
    {

    }
}
