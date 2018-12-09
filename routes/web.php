<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Ahsan\Neo4j\Facade\Cypher;


Route::get('/', function () {
    //dd(Cypher::run("MATCH (n) RETURN n"));
    return view('welcome');
});
