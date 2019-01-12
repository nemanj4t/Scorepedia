<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 1/9/19
 * Time: 3:50 PM
 */

namespace App;


class Tag
{
    public $article;
    public $player;
    public $team;

    public static function tagPlayer($article_id, $name)
    {
        Cypher::Run("MATCH (a:Article), (p:Player) WHERE ID(a) = $article_id AND p.name = 
        $name CREATE (a)-[t:TAGGED_PLAYER]->(p)");
    }

    public static function tagTeam($article_id, $name)
    {
        Cypher::Run("MATCH (a:Article), (t:Team) WHERE ID(a) = $article_id AND t.name = 
        $name (a)-[t:TAGGED_TEAM]->(t)");
    }

    public static function tagCoach($article_id, $name)
    {
        Cypher::Run("MATCH (a:Article), (c:Coach) WHERE ID(a) = $article_id AND c.name = 
        $name (a)-[t:TAGGED_COACH]->(c)");
    }
}
