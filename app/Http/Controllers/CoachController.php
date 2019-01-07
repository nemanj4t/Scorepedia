<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Team;
use App\Team_Coach;
use GraphAware\Neo4j\Client\Formatter\Result;
use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coaches = Coach::getAll();

        return view('coaches.index', compact('coaches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::getAll();

        return view('coaches.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = Coach::saveCoach($request);
        $coach_id = $result->firstRecord()->getByIndex(0)->identity();

        $keys_array = ["team_name", "coached_since", "coached_until"];


        // <input type="text" name="team_name[0][5]">

        $count = 0;
        // Dok ne nadje prvi input za vezu tim_igrac koji je prazan
        while($request[$keys_array[0] . '_' . $count] != null)
        {
            $rel = array();
            $rel['coach_id'] = $coach_id;
            foreach($keys_array as $key)
            {
                $rel[$key] = $request[$key . "_" . $count];
            }
            $team_coach = new Team_Coach($rel);
            $team_coach->save();

            $count++;
        }


        return redirect('/apanel?active=Coach&route=coaches');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coach = Coach::getById($id);
        $coached_teams = Team_Coach::getByCoachId($id);

        $recPlayers = [];
        // Vraca trenere koji su nekada trenirali taj tim
        $current_team = Team_Coach::getCurrentForCoachId($coach->id);

        if ($current_team) {
            $current_team_id = $current_team->team_id;

            /** @var Result $recommendedResult */
            $recommendedResult = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) 
                WHERE ID(t) =". $current_team_id . " AND ID(c) <>" . (int)$id . " return distinct c LIMIT 5");

            foreach ($recommendedResult->getRecords() as $record) {
                $node = $record->value('c');
                $recCoach = Coach::buildFromNode($node);
                array_push($recPlayers, $recCoach);
            }
        }

        return view('coaches.show', compact('coach', 'recPlayers', 'coached_teams'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id) {
        $coach = Coach::getById($id);
        $teams = Team::getAll();
        return view("coaches.edit", compact('coach', 'teams'));
    }

    public function update(Request $request, $id)
    {
        //
        Coach::update($id, $request);

        return redirect("/coaches/" . $id);
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
        Coach::delete($id);

        // Fali brisanje tog cvora iz redisa

        return redirect('/apanel?active=Coach&route=coaches');
    }
}
