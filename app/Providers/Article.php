<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 1/9/19
 * Time: 3:47 PM
 */

namespace App\Providers;
use Ahsan\Neo4j\Facade\Cypher;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;

class Article extends Model
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

    }
}
