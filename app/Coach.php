<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Carbon;

class Coach extends Model
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
            $all_teams = [];

            $team_coach = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(c) =". $record->getIdOfNode()." RETURN t, r
                                    ORDER BY r.coached_until DESC");

            foreach ($team_coach->getRecords() as $record) {
                $team = $record->nodeValue('t');
                $team_props = $team->values();
                $team_id = ["id" => $team->identity()];

                // Vraca vrednosti za relaciju TEAM_COACH
                $relationship = $record->relationShipValue('r');
                $relationship_props = $relationship->values();


                // Spaja kljuceve i propertije
                $team = array_merge($team_props, $team_id);
                $team = array_merge($team, ['coached_since' => $relationship_props['coached_since']]);
                $team = array_merge($team, ['coached_until' => $relationship_props['coached_until']]);

                if (Carbon::parse($relationship_props['coached_until'])->gt(Carbon::now()))
                    $current_team = $team;

                array_push($all_teams, $team);
            }
            $coach = array_merge($coach, ['current_team' => $current_team]);
            $coach = array_merge($coach, ['all_teams' => $all_teams]);
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
}
