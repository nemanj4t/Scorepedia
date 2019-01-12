<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Ahsan\Neo4j\Facade\Cypher;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use App\Player;
use App\Team;
use App\Coach;
use Illuminate\Session;
class SearchController extends Controller
{
    //
    public function index()
    {
        $players = [];
        $teams = [];
        $coaches = [];
        $searchString = Input::get('q');
        \Session::put('search', $searchString);
        $searchString = strtolower($searchString);
        $searchString = str_replace("'", "", $searchString);
        $searchString = str_replace('"', "", $searchString);
        $result = Cypher::run("OPTIONAL MATCH (p:Player) WHERE toLower(p.name) CONTAINS trim('".$searchString."')
                               OPTIONAL MATCH (t:Team) WHERE toLower(t.name) CONTAINS trim('".$searchString."')
                               OPTIONAL MATCH (c:Coach) WHERE toLower(c.name) CONTAINS trim('".$searchString."')
                               RETURN p, t, c");
        $records = $result->getRecords();
        foreach($records as $record)
        {
            /** @var Node $playerNode */
            $playerNode = $record->value('p');
            /** @var Node $teamNode */
            $teamNode = $record->value('t');
            /** @var Node $coachNode */
            $coachNode = $record->value('c');
            $isInArray = false;
            if ($playerNode != null)
            {
                foreach($players as $p) {
                    if ($p->id === $playerNode->identity()) {
                        $isInArray = true;
                        break;
                    }
                }
                if (!$isInArray) {
                    $player = Player::buildFromNode($playerNode);
                    $players [] = $player;
                }
                $isInArray = false;
            }
            if ($teamNode != null)
            {
                foreach($teams as $t) {
                    if ($t->id === $teamNode->identity()) {
                        $isInArray = true;
                        break;
                    }
                }
                if (!$isInArray) {
                    $team = Team::buildFromNode($teamNode);
                    $teams [] = $team;
                }
                $isInArray = false;
            }
            if ($coachNode != null)
            {
                foreach($coaches as $c) {
                    if ($c->id === $coachNode->identity()) {
                        $isInArray = true;
                        break;
                    }
                }
                if (!$isInArray) {
                    $coach = Coach::buildFromNode($coachNode);
                    $coaches [] = $coach;
                }
            }
        }
        return view("search.index", compact('players', 'teams', 'coaches'));
    }
}