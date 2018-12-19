<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;

class HomeController extends Controller
{
    public function index()
    {
        //prvi rekordi iz baze, dok ne ubacimo Redis
        $result = Cypher::Run("MATCH (n:Player) RETURN n");
        $player = array_merge(['id' => $result->firstRecord()->getIdOfNode()], $result->firstRecord()->getPropertiesOfNode());

        $result = Cypher::Run("MATCH (n:Team) RETURN n");
        $team = array_merge(['id' => $result->firstRecord()->getIdOfNode()], $result->firstRecord()->getPropertiesOfNode());

        $result = Cypher::Run("MATCH (n:Coach) RETURN n");
        $coach = array_merge(['id' => $result->firstRecord()->getIdOfNode()], $result->firstRecord()->getPropertiesOfNode());

        return view('welcome', compact('player', 'team', 'coach'));
    }
}
