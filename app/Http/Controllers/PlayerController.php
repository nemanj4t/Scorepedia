<?php

namespace App\Http\Controllers;

use App\Player;
use App\Player_Team;
use GraphAware\Neo4j\Client\Formatter\Result;
use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Facade;
use App\Team;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::getAllWithCurrentTeam();
        return view('players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ako je korisnik ulogovans
        $teams = Team::getTeams();
        return view('players.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Player::savePlayer($request);
        return redirect('/apanel?active=Player&route=players');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Player $player */
        $player = Player::getById($id);

        /** @var Player_Team[] $plays_for_teams */
        $plays_for_teams = Player_Team::getByPlayerId($id);

        // Ovo je bolje kao poseban servis za recommendation da se napravi
        // i da ima par razlicitih funkcija na osnovu kojih ce da preporucuje
        $recPlayers = [];
        if (!empty($plays_for_teams)) {
            // Vraca igrace koji su igrali na toj poziciji

            /** @var Result $recommendedResult */
            $recommendedResult = Cypher::run("MATCH (n:Player)-[r:PLAYS|PLAYED]-() 
                WHERE r.position = '" . $plays_for_teams[0]->position .
                "' AND ID(n) <> " . $player->id . " return distinct n LIMIT 5");

            foreach ($recommendedResult->getRecords() as $record) {
                $node = $record->value('n');
                $recPlayer = Player::buildFromNode($node);

                array_push($recPlayers, $recPlayer);
            }
        }
        return view('players.show', compact('player', 'plays_for_teams', 'recPlayers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $player = Player::getById($id);
        if ($player === null) {
            abort(404);
        }

        return view('players.edit', compact('player'));
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
        // Prva tri inputa su: method, token, id
        //$updatedProps = json_encode(array_slice($request->all(), 3));

        Cypher::Run("MATCH (n:Player) WHERE ID(n) = $id SET n = {
            name: '$request[name]',
            bio: '$request[bio]',
            height: '$request[height]',
            weight: '$request[weight]',
            city: '$request[city]',
            image: '$request[image]'}");

        return redirect('/players');
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
        Cypher::Run("MATCH (n:Player) WHERE ID(n) = $id DETACH DELETE n");

        // Fali brisanje tog cvora iz redisa

        return redirect('/apanel?active=Player&route=players');
    }
}
