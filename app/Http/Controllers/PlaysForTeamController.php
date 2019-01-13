<?php

namespace App\Http\Controllers;

use App\Player;
use App\Team_Coach;
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
//        $player_team = new Player_Team([
//            'player_id' => $id,
//            'team_id' => $request['team_id'],
//            'player_position' => $request['player_position'],
//            'player_number' => $request['player_number'],
//            'player_since' => $request['player_since'],
//            'player_until' => $request['player_until']
//        ]);

        foreach ($request['old_team'] as $data)

        {
            $player_team = new Player_Team();
            $player_team->position = $data['player_position'];
            $player_team->number = $data['player_number'];
            $player_team->played_since = $data['player_since'];
            $player_team->played_until = $data['player_until'];
            $player_team->player = Player::getById($id);
            $player_team->team = Team::getById($data['team_id']);
            $player_team->save();
        }

        return redirect('/players/' . $id)->with('success', 'Added Successfully');
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

        $player_team = new Player_Team;

        $player_team->player = Player::getById($id);
        $player_team->team = Team::getById($request['team_id']);
        $player_team->position = $request['position'];
        $player_team->number = $request['number'];
        $player_team->played_since = $request['since'];
        $player_team->played_until = $request['until'];

        $player_team->update();

        return redirect('/players/' . $id)->with('success', 'Updated');
    }

    public function destroy($id, Request $request)
    {
        Player_Team::delete($id, $request['team_id']);

        return redirect('/players/' . $id)->with('danger', 'Deleted!');
    }
}
