<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Carbon;
class Team extends Model
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
    public static function getAll() {
        $resultTeams = Cypher::run("MATCH (t:Team) RETURN t");
        $teams = [];
        foreach ($resultTeams->getRecords() as $record) {
            $team = $record->getPropertiesOfNode();
            $team = array_merge($team, ['id' => $record->getIdOfNode()]);
            $current_coach = '';
            $all_coaches = [];
            $all_players = [];
            $current_players = [];
            $currentTeamId = $record->getIdOfNode();
            $team_coach = Cypher::run("MATCH (t:Team)-[r:TEAM_COACH]-(c:Coach) WHERE ID(t) =". $record->getIdOfNode()." RETURN c, r
                                    ORDER BY r.coached_until DESC");
            foreach ($team_coach->getRecords() as $record) {
                $coach = $record->nodeValue('c');
                $coach_props = $coach->values();
                $coach_id = ["id" => $coach->identity()];
                // Vraca vrednosti za relaciju TEAM_COACH
                $relationship = $record->relationShipValue('r');
                $relationship_props = $relationship->values();
                // Spaja kljuceve i propertije
                $coach = array_merge($coach_props, $coach_id);
                if (Carbon::parse($relationship_props['coached_until'])->gt(Carbon::now()))
                    $current_coach = $coach;
                array_push($all_coaches, $coach);
            }
            $team_player = Cypher::run("MATCH (t:Team)-[r:TEAM_PLAYER]-(p:Player) WHERE ID(t) =". $currentTeamId ." RETURN p, r
                                    ORDER BY r.played_until DESC");
            foreach ($team_player->getRecords() as $record) {
                $player = $record->nodeValue('p');
                $player_props = $player->values();
                $player_id = ["id" => $player->identity()];
                // Vraca vrednosti za relaciju TEAM_COACH
                $relationship = $record->relationShipValue('r');
                $relationship_props = $relationship->values();
                // Spaja kljuceve i propertije
                $player = array_merge($player_props, $player_id);
                $player = array_merge($player, ['played_since' => $relationship_props['played_since']]);
                $player = array_merge($player, ['played_until' => $relationship_props['played_until']]);
                if (Carbon::parse($relationship_props['played_until'])->gt(Carbon::now()))
                    array_push($current_players, $player);
                array_push($all_players, $player);
            }
            $team = array_merge($team, ['current_players' => $current_players]);
            $team = array_merge($team, ['all_players' => $all_players]);
            $team = array_merge($team, ['current_coach' => $current_coach]);
            $team = array_merge($team, ['all_coaches' => $all_coaches]);
            array_push($teams, $team);
        }
        return $teams;
    }
    public static function saveTeam($request) {
        if($request['coach'] != null)
            Cypher::run("MATCH (c:Coach) WHERE ID(c) = $request[coach]
                        CREATE (t:Team {name: '$request[name]', short_name: '$request[short_name]',
                        city: '$request[city]', description: '$request[description]', image: '$request[image]',
                        background_image: '$request[background_image]'})-[:TEAM_COACH{coached_since: '$request[coached_since]', coached_until: '$request[coached_until]'}]->(c)");
        else
            Cypher::run("CREATE (t:Team {name: '$request[name]', short_name: '$request[short_name]',
                        city: '$request[city]', description: '$request[description]', image: '$request[image]',
                        background_image: '$request[background_image]'})");
    }
    public static function getById($id) {
        $teams = Team::getAll();
        foreach ($teams as $team)
            if ($team['id'] == $id)
                return $team;
        return null;
    }
}
