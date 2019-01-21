<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Player;
use App\Team;
use GraphAware\Neo4j\Client\Formatter\Result;
use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;
use Illuminate\Support\Facades\Redis;
use App\Article;
use App\Match;
use App\Team_Match;

class HomeController extends Controller
{
    public function index()
    {
        Redis::incr('user:count');

        $articles = Article::cacheArticles(30);
        $liveMatches = [];
        $query = Cypher::run("MATCH (m:Match) WHERE m.isFinished = false RETURN m");

        if($query->hasRecord()) {
            foreach ($query->getRecords() as $record) {
                $match = Match::buildFromNode($record->value('m'));
                $match->team_match = Team_Match::getByMatchId($match->id);
                $liveMatches[] = $match;
            }
        }

        return view('welcome', compact('articles', 'liveMatches'));
    }
}
