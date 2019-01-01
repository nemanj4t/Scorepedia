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
        $team_ids = array_reverse(Redis::zrange("points", 0, -1));
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team['id']);
            $team = array_merge($team, $stands);
            array_push($data, $team);
        }

        return $data;
    }

    public function wins()
    {
        $team_ids = array_reverse(Redis::zrange("wins", 0, -1));
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team['id']);
            $team = array_merge($team, $stands);
            array_push($data, $team);
        }

        return $data;
    }

    public function losses()
    {
        $team_ids = array_reverse(Redis::zrange("losses", 0, -1));
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team['id']);
            $team = array_merge($team, $stands);
            array_push($data, $team);
        }

        return $data;
    }

    public function percentage()
    {
        $team_ids = array_reverse(Redis::zrange("percentage", 0, -1));
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team['id']);
            $team = array_merge($team, $stands);
            array_push($data, $team);
        }

        return $data;
    }

    public function home()
    {
        $team_ids = array_reverse(Redis::zrange("home", 0, -1));
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team['id']);
            $team = array_merge($team, $stands);
            array_push($data, $team);
        }

        return $data;
    }

    public function road()
    {
        $team_ids = array_reverse(Redis::zrange("road", 0, -1));
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team['id']);
            $team = array_merge($team, $stands);
            array_push($data, $team);
        }

        return $data;
    }

    public function streak()
    {
        $team_ids = array_reverse(Redis::zrange("streak", 0, -1));
        $data = [];

        foreach ($team_ids as $id) {
            $team = Team::getTeamById(intval($id));
            $stands = Redis::hgetall('team:standings:'. $team['id']);
            $team = array_merge($team, $stands);
            array_push($data, $team);
        }

        return $data;
    }
}
