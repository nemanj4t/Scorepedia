<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Player;
use App\Team;
use GraphAware\Neo4j\Client\Formatter\Result;
use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    public function index()
    {
        Redis::incr('user:count');
        //prvi rekordi iz baze, dok ne ubacimo Redis

        /** @var Result $result */
        $result = Cypher::run("MATCH (n:Player) RETURN n");
        $record = $result->getRecord();
        $node = $record->value('n');
        $player = Player::buildFromNode($node);

        /** @var Result $result */
        $result = Cypher::run("MATCH (n:Team) RETURN n");
        $record = $result->getRecord();
        $node = $record->value('n');
        $team = Team::buildFromNode($node);

        $result = Cypher::run("MATCH (n:Coach) RETURN n");
        $record = $result->getRecord();
        $node = $record->value('n');
        $coach = Coach::buildFromNode($node);

        return view('welcome', compact('player', 'team', 'coach'));
    }
}
