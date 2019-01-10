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

    public static function buildFromNode(Node $node)
    {
        $article = new Article();
        $article->id = $node->identity();
        $article->content = $node->value('content');
        $article->timestamp = $node->value('timestamp');

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
        } catch (\RuntimeException $exception) {
            return null;
        }

        $node = $query->firstRecord()->nodeValue('a');
        $article = self::buildFromNode($node);

        return $article;
    }

    public static function saveArticle(Request $request)
    {

        $timestamp = \Carbon\Carbon::now()->format("Ymd");
        $result = Cypher::Run("CREATE (a:Article {content: '$request[content]',
        timestamp: $timestamp}) RETURN ID(a)");

        try {
            // Racunam da tagovani podaci (input elementi html)
            // imaju za ime niz kao za Player_Team veze
            // ovo je otprilike, izmenicemo kad se dogovorimo
            // kako ce tacno da izgleda
            $record = $result->getRecord();
            $article_id = $record->values('ID(a)');

            foreach($request['taggedPlayer'] as $name) {
                Tag::tagPlayer($article_id, $name);
            }

            foreach($request['taggedCoach'] as $name) {
                Tag::tagCoach($article_id, $name);
            }

            foreach($request['taggedTeam'] as $name) {
                Tag::tagTeam($article_id, $name);
            }
        }
        catch(\RuntimeException $ex) {
            return null;
        }
    }
}
