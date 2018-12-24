<?php

namespace App\Http\Controllers;

use App\Team_Coach;
use App\Team;
use Illuminate\Http\Request;

class TeamCoachController extends Controller
{
    //
    public function edit($id)
    {
        $teams = Team::getAll();
        $team_coach = Team_Coach::getByCoachId($id);
        $coach_id = $id;

        return view('coaches.team_coach', compact('team_coach', 'coach_id', 'teams'));
    }

    public function store($id, Request $request)
    {
        // Kreiranje nove veze
        // $request['team_name'] ima zapravo vrednost id-ja tima
        $rel = new Team_Coach([
            'coach_id' => $id,
            'team_name' => $request['team_name'],
            'coached_since' => $request['coached_since'],
            'coached_until' => $request['coached_until']
        ]);
        $rel->save();

        return redirect('/coaches/' . $id);
    }

    public function update($id, Request $request)
    {
        $rel = new Team_Coach([
            'coach_id' => $id,
            'team_name' => $request['team_id'],
            'coached_since' => $request['since'],
            'coached_until' => $request['until']
        ]);
        $rel->update();

        return redirect('/coaches/' . $id);
    }

    public function destroy($id, Request $request)
    {
        Team_Coach::delete($request['team_id'], $id);

        return redirect('/coaches/' . $id);
    }
}
