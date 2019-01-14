<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class StandingsController extends Controller
{
    //

    public function index()
    {
        return view('standings.index');
    }


    public function points()
    {
        $team_ids = Redis::zrevrange("points", 0, -1);
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team->id);

            $row = [
                'id' => $team->id,
                'image' => $team->image,
                'name' => $team->name
            ];
            $row = array_merge($row, $stands);
            array_push($data, $row);
        }

        return $data;
    }

    public function wins()
    {
        $team_ids = Redis::zrevrange("wins", 0, -1);
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team->id);
            $row = [
                'id' => $team->id,
                'image' => $team->image,
                'name' => $team->name
            ];
            $row = array_merge($row, $stands);
            array_push($data, $row);
        }

        return $data;
    }

    public function losses()
    {
        $team_ids = Redis::zrevrange("losses", 0, -1);
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team->id);
            $row = [
                'id' => $team->id,
                'image' => $team->image,
                'name' => $team->name
            ];
            $row = array_merge($row, $stands);
            array_push($data, $row);
        }

        return $data;
    }

    public function percentage()
    {
        $team_ids = Redis::zrevrange("percentage", 0, -1);
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team->id);
            $row = [
                'id' => $team->id,
                'image' => $team->image,
                'name' => $team->name
            ];
            $row = array_merge($row, $stands);
            array_push($data, $row);
        }

        return $data;
    }

    public function home()
    {
        $team_ids = Redis::zrevrange("home", 0, -1);
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team->id);
            $row = [
                'id' => $team->id,
                'image' => $team->image,
                'name' => $team->name
            ];
            $row = array_merge($row, $stands);
            array_push($data, $row);
        }

        return $data;
    }

    public function road()
    {
        $team_ids = Redis::zrevrange("road", 0, -1);
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team->id);
            $row = [
                'id' => $team->id,
                'image' => $team->image,
                'name' => $team->name
            ];
            $row = array_merge($row, $stands);
            array_push($data, $row);
        }

        return $data;
    }

    public function streak()
    {
        $team_ids = Redis::zrevrange("streak", 0, -1);
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team->id);
            $row = [
                'id' => $team->id,
                'image' => $team->image,
                'name' => $team->name
            ];
            $row = array_merge($row, $stands);
            array_push($data, $row);
        }

        return $data;
    }
}
