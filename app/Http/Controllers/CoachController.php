<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Team;
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
        $teams = [];

        $Team = new Team();
        $allTeams = $Team->getAll();

        foreach ($allTeams as $team) {
            if ($team['current_coach'] === "")
                array_push($teams, $team);
        }

        

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

        $coach = new Coach();
        $coach->saveCoach($request);

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
                $current_team_id = $coach['current_team']['id'];

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
    public function update(Request $request, $id)
    {
        //
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
