<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                                    ORDER BY r.until DESC");
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


        return view('coaches.show', compact('coach', 'coached_teams', 'current_team'));
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
