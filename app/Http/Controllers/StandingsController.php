<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StandingsController extends Controller
{
    //
    public  function index()
    {
        return view('standings.index');
    }
}
