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
        $result = Cypher::run("MATCH (n:Team) RETURN n");
        $teams = [];

        foreach($result->getRecords() as $record)
        {
            $properties_array = $record->getPropertiesOfNode();
            $id_array = ["id" =>  $record->getIdOfNode()];
            $team = array_merge($properties_array, $id_array);
            array_push($teams, $team);
        }

        return view('teams.index', compact('teams', $teams));
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
        return view('teams.create',  compact('coaches', $coaches));
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

        Cypher::run("CREATE ($request[short_name]:Team {name: '$request[name]', short_name: '$request[short_name]',
                    city: '$request[city]', description: '$request[description]', image: '$request[image]'})");

        Cypher::run("CREATE ($request[short_name]:Team {name: '$request[name]', short_name: '$request[short_name]',
                    city: '$request[city]', description: '$request[description]', image: '$request[image]', background_image: '$request[background_image]'})");



        Cypher::run("MATCH (a:Team), (b:Coach)
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

        $result = Cypher::run("MATCH (a:Team), (b:Coach) WHERE ID(a) = $id and (a)-[:TEAM_COACH]->(b) RETURN b")->getRecords()[0];
        $coach = array_merge($result->getPropertiesOfNode(), ["id" => $result->getIdOfNode()]);

        $result = Cypher::run("MATCH (n:Team), (p:Player) WHERE ID(n) = $id and (n)-[:TEAM_PLAYER]-(p) RETURN p");
        $players = [];
        foreach($result->getRecords() as $record)
        {
            $properties_array = $record->getPropertiesOfNode();
            $id_array = ["id" =>  $record->getIdOfNode()];
            $player = array_merge($properties_array, $id_array);
            array_push($players, $player);
        };

        $result = Cypher::run("MATCH (a:Team) WHERE ID(a) = $id RETURN a")->getRecords()[0];
        $team = $result->getPropertiesOfNode();

        return view('teams.show', compact('players', 'coach', 'team'));
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
