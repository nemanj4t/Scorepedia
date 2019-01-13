<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 1/9/19
 * Time: 3:50 PM
 */

namespace App;
use Ahsan\Neo4j\Facade\Cypher;


class Tag
{
    public $article;
    public $player;
    public $team;

    public static function tagPlayer($article_id, $id)
    {
        Cypher::Run("MATCH (a:Article), (p:Player) WHERE ID(a) = $article_id AND ID(p) = 
        $id CREATE (a)-[:TAGGED_PLAYER]->(p)");
    }

    public static function tagTeam($article_id, $id)
    {
        Cypher::Run("MATCH (a:Article), (t:Team) WHERE ID(a) = $article_id AND ID(t) = 
        $id CREATE (a)-[:TAGGED_TEAM]->(t)");
    }

    public static function tagCoach($article_id, $id)
    {
        Cypher::Run("MATCH (a:Article), (c:Coach) WHERE ID(a) = $article_id AND ID(c) = 
        $id CREATE (a)-[:TAGGED_COACH]->(c)");
    }
}
