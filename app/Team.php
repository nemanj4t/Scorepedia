<?php

namespace App;

use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use Illuminate\Support\Facades\Redis;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Carbon;

class Team
{
    public $id;
    public $name;
    public $short_name;
    public $city;
    public $description;
    public $image;
    public $background_image;

    public $current_players;
    public $all_players;

    public $current_coach;
    public $all_coaches;

    /**
     * @param Node $node
     * @return Team
     */
    public static function buildFromNode(Node $node)
    {
        $team = new Team();
        $team->id = $node->identity();
        $team->name = $node->value('name');
        $team->short_name = $node->value('short_name');
        $team->city = $node->value('city');
        $team->description = $node->value('description');
        $team->image = $node->value('image');
        $team->background_image = $node->value('background_image');

        return $team;
    }

    /**
     * @param Node $node
     * @return Team
     */
    //returns with current players and coach
    public static function buildFromNodeForShow(Node $node)
    {
        $team = self::BuildFromNode($node);

        $team->current_coach = Team_Coach::getCurrentForTeamId($team->id);
        $team->current_players = Player_Team::getCurrentPlayers($team->id);

        return $team;
    }


    /**
     * @return Team[]
     */
    public static function getTeams()
    {
        /** @var Result $result */
        $result = Cypher::run("MATCH (n:Team) RETURN n");
        $teams = [];
        foreach($result->getRecords() as $record)
        {
            $node = $record->value('n');
            //just necessary for teams index
            $team = self::buildFromNode($node);

            $teams[] = $team;
        }

        return $teams;
    }

    /**
     * @param $id
     * @return Team|null
     */
    public static function getTeamById($id)
    {
        /** @var Result $result */
        $result = Cypher::run("MATCH (n:Team) WHERE ID(n) = $id RETURN n");

        try {
            $record = $result->getRecord();
        } catch (\RuntimeException $exception) {
            return abort(404);
        }

        $node = $record->value('n');
        $team = self::buildFromNode($node);

        return $team;
    }

    /**
     * @return Team[]
     */
    public static function getAll()
    {
        /** @var Result $result */
        $result = Cypher::run("MATCH (t:Team) RETURN t");
        $teams = [];
        foreach ($result->getRecords() as $record) {
            $node = $record->value('t');
            $team = self::buildFromNode($node);

            $current_coach = Team_Coach::getCurrentForTeamId($team->id);
            $all_coaches = Team_Coach::getByTeamId($team->id);
            $current_players = Player_Team::getCurrentPlayers($team->id);
            $all_players = Player_Team::getByTeamId($team->id);

            $team->current_players = $current_players;
            $team->all_players = $all_players;

            $team->current_coach = $current_coach;
            $team->all_coaches = $all_coaches;

            array_push($teams, $team);
        }
        return $teams;
    }

    /**
     * @param $id
     * @return Team|null
     */
    public static function getById($id)
    {
        /** @var Result $result */
        $result = Cypher::run("MATCH (t:Team) WHERE ID(t) = $id RETURN t");

        try {
            $record = $result->getRecord();
        } catch (\RuntimeException $exception) {
            return null;
        }

        $node = $record->value('t');

        $team = self::buildFromNode($node);

        $current_coach = self::getCurrentCoach($team->id);
        $all_coaches = Team_Coach::getByTeamId($team->id);
        $current_players = Player_Team::getCurrentPlayers($team->id);
        $all_players = Player_Team::getByTeamId($team->id);

        $team->current_players = $current_players;
        $team->all_players = $all_players;

        $team->current_coach = $current_coach;
        $team->all_coaches = $all_coaches;

        return $team;
    }


    // TODO: refaktorisati po ugledu na current team for coach
    public static function getCurrentCoach($id)
    {
        $team_coach = Team_Coach::getCurrentForTeamId($id);
        $current_coach = $team_coach->coach;
        return $current_coach;
    }


    public static function save($request) {

        if($request['coach'] != null)
           $t = Cypher::run("MATCH (c:Coach) WHERE ID(c) = $request[coach]
                        CREATE (t:Team {name: '$request[name]', short_name: '$request[short_name]',
                        city: '$request[city]', description: '$request[description]', image: '$request[image]',
                        background_image: '$request[background_image]'})-[:TEAM_COACH{coached_since: '$request[coached_since]', coached_until: '$request[coached_until]'}]->(c) RETURN t");
        else
           $t = Cypher::run("CREATE (t:Team {name: '$request[name]', short_name: '$request[short_name]',
                        city: '$request[city]', description: '$request[description]', image: '$request[image]',
                        background_image: '$request[background_image]'}) RETURN t");


        $id = $t->firstRecord()->getByIndex(0)->identity();

        Redis::zadd("points", 0, $id);
        Redis::zadd("wins", 0, $id);
        Redis::zadd("losses", 0, $id);
        Redis::zadd("percentage", 0, $id);
        Redis::zadd("home", 0, $id);
        Redis::zadd("road", 0, $id);
        Redis::zadd("streak", 0, $id);

        Redis::hmset(
            "team:standings:{$id}",
            "points", 0,
            "wins", 0,
            "losses", 0,
            "percentage", 0,
            "home", 0,
            "road", 0,
            "streak", 0);

        Redis::incr("count:teams");

    }

    public static function update($id, $request)
    {
        $team = Team::getById($id);
        Cypher::run("MATCH (t:Team) WHERE ID(t) = $id SET t.name = '$request[name]', t.short_name = '$request[short_name]',t.city = '$request[city]', t.image = '$request[image]', t.background_image = '$request[background_image]', t.description = '$request[description]'");
        $team_coach = new Team_Coach(["coach_id" => $request['coach'], "team_name" => $id, "coached_since" => $request['coached_since'], "coached_until" => $request['coached_until']]);
        if ($request['coach'] != '') {
            if ($team['current_coach'] != '') {
                if ($team['current_coach']['id'] == $request['coach']) {
                    $team_coach->update();
                } else {
                    Team_Coach::delete($id, $team['current_coach']['id']);
                    $team_coach->save();
                }
            }
            else {
                $team_coach->save();
            }
        }
        else {
            if ($team['current_coach'] != '')
                Team_Coach::delete($id, $team['current_coach']['id']);
        }

    }

    public static function delete($id)
    {
        Cypher::Run("MATCH (n:Team) WHERE ID(n) = $id DETACH DELETE n");
    }
}
