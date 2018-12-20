<?php

namespace App\Http\Controllers;

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
        $resultCoaches = Cypher::run("MATCH (c:Coach) RETURN c");
        $coaches = [];
        foreach ($resultCoaches->getRecords() as $record) {
            $coach = $record->getPropertiesOfNode();
            $coach = array_merge($coach, ['id' => $record->getIdOfNode()]);
            $current_team = '';

            $team_coach = $coachResult = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(c) =". $record->getIdOfNode()." RETURN t, r
                                    ORDER BY r.coached_until DESC");

            foreach ($team_coach->getRecords() as $record) {
                $team = $record->nodeValue('t');
                $team_props = $team->values();
                $team_id = ["id" => $team->identity()];

                // Vraca vrednosti za relaciju TEAM_COACH
                $relationship = $record->relationShipValue('r');
                $relationship_props = $relationship->values();


                // Spaja kljuceve i propertije
                $team = array_merge($team_props, $team_id);

                if (Carbon::parse($relationship_props['coached_until'])->gt(Carbon::now()))
                    $current_team = $team;

            }
            $coach = array_merge($coach, ['team' => $current_team]);
            array_push($coaches, $coach);
        }

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

        $result = Cypher::run("MATCH (t:Team) WHERE NOT (t)-[:TEAM_COACH]->() RETURN t");

        foreach ($result->getRecords() as $record) {
            $team_props = $record->getPropertiesOfNode();
            $team = array_merge($team_props, ['id' => $record->getIdOfNode()]);


            array_push($teams, $team);
        }


        $result = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) RETURN t, r ORDER BY r.coached_until DESC");

        foreach ($result->getRecords() as $record) {
            $team = $record->nodeValue('t');
            $team_props = $team->values();
            $team_id = ["id" => $team->identity()];

            $relationship = $record->relationShipValue('r');
            $relationship_props = $relationship->values();

            $team = array_merge($team_props, $team_id);


            if (Carbon::parse($relationship_props['coached_until'])->lt(Carbon::now())) {
                if (!in_array($team, $teams, true))
                    array_push($teams, $team);
            }

            if (Carbon::parse($relationship_props['coached_until'])->gt(Carbon::now())) {
                if (!in_array($team, $teams, true)) {
                    if (($key = array_search($team['id'], $teams)) !== false) {
                        unset($teams[$team['id']]);
                    }
                }
            }

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

        if($request['team'] != null)
            Cypher::run("MATCH (t:Team) WHERE ID(t) = $request[team]
                        CREATE (t)-[:TEAM_COACH{coached_since: '$request[coached_since]', coached_until: '$request[coached_until]'}]->(c:Coach {name: '$request[name]', bio: '$request[bio]', city: '$request[city]', image: '$request[image]'})");
        else
            Cypher::run("CREATE (c:Coach {name: '$request[name]', bio: '$request[bio]', city: '$request[city]', image: '$request[image]'})");

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
        $coach = Cypher::run("MATCH (c:Coach) WHERE ID(c) = $id RETURN c")->getRecords()[0]->getPropertiesOfNode();

        //tim koji trenira
        $coachResult = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(c) = $id RETURN t, r
                                    ORDER BY r.coached_until DESC");
        $coached_teams = [];
        $current_team = '';

        foreach ($coachResult->getRecords() as $record) {
            // Vraca vrednosti za tim za koji igrac igra
            $team = $record->nodeValue('t');
            $team_props = $team->values();
            $team_id = ["id" => $team->identity()];

            // Vraca vrednosti za relaciju TEAM_COACH
            $relationship = $record->relationShipValue('r');
            $relationship_props = $relationship->values();
            $relationship_id = ["id" => $relationship->identity()];


            // Spaja kljuceve i propertije
            $team = array_merge($team_props, $team_id);
            $coach_team = array_merge($relationship_props, $relationship_id);

            if (Carbon::parse($relationship_props['coached_until'])->gt(Carbon::now()))
                $current_team = $team;


                    // Niz koji sadrzi relaciju i tim
            $coaches = ['coach_team' => $coach_team, 'team' => $team];

            array_push($coached_teams, $coaches);
        }


        $recPlayers = [];
        if (!empty($coached_teams)) {
            // Vraca trenere koji su nekada trenirali taj tim
            if ($current_team != '') {
                $current_team_id = $current_team['id'];

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

        return view('coaches.show', compact('coach', 'coached_teams', 'current_team', 'recPlayers'));
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
