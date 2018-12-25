<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Carbon;

class Coach
{
    public $id;
    public $name;
    public $city;
    public $current_team;
    public $bio;
    public $image;


    public static function getAll() {

        $resultCoaches = Cypher::run("MATCH (c:Coach) RETURN c");
        $coaches = [];
        foreach ($resultCoaches->getRecords() as $record) {
            $coach = $record->getPropertiesOfNode();
            $coach = array_merge($coach, ['id' => $record->getIdOfNode()]);
            $current_team = '';

            $team_coach = Team_Coach::getByCoachId($record->getIdOfNode());

            foreach ($team_coach as $team) {
                if (Carbon::parse($team['coached']['coached_until'])->gt(Carbon::now()))
                    $current_team = $team;
            }

            $coach = array_merge($coach, ['all_teams' => $team_coach]);
            $coach = array_merge($coach, ['current_team' => $current_team]);
            array_push($coaches, $coach);

        }

        return $coaches;
    }

    public static function saveCoach($request) {

        if($request['team'] != null)
            Cypher::run("MATCH (t:Team) WHERE ID(t) = $request[team]
                        CREATE (t)-[:TEAM_COACH{coached_since: '$request[coached_since]', coached_until: '$request[coached_until]'}]->(c:Coach {name: '$request[name]', bio: '$request[bio]', city: '$request[city]', image: '$request[image]'})");
        else
            Cypher::run("CREATE (c:Coach {name: '$request[name]', bio: '$request[bio]', city: '$request[city]', image: '$request[image]'})");
    }

    public static function getById($id) {

        $coaches = Coach::getAll();
        foreach ($coaches as $coach)
            if ($coach['id'] == $id)
                return $coach;

        return null;
    }

    public static function update($id, $request) {
        $coach = Coach::getById($id);
        Cypher::run("MATCH (c:Coach) WHERE ID(c) = $id SET c.name = '$request[name]', c.bio = '$request[bio]', c.city = '$request[city]', c.image = '$request[image]'");
        $team_coach = new Team_Coach(["coach_id" => $id, "team_name" => $request['team'], "coached_since" => $request['coached_since'], "coached_until" => $request['coached_until']]);
        if ($request['team'] != '') {
            if ($coach['current_team'] != '') {
                if ($coach['current_team']['team']['id'] == $request['team']) {
                    $team_coach->update();
                } else {
                    Team_Coach::delete($coach['current_team']['team']['id'], $id);
                    $team_coach->save();
                }
            }
            else {
                $team_coach->save();
            }
        }
        else {
            if ($coach['current_team'] != '')
                Team_Coach::delete($coach['current_team']['team']['id'], $id);
        }


    }
}
