<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Team;
use App\Team_Coach;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;
use Symfony\Component\HttpKernel\Tests\DependencyInjection\ContainerAwareRegisterTestController;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coach = new Coach();
        $coaches = $coach->getAll();
        return view('coaches.index', compact('coaches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


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
        //

        Coach::saveCoach($request);

        $coach_id = null;
        $allCoaches = Coach::getAll();

        foreach ($allCoaches as $coach)
            if ($coach['name'] == $request['name'])
                $coach_id = $coach['id'];


        $keys_array = ["team_name", "coached_since", "coached_until"];

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


        return redirect('/coaches');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $Coach = new Coach();
        $coach = $Coach->getById($id);

        $recPlayers = [];
        if (!empty($coach['all_teams'])) {
            // Vraca trenere koji su nekada trenirali taj tim
            if ($coach['current_team'] != '') {
                $current_team_id = $coach['current_team']['team']['id'];

                $recommendedResult = Cypher::Run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) 
                WHERE ID(t) =". $current_team_id . " AND ID(c) <>" . (int)$id . " return distinct c LIMIT 5");

                foreach ($recommendedResult->getRecords() as $record) {
                    $props_array = $record->getPropertiesOfNode();
                    $id_array = ["id" => $record->getIdOfNode()];
                    $recPlayer = array_merge($props_array, $id_array);

                    array_push($recPlayers, $recPlayer);
                }
            }


        }

        return view('coaches.show', compact('coach', 'recPlayers'));
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
        Cypher::Run("MATCH (n:Coach) WHERE ID(n) = $id DETACH DELETE n");

        // Fali brisanje tog cvora iz redisa

        return redirect('/apanel');
    }
}
