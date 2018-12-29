<?php

namespace App\Http\Controllers;

use GraphAware\Bolt\Tests\Integration\Packing\PackingListIntegrationTest;
use Illuminate\Http\Request;
use App\Player_Team;
use App\Team;
use Ahsan\Neo4j\Facade\Cypher;

class PlaysForTeamController extends Controller
{
    public function edit($id)
    {
        $teams = Team::getTeams();
        $plays_for_teams = Player_Team::getByPlayerId($id);
        $player_id = $id;

        return view('players.playsForTeams', compact('plays_for_teams', 'player_id', 'teams'));
    }

    public function store($id, Request $request)
    {
//        // Validacija
//        $request->validate([
//            'team_id' => 'required',
//            'player_position' => 'required',
//            'player_number' => 'required|numeric',
//            'player_since' => 'required'
//        ]);

        // Kreiranje nove veze
        // $request['team_name'] ima zapravo vrednost id-ja tima
        $rel = new Player_Team([
            'player_id' => $id,
            'team_id' => $request['team_id'],
            'player_position' => $request['player_position'],
            'player_number' => $request['player_number'],
            'player_since' => $request['player_since'],
            'player_until' => $request['player_until']
        ]);
        $rel->save();

        return redirect('/players/' . $id);
    }

    public function update($id, Request $request)
    {
        // Validacija
//        $request->validate([
//            'team_id' => 'required',
//            'player_position' => 'required',
//            'player_number' => 'required|numeric',
//            'player_since' => 'required'
//        ]);

        $rel = new Player_Team([
            'player_id' => $id,
            'team_id' => $request['team_id'],
            'player_position' => $request['position'],
            'player_number' => $request['number'],
            'player_since' => $request['since'],
            'player_until' => $request['until']
        ]);
        $rel->update();

        return redirect('/players/' . $id);
    }

    public function destroy($id, Request $request)
    {
        Player_Team::delete($id, $request['team_id']);

        return redirect('/players/' . $id);
    }
}
