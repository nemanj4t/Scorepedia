<?php

namespace App;

use Carbon\Carbon;
use GraphAware\Neo4j\Client\Formatter\Result;
use GraphAware\Neo4j\Client\Formatter\Type\Node;
use Illuminate\Support\Facades\Redis;
use Ahsan\Neo4j\Facade\Cypher;

class Coach
{
    public $id;
    public $name;
    public $city;
    public $bio;
    public $image;

    /** @var Team_Coach */
    public $current_team;


    /**
     * @param Node $node
     * @return Coach
     */
    public static function buildFromNode(Node $node)
    {
        $coach = new Coach();
        $coach->id = $node->identity();
        $coach->name = $node->value('name');
        $coach->city = $node->value('city');
        $coach->bio = $node->value('bio');
        $coach->image = $node->value('image');

        return $coach;
    }

    /**
     * @return Coach[]
     */
    public static function getAll()
    {
        $now = Carbon::now()->format('Y-m-d');

        /** @var Result $result */
        $result = Cypher::run("MATCH (c:Coach) OPTIONAL MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE r.coached_since <= '$now' AND r.coached_until >= '$now' RETURN c, t, r");

        $coaches = [];
        foreach ($result->getRecords() as $record) {
            $coachNode = $record->value('c');
            $teamNode = $record->value('t');
            $relationship = $record->value('r');
            $coach = Coach::buildFromNode($coachNode);

            if ($record->value('t')) {
                $coach->current_team = Team_Coach::buildFromNodesAndRelationship($teamNode, $coachNode, $relationship);
            }

            array_push($coaches, $coach);
        }


        return $coaches;
    }

    /**
     * @param $id
     * @return Coach|null
     */
    public static function getById($id)
    {
        /** @var Result $result */
        $result = Cypher::run("MATCH (c:Coach) WHERE ID(c) = $id RETURN c");

        try {
            $record = $result->getRecord();
        } catch (\RuntimeException $exception) {
            return null;
        }

        /** @var Node $node */
        $node = $record->getByIndex(0);

        $coach = self::buildFromNode($node);

        return $coach;
    }

    public static function saveCoach($request)
    {
        if ($request['team'] != null) {
            $coach = Cypher::run("MATCH (t:Team) WHERE ID(t) = {$request['team']}
                        CREATE (t)-[:TEAM_COACH{coached_since: '{$request['coached_since']}', coached_until: '{$request['coached_until']}'}]->(c:Coach {name: '{$request['name']}', bio: '{$request['bio']}', city: '{$request['city']}', image: '{$request['image']}'}) RETURN c");
        } else {
            $coach = Cypher::run("CREATE (c:Coach {name: '{$request['name']}', bio: '{$request['bio']}', city: '{$request['city']}', image: '{$request['image']}'}) RETURN c");
        }

        Redis::incr("count:coaches");

        return $coach;
    }

    public static function update($id, $request)
    {
        $coach = Coach::getById($id);

        if ($coach === null) {
           return;
        }

        Cypher::run("MATCH (c:Coach) WHERE ID(c) = $id SET c.name = '$request->name', c.bio = '$request->bio', c.city = '$request->city', c.image = '$request->city'");

        $team_coach = new Team_Coach();
        $team_coach->coach_id = $id;
        $team_coach->team_id = $request['team'];
        $team_coach->coached_since = $request['coached_since'];
        $team_coach->coached_until = $request['coached_until'];


        // TODO: ne brisati trenutni tim ukoliko se promenio.
        if ($request['team'] != '') {
            if ($coach->current_team) {
                if ($coach->current_team->team->id == $request['team']) {
                    $team_coach->update();
                } else {

                    $team_coach_old_current = new Team_Coach();
                    $team_coach_old_current->coach_id = $id;
                    $team_coach_old_current->team_id = $coach->current_team->team_id;
                    $team_coach_old_current->coached_since = $coach->current_team->coached_since;
                    $team_coach_old_current->coached_until= Carbon::yesterday()->format('y-m-d');
                    $team_coach_old_current->update();

                    $team_coach->save();
                }
            }
            else {
                $team_coach->save();
            }
        }
        else {
            if ($coach->current_team != '') {
                $team_coach->coached_until = Carbon::yesterday()->format('y-m-d');
                $team_coach->update();
            }
        }

    }

    public static function delete($id)
    {
        Cypher::Run("MATCH (n:Coach) WHERE ID(n) = $id DETACH DELETE n");

        Redis::decr("count:coaches");
    }
}
