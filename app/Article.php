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
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class Article
{
    public $id;
    public $content;
    public $title;
    public $image;
    public $timestamp;

    public $taggedTeams = [];
    public $taggedPlayers = [];
    public $taggedCoaches = [];

    public static function buildFromNode(Node $node)
    {
        $article = new Article();
        $article->id = $node->identity();
        $article->title = $node->value('title');
        $article->content = $node->value('content');
        $article->image = $node->value('image');
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
            $article->taggedCoaches = self::getTaggedCoaches($article->id);
            $article->taggedPlayers = self::getTaggedPlayers($article->id);
            $article->taggedTeams = self::getTaggedTeams($article->id);
            $articles[] = $article;
        }

        return $articles;
    }

    public static function getById($id)
    {
        $query = Cypher::Run("MATCH (a:Article) WHERE ID(a) = $id return a");

        try {
            $node = $query->firstRecord()->value('a');
            $article = self::buildFromNode($node);

            $article->taggedTeams = self::getTaggedTeams($article->id);
            $article->taggedCoaches = self::getTaggedCoaches($article->id);
            $article->taggedPlayers = self::getTaggedPlayers($article->id);

            return $article;
        } catch (\RuntimeException $exception) {
            return null;
        }
    }

    public static function saveArticle($request)
    {
        $timestamp = Carbon::now('Europe/Belgrade')->format('d-m-y h:i:s');

        try {
            $result = Cypher::Run("CREATE (a:Article {content: '$request[content]',
            timestamp: '$timestamp', image: '$request->image', title: '$request->title'}) RETURN ID(a)");

            $record = $result->getRecord();
            $article_id = $record->value('ID(a)');

            if($request['players']) {
                foreach ($request['players'] as $id) {
                    Tag::tagPlayer($article_id, $id);
                }
            }

            if($request['coaches']) {
                foreach ($request['coaches'] as $id) {
                    Tag::tagCoach($article_id, $id);
                }
            }

            if($request['teams']) {
                foreach ($request['teams'] as $id) {
                    Tag::tagTeam($article_id, $id);
                }
            }

        }
        catch(\RuntimeException $ex) {
            return $ex;
        }

        Redis::incr('count:articles');
    }

    public static function deleteArticle($id)
    {
        $result = Cypher::run("MATCH (a:Article) WHERE ID(a) = $id DETACH DELETE a RETURN COUNT(a)");
        try {
            $record = $result->getRecord();
            $deletedCount = $record->value('COUNT(a)');

            Redis::decr('count:articles');
            return $deletedCount;
        }
        catch (\RuntimeException $ex) {
            return 0;
        }
    }

    public static function getTaggedPlayers($article_id)
    {
        $query = Cypher::run("MATCH (p:Player)-[:TAGGED_PLAYER]-(a:Article) WHERE ID(a) = $article_id RETURN p");
        $players = [];

        if($query->hasRecord()) {
            foreach ($query->getRecords() as $record) {
                $player = Player::buildFromNode($record->value('p'));
                $players[] = $player;
            }
        }

        return $players;
    }

    public static function getTaggedCoaches($article_id)
    {
        $query = Cypher::run("MATCH (c:Coach)-[:TAGGED_COACH]-(a:Article) WHERE ID(a) = $article_id RETURN c");

        $coaches = [];

        if($query->hasRecord()) {
            foreach ($query->getRecords() as $record) {
                $coach = Coach::buildFromNode($record->value('c'));
                $coaches[] = $coach;
            }
        }

        return $coaches;
    }

    public static function getTaggedTeams($article_id)
    {
        $query = Cypher::run("MATCH (t:Team)-[:TAGGED_TEAM]-(a:Article) WHERE ID(a) = $article_id RETURN t");

        $teams = [];

        if($query->hasRecord()) {
            foreach ($query->getRecords() as $record) {
                $team = Player::buildFromNode($record->value('t'));
                $teams[] = $team;
            }
        }

        return $teams;
    }
}
