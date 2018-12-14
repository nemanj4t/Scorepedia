<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Cypher::run("MATCH (n:TEAM) RETURN n");
        $teams = [];

        foreach($result->getRecords() as $record)
        {
            $properties_array = $record->getPropertiesOfNode();
            $id_array = ["id" =>  $record->getIdOfNode()];
            $team = array_merge($properties_array, $id_array);
            array_push($teams, $team);
        }

        return view('teams/show', [
           'teams' => $teams]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $result = Cypher::run("MATCH (n:Coach)
                               WHERE NOT ()-[:TEAM_COACH]->(n)
                               RETURN n");
        $coaches = [];
        foreach ($result->getRecords() as $record)
        {
            $properties_array = $record->getPropertiesOfNode();
            $id_array = ["id" =>  $record->getIdOfNode()];
            $coach = array_merge($properties_array, $id_array);
            array_push($coaches, $coach);
        }
        return view('teams/create',  compact('coaches', $coaches));
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
        Cypher::run("CREATE ($request[short_name]:TEAM {name: '$request[name]', short_name: '$request[short_name]',
                    city: '$request[city]', description: '$request[description]', image: '$request[image]'})");


        Cypher::run("MATCH (a:TEAM), (b:Coach)
                    WHERE a.name = '$request[name]' and ID(b) = $request[coach]
                    CREATE (a)-[r:TEAM_COACH]->(b)");

        return redirect('/teams');
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
        //
    }
}
