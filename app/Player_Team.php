<?php

namespace App;

use GraphAware\Neo4j\Client\Formatter\Result;
use Ahsan\Neo4j\Facade\Cypher;
use Carbon\Facade;

class Player_Team
{
    public $position;
    public $number;
    public $plays_since;
    public $plays_until;

    /** @var Team */
    public $team;
    /** @var Player */
    public $player;


    public static function buildFromRelationshipAndNode($relationship, $node)
    {
        $player_team = new Player_Team();
        $player_team->number = $relationship->value('number');
        $player_team->position = $relationship->value('position');
        $player_team->plays_since = $relationship->value('since');
        $player_team->plays_until = $relationship->value('until', null);

        $player_team->team = Team::buildFromNode($node);

        return $player_team;
    }

    public function save()
    {
        $plays_since = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_since)->format("Ymd");


        if($this->plays_until)
        {
            $plays_until = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_until)->format("Ymd");

            // umesto TEAM_PLAYER je PLAYED ili PLAYS
            Cypher::Run ("MATCH (n:Player), (t:Team) WHERE ID(n) = " . $this->player->id . " AND ID(t) = " . $this->team->id .
                " CREATE (n)-[:PLAYED {
            position: '" . $this->position . "', 
            number: " . $this->number . ", 
            since: " . $plays_since . ",  
            until: " . $plays_until . "
            }]->(t)");
        }
        else
        {
            Cypher::Run ("MATCH (n:Player), (t:Team) WHERE ID(n) = " . $this->player->id . " AND ID(t) = " . $this->team->id.
                " CREATE (n)-[:PLAYS {
            position: '" . $this->position . "', 
            number: " . $this->number . ", 
            since: " . $this->plays_since . "  
            }]->(t)");
        }
    }

    public function update()
    {
        $plays_since = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_since)->format("Ymd");
        // Proveri se koja je veza bila ranije
        $relType = Cypher::Run ("MATCH (p:Player)-[r]-(t:Team) WHERE ID(p) = " . $this->player_id .
            " AND ID(t) = " . $this->team_id . " RETURN type(r)")->getRecords()[0]->value("type(r)");

        if($this->plays_until)
        {
            $plays_until = \Carbon\Carbon::createFromFormat("Y-m-d", $this->plays_until)->format("Ymd");
            // Ako je i ranije bila PLAYED onda se samo menja atribut "until"
            if($relType == "PLAYED")
            {
                Cypher::Run ("MATCH (p:Player)-[r:PLAYED]-(t:Team) 
                WHERE ID(p) = " . $this->player_id . " AND ID(t) = " . $this->team_id .
                    " SET r.position = '" . $this->position . "', 
                    r.number = " . $this->number . ", 
                    r.since = " . $plays_since . ",  
                    r.until = " . $plays_until);
            }
            else
            {
                // Ako je bila PLAYS onda se prethodna veza zamenjuje vezom PLAYED
                Cypher::Run ("MATCH (p:Player)-[r:PLAYS]-(t:Team) WHERE ID(p) = ". $this->player_id .
                    " AND ID(t) = ". $this->team_id .
                    " CREATE (p)-[r2:PLAYED]->(t) 
                        SET r2 = r,
                        r2.position = '" . $this->position . "',
                        r2.number = " . $this->number . ",
                        r2.since = " . $plays_since . ",
                        r2.until = " . $plays_until .
                        " WITH r
                        DELETE r");
            }
        }
        else
        {
            // Ako je bilo PLAYED i a treba da se promeni u PLAYS
            if($relType == "PLAYED")
            {
                Cypher::Run ("MATCH (p:Player)-[r:PLAYED]-(t:Team) WHERE ID(p) = ". $this->player_id .
                    " AND ID(t) = ". $this->team_id .
                    " CREATE (p)-[r2:PLAYS]->(t) 
                        SET r2 = r,
                        r2.position = '" . $this->position . "',
                        r2.number = " . $this->number . ",
                        r2.since = " . $plays_since . ",
                        r2.until = null 
                         WITH r
                        DELETE r");
            }
            else
            {
                // Ako je bilo PLAYED i ako je i dalje PLAYS
                Cypher::Run("MATCH (p:Player)-[r:PLAYS]-(t:Team) 
                WHERE ID(p) = " . $this->player_id . " AND ID(t) = " . $this->team_id .
                    " SET r.position = '" . $this->position . "', 
                    r.number = " . $this->number . ", 
                    r.since = " . $plays_since);
            }

        }
    }

    // Vraca timove u kojima je igrac sa datim '$id' igrao
    public static function getByPlayerId($id)
    {
        /** @var Result $teamsResult */
        $teamsResult = Cypher::Run("MATCH (n:Player)-[r:PLAYS|PLAYED]-(t:Team) WHERE ID(n) = $id return r, t
                      ORDER BY r.until DESC");

        $plays_for_teams = [];

        foreach ($teamsResult->getRecords() as $record) {
            // Vraca vrednosti za tim za koji igrac igra
            $relationship = $record->relationshipValue('r');
            $node = $record->nodeValue('t');
            $team_player = self::buildFromRelationshipAndNode($relationship, $node);

            $plays_for_teams[] = $team_player;
        }
        return $plays_for_teams;
    }

    public static function getByTeamId($id)
    {
        $playerResult = Cypher::Run("MATCH (p:Player)-[r:PLAYS|PLAYED]-(t:Team) WHERE ID(t) = $id return r, p
                      ORDER BY r.until DESC");

        $plays_for_teams = [];

        foreach ($playerResult->getRecords() as $record) {
            // Vraca vrednosti za tim za koji igrac igra
            $player = $record->nodeValue('p');
            $player_props = $player->values();
            $player_id = ["id" => $player->identity()];

            // Vraca vrednosti za relaciju PLAYS_FOR_TEAM
            $relationship = $record->relationShipValue('r');
            $relationship_props = $relationship->values();
            $relationship_id = ["id" => $relationship->identity()];

            // Spaja kljuceve i propertije
            $player = array_merge($player_props, $player_id);
            $plays_for_team = array_merge($relationship_props, $relationship_id);

            // Niz koji sadrzi relaciju i tim
            $plays = ['plays_for' => $plays_for_team, 'player' => $player];

            array_push($plays_for_teams, $plays);
        }
        return $plays_for_teams;
    }


    /**
     * @param $teamId
     * @return Player_Team[]
     */
    public static function getCurrentPlayers($teamId)
    {
        /** @var Result $result */
        $result = Cypher::Run("MATCH (p:Player)-[r:PLAYS]-(t:Team) WHERE ID(t) = $teamId return r, p
                      ORDER BY r.until DESC");


        $plays_for_team = [];
        foreach ($result->getRecords() as $record) {
            $playerNode = $record->nodeValue('p');
            $relationship = $record->relationshipValue('r');

            $player_team = new Player_Team();
            $player_team->position = $relationship->value('position');
            $player_team->number = $relationship->value('number');
            $player_team->plays_since = $relationship->value('since', null);
            $player_team->plays_until = $relationship->value('until', null);
            $player_team->player = Player::buildFromNode($playerNode);

            $plays_for_team[] = $player_team;
        }

        return $plays_for_team;
    }

    /**
     * @param $rel
     * @param $playerId
     * @return Player_Team
     */
    public static function buildFromRequest($rel, $playerId, $teamId)
    {
        $player_team = new Player_Team();
        $player_team->position = $rel['player_position'];
        $player_team->number = $rel['player_number'];
        $player_team->plays_since = $rel['player_since'];
        $player_team->plays_until = $rel['player_until'];

        $player_team->player = Player::getById($playerId);
        $player_team->team = Team::getById($teamId);

        return $player_team;
    }
    // Brisanje veze
    public static function delete($player_id, $team_id)
    {
        Cypher::run("MATCH (n:Player)-[r:PLAYS|PLAYED]-(t:Team)
            WHERE ID(n) = ".$player_id." AND ID(t) = ".$team_id.
            " DELETE r");

        foreach(Redis::keys("match:*:team:{$team_id}:player:{$player_id}") as $key) {
            Redis::del($key);
        };
    }
}
