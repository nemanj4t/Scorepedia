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
        $teams = Team::getTeams();
        $team_coach = Team_Coach::getByCoachId($id);
        $coach_id = $id;

        return view('coaches.team_coach', compact('team_coach', 'coach_id', 'teams'));
    }

    public function store($id, Request $request)
    {
        $request->validate([
            'old_team.*.coached_since' => 'required|date|date_format:Y-m-d|before:today',
            'old_team.*.coached_until' => 'required|date|date_format:Y-m-d|before:yesterday',
        ]);
        if (isset ($request['old_team']))
            foreach ($request['old_team'] as $data)
            {
                $team_coach = new Team_Coach();
                $team_coach->coach_id = $id;
                $team_coach->team_id = $data['team_id'];
                $team_coach->coached_since = $data['coached_since'];
                $team_coach->coached_until = $data['coached_until'];
                $team_coach->save();
            }

        return redirect('/coaches/' . $id)->with('success', 'Added successfully');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'prev_name' => 'required',
            'coached_since' => 'required',
            'coached_until' => 'required',
        ]);

        $team_coach = new Team_Coach();
        $team_coach->team_id = $request['team_id'];
        $team_coach->coach_id = $id;
        $team_coach->coached_since = $request['coached_since'];
        $team_coach->coached_until = $request['coached_until'];
        $team_coach->update();

        return redirect('/coaches/' . $id)->with('success', 'Updated');
    }

    public function destroy($id, Request $request)
    {

        Team_Coach::delete($request['team_id'], $id);

        return redirect('/coaches/' . $id)->with('danger', 'Deleted!');
    }
}
