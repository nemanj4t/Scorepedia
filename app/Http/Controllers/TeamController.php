<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Team;
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

        $teams = Team::getAll();

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

        $coaches = [];

        $allCoaches = Coach::getAll();

        foreach ($allCoaches as $coach) {
            if ($coach['current_team'] == "")
                array_push($coaches, $coach);
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
        $team = new Team();
        $team->saveTeam($request);


        return redirect('/apanel?active=Team&route=teams');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Team = new Team();
        $team = $Team->getById($id);


        return view('teams.show', compact('team', $team));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $team = Team::getById($id);
        $coaches = [];

        $allCoaches = Coach::getAll();

        foreach ($allCoaches as $coach) {
            if ($coach['current_team'] == "")
                array_push($coaches, $coach);
        }

        return view('teams.edit', compact('team', 'coaches'));
    }

    public function update(Request $request, $id)
    {
        //
        Team::update($id, $request);

        return redirect("/teams/" . $id);

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
        Team::delete($id);

        // Fali brisanje tog cvora iz redisa

        return redirect('/apanel?active=Team&route=teams');
    }
}
