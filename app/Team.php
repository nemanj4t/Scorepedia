<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Carbon;
class Team
{
    public $id;
    public $name;
    public $short_name;
    public $city;
    public $players;
    public $captain;
    public $trainer;
    public $description;
    public $image;
    // Vraca sve timove
    public static function getTeams()
    {
        $result = Cypher::run("MATCH (n:Team) RETURN n");
        $teams = [];
        foreach($result->getRecords() as $record)
        {
            $properties_array = $record->getPropertiesOfNode();
            $id_array = ["id" =>  $record->getIdOfNode()];
            $team = array_merge($properties_array, $id_array);
            array_push($teams, $team);
        }
        return $teams;
    }

    public static function getTeamById($id)
    {
        $result = Cypher::run("MATCH (n:Team) WHERE ID(n) = $id RETURN n");
        $record = $result->getRecords()[0];

        $properties_array = $record->getPropertiesOfNode();
        $id_array = ["id" =>  $record->getIdOfNode()];
        $team = array_merge($properties_array, $id_array);


        return $team;
    }

    public static function getAll() {

        $resultTeams = Cypher::run("MATCH (t:Team) RETURN t");
        $teams = [];
        foreach ($resultTeams->getRecords() as $record) {
            $team = $record->getPropertiesOfNode();
            $team = array_merge($team, ['id' => $record->getIdOfNode()]);
            $current_coach = self::getCurrentCoach($record->getIdOfNode());
            $all_coaches = Team_Coach::getByTeamId($record->getIdOfNode());
            $current_players = Player_Team::getCurrentPlayers($record->getIdOfNode());
            $all_players = Player_Team::getByTeamId($record->getIdOfNode());
            $team = array_merge($team, ['current_players' => $current_players]);
            $team = array_merge($team, ['all_players' => $all_players]);
            $team = array_merge($team, ['current_coach' => $current_coach]);
            $team = array_merge($team, ['all_coaches' => $all_coaches]);
            array_push($teams, $team);
        }
        return $teams;
    }

    public static function getById($id) {

        $team = null;
        $result = Cypher::run("MATCH (t:Team) WHERE ID(t) = $id RETURN t")->getRecords();
        $record = $result[0];
        $team = $record->getPropertiesOfNode();
        $team = array_merge($team, ['id' => $record->getIdOfNode()]);
        $current_coach = self::getCurrentCoach($record->getIdOfNode());
        $all_coaches = Team_Coach::getByTeamId($record->getIdOfNode());
        $current_players = Player_Team::getCurrentPlayers($record->getIdOfNode());
        $all_players = Player_Team::getByTeamId($record->getIdOfNode());
        $team = array_merge($team, ['current_players' => $current_players]);
        $team = array_merge($team, ['all_players' => $all_players]);
        $team = array_merge($team, ['current_coach' => $current_coach]);
        $team = array_merge($team, ['all_coaches' => $all_coaches]);

        return $team;
    }

    public static function getCurrentCoach($id) {

        $current_coach = '';
        $team_coach = Team_Coach::getByTeamId($id);

        foreach ($team_coach as $rel) {
            if (Carbon::parse($rel['coached']['coached_until'])->gt(Carbon::now()))
                $current_coach = $rel;
        }

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

        Redis::zadd("points", 0, $t->getRecords()[0]->getIdOfNode());
        Redis::zadd("wins", 0, $t->getRecords()[0]->getIdOfNode());
        Redis::zadd("losses", 0, $t->getRecords()[0]->getIdOfNode());
        Redis::zadd("percentage", 0, $t->getRecords()[0]->getIdOfNode());
        Redis::zadd("home", 0, $t->getRecords()[0]->getIdOfNode());
        Redis::zadd("road", 0, $t->getRecords()[0]->getIdOfNode());
        Redis::zadd("streak", 0, $t->getRecords()[0]->getIdOfNode());

        Redis::hmset(
            "team:standings:{$t->getRecords()[0]->getIdOfNode()}",
            "points", 0,
            "wins", 0,
            "losses", 0,
            "percentage", 0,
            "home", 0,
            "road", 0,
            "streak", 0);

        Redis::incr("count:teams");

    }

    public static function update($id, $request) {

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

    public static function delete($id) {

        Cypher::Run("MATCH (n:Team) WHERE ID(n) = $id DETACH DELETE n");

        Redis::zrem("points", $id);
        Redis::zrem("wins", $id);
        Redis::zrem("loses", $id);
        Redis::zrem("percentage", $id);
        Redis::zrem("home", $id);
        Redis::zrem("road", $id);
        Redis::zrem("streak", $id);

        Redis::del("team:standings:{$id}");

        foreach(Redis::keys("match:*:team:{$id}") as $key) {
            $matchIndex = intval(explode(":", $key)[1]);
            Match::deleteMatch($matchIndex);
        };

        Redis::decr("count:teams");
    }

}
