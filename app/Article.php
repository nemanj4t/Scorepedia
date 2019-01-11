<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 1/9/19
 * Time: 3:47 PM
 */

namespace App;
use Ahsan\Neo4j\Facade\Cypher;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use Carbon\Facade;

class Article
{
    public $id;
    public $content;
    public $timestamp;

    public $taggedTeams = [];
    public $taggedPlayers = [];
    public $taggedCoaches = [];

    public static function buildFromNode(Node $node)
    {
        $article = new Article();
        $article->id = $node->identity();
        $article->content = $node->value('content');
        //$article->timestamp = $node->value('timestamp');

        return $article;
    }

    public static function getAll()
    {
        $result = Cypher::Run("MATCH (a:Article) return a");
        $articles = [];
        foreach($result->getRecords() as $record) {
            $articleNode = $record->value('a');
            $article = self::buildFromNode($articleNode);
            $articles[] = $article;
        }

        return $articles;
    }

    public static function getById($id)
    {
        $query = Cypher::Run("MATCH (a:Article) WHERE ID(a) = $id return a");
        
        try {
            $record = $query->getRecord();
            $node = $query->firstRecord()->nodeValue('a');
            $article = self::buildFromNode($node);

            $teamQuery = Cypher::Run("MATCH (a:Article)-[:TAGGED_TEAM]-(t:Team) return t");
            foreach($teamQuery->getRecords() as $teamRecord) {
                $article->taggedTeams[] = Team::buildFromNode($teamRecord->nodeValue('t'));
            }

            $playerQuery = Cypher::Run("MATCH (a:Article)-[:TAGGED_PLAYER]-(p:Player) return p");
            foreach($playerQuery->getRecords() as $playerRecord) {
                $article->taggedPlayers[] = Player::buildFromNode($playerRecord->nodeValue('p'));
            }

            $coachQuery = Cypher::Run("MATCH (a:Article)-[:TAGGED_COACH]-(c:Coach) return c");
            foreach($coachQuery->getRecords() as $coachRecord) {
                $article->taggedCoaches[] = Coach::buildFromNode($coachRecord->nodeValue('c'));
            }

            return $article;
        } catch (\RuntimeException $exception) {
            return null;
        }
    }

    public static function saveArticle(Request $request)
    {
        $timestamp = \Carbon\Carbon::now()->format("Ymd");

        try {
            $result = Cypher::Run("CREATE (a:Article {content: '$request[content]',
            timestamp: $timestamp}) RETURN ID(a)");

            $record = $result->getRecord();
            $article_id = $record->value('ID(a)');

            foreach($request['taggedPlayer'] as $name) {
                Tag::tagPlayer($article_id, $name);
            }

            foreach($request['taggedCoach'] as $name) {
                Tag::tagCoach($article_id, $name);
            }

            foreach($request['taggedTeam'] as $name) {
                Tag::tagTeam($article_id, $name);
            }

            // succeeded
            return true;
        }
        catch(\RuntimeException $ex) {
            return false;
        }
    }

    public static function deleteArticle($id)
    {
        $result = Cypher::run("MATCH (a:Article) WHERE ID(a) = $id DETACH DELETE a RETURN COUNT(a)");
        try {
            $record = $result->getRecord();
            $deletedCount = $record->value('COUNT(a)');

            return $deletedCount;
        }
        catch (\RuntimeException $ex) {
            return 0;
        }
    }
}
