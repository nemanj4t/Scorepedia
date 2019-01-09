<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 1/9/19
 * Time: 3:50 PM
 */

namespace App;


class Tagged extends Model
{
    public $article;
    public $player;
    public $team;

    public static function tagPlayer($article_id, $player_id)
    {
        Cypher::Run("MATCH (a:Article), (p:Player) WHERE ID(a) = $article_id AND ID(p) = $player_id CREATE (a)-[t:TAGGED]->(p)");
    }

    public static function tagTeam($article_id, $team_id)
    {
        Cypher::Run("MATCH (a:Article), (t:Team) WHERE ID(a) = $article_id AND ID(t) = $team_id (a)-[t:TAGGED]->(t)");
    }
}
