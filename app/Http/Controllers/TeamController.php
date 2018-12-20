<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Carbon;

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
       /* $result = Cypher::run("MATCH (n:Coach)
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
        return view('teams.create',  compact('coaches', $coaches));*/


        $coaches = [];

        $result = Cypher::run("MATCH (c:Coach) WHERE NOT ()-[:TEAM_COACH]->(c) RETURN c");

        foreach ($result->getRecords() as $record) {
            $coach_props = $record->getPropertiesOfNode();
            $coach = array_merge($coach_props, ['id' => $record->getIdOfNode()]);


            array_push($coaches, $coach);
        }


        $result = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) RETURN c, r ORDER BY r.coached_until DESC");

        foreach ($result->getRecords() as $record) {
            $coach = $record->nodeValue('c');
            $coach_props = $coach->values();
            $coach_id = ["id" => $coach->identity()];

            $relationship = $record->relationShipValue('r');
            $relationship_props = $relationship->values();

            $coach = array_merge($coach_props, $coach_id);


            if (Carbon::parse($relationship_props['coached_until'])->lt(Carbon::now())) {
                if (!in_array($coach, $coaches, true))
                    array_push($coaches, $coach);
            }

            if (Carbon::parse($relationship_props['coached_until'])->gt(Carbon::now())) {
                if (!in_array($coach, $coaches, true)) {
                    if (($key = array_search($coach['id'], $coaches)) !== false) {
                        unset($coaches[$coach['id']]);
                    }
                }
            }

        }

        return view('teams.create', compact('coaches'));

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

        if($request['coach'] != null)
            Cypher::run("MATCH (c:Coach) WHERE ID(c) = $request[coach]
                        CREATE (t:Team {name: '$request[name]', short_name: '$request[short_name]',
                        city: '$request[city]', description: '$request[description]', image: '$request[image]',
                        background_image: '$request[background_image]'})-[:TEAM_COACH{coached_since: '$request[coached_since]', coached_until: '$request[coached_until]'}]->(c)");
        else
            Cypher::run("CREATE (t:Team {name: '$request[name]', short_name: '$request[short_name]',
                        city: '$request[city]', description: '$request[description]', image: '$request[image]',
                        background_image: '$request[background_image]'})");


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
        // Brise cvor i sve njegove veze
        Cypher::Run("MATCH (n:Team) WHERE ID(n) = $id DETACH DELETE n");

        // Fali brisanje tog cvora iz redisa

        return redirect('/apanel');
    }
}
