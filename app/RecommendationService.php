<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 1/10/2019
 * Time: 10:26 PM
 */

namespace App;
use Ahsan\Neo4j\Facade\Cypher;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use Carbon\Facade;


class RecommendationService
{
    // Vraca artikle u kojima je tagovan igrac ili trenutni tim igraca
    public static function recommendArticlesForPlayer($id)
    {
        $result = Cypher::Run("MATCH (p:Player)-[:TAGGED_PLAYER]-(a:Article) WHERE ID(p)=$id return a UNION 
            MATCH (p:Player)-[:PLAYS]-(:Team)-[:TAGGED_TEAM]-(a:Article) WHERE ID(p)=$id return a");

        return self::fromRecordsToArticles($result->getRecords());
    }

    // Vraca artikle u kojima je tagovan tim ili trenutni trener tima ili trenutni igraci tima
    public static function recommendArticlesForTeam($id)
    {
        $now =  \Carbon\Carbon::now()->format('Y-m-d');
        $result = Cypher::Run("MATCH (t:Team)-[:TAGGED_TEAM]-(a:Article) WHERE ID(t)=$id return a UNION 
            MATCH (t:Team)-[:PLAYS]-(p:Player)-[:TAGGED_PLAYER]-(a:Article) WHERE ID(t)=$id return a UNION 
            MATCH (t:Team)-[r1:TEAM_COACH]-(:Coach)-[:TAGGED_COACH]-(a:Article) WHERE ID(t)=$id AND r1.coached_until >= '$now' return a");

        return self::fromRecordsToArticles($result->getRecords());
    }

    // Vraca artikle u kojima je tagovan trener ili trenutni tim trenera
    public static function recommendArticlesForCoach($id)
    {
        $now =  \Carbon\Carbon::now()->format('Y-m-d');
        $result = Cypher::Run("MATCH (c:Coach)-[:TAGGED_COACH]-(a:Article) WHERE ID(c)=$id return a UNION
            MATCH (c:Coach)-[r1:TEAM_COACH]-(:Team)-[:TAGGED_TEAM]-(a:Article) WHERE ID(c)=$id AND r1.coached_until >= '$now' return a");

        return self::fromRecordsToArticles($result->getRecords());
    }

    // Vraca igrace koji trenutno igraju na istoj poziciji
    public static function recommendSimilarPlayers($playerId, $position)
    {
        $recPlayers = [];
        /** @var Result $recommendedResult */
        $recommendedResult = Cypher::run("MATCH (n:Player)-[r:PLAYS|PLAYED]-() 
            WHERE r.position = '" . $position .
            "' AND ID(n) <> " . $playerId . " return distinct n LIMIT 5");

        foreach ($recommendedResult->getRecords() as $record) {
            $node = $record->value('n');
            $recPlayer = Player::buildFromNode($node);

            array_push($recPlayers, $recPlayer);
        }

        return $recPlayers;
    }

    public static function fromRecordsToArticles($records) {
        $articles = [];
        foreach($records as $record) {
            $article = Article::buildFromNode($record->value('a'));
            $articles[] = $article;
        }

        return $articles;
    }
}
