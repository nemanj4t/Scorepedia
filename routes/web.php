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

/*funkcija za vracanje propertija iz recorda $record->getPropertiesOfNode() */
/*funkcija za vracanje Id-a iz recorda $record->getIdOfNode() */

Route::get('/', "HomeController@index");
//Admin
Route::get('/admin', "Auth\LoginController@showLoginForm");
Route::post('/admin', "Auth\LoginController@login")->name('login');
Route::get('/admin/matches/{match}', "AdminController@matchManager");
Route::post('/logout', "Auth\LoginController@logout")->name('logout');
Route::get('/apanel', "AdminController@index");
Route::get('/admin/matches/data/{match}', "AdminController@data");
Route::get('/apanel/matches', "AdminController@adminMatches");
Route::get('/apanel/players', "AdminController@adminPlayers");
Route::get('/apanel/teams', "AdminController@adminTeams");
Route::get('/apanel/coaches', "AdminController@adminCoaches");
Route::post('/admin/matches/data/{match}', "AdminController@postAddition");


// TeamController
Route::get('/teams', "TeamController@index");
Route::get('/teams/create', "TeamController@create")->middleware('auth');   // pogled za kreiranje tima (zasto je ova ruta morala da se prebaci na vrh?!)
Route::get('/teams/edit/{team}', "TeamController@edit")->middleware('auth');  // prikaz svih timova
Route::get('/teams/{team}', "TeamController@show");    // prikaz konkretnog tima
Route::post('/teams', "TeamController@store")->middleware('auth');          // usnimanje kreiranog tima
Route::put('/teams/{team}', "TeamController@update")->middleware('auth');
Route::delete('/teams/{team}', "TeamController@destroy")->middleware('auth');

// PlaysForTeamController
Route::get('/players/edit/{player}/plays_for_teams', "PlaysForTeamController@edit")->middleware('auth');
Route::put('/players/edit/{player}/plays_for_teams', "PlaysForTeamController@update")->middleware('auth');
Route::delete('/players/edit/{player}/plays_for_teams', "PlaysForTeamController@destroy")->middleware('auth');
Route::post('/players/edit/{player}/plays_for_teams', "PlaysForTeamController@store")->middleware('auth');

// PlayerController
Route::get('/players', "PlayerController@index");          // prikaz svih igraca
Route::get('/players/create', "PlayerController@create")->middleware('auth');   // pogled za kreiranje igraca
Route::get('/players/edit/{player}', "PlayerController@edit")->middleware('auth');  // pogled za editovanje igraca
Route::get('/players/{player}', "PlayerController@show");  // prikaz konkretnog igraca
Route::post('/players', "PlayerController@store")->middleware('auth');         // usnimanje kreiranog igraca
Route::put('/players/{player}', "PlayerController@update");
Route::delete('/players/{player}', "PlayerController@destroy")->middleware('auth');

// CoachController
Route::get('/coaches', "CoachController@index");
Route::get('/coaches/create', "CoachController@create")->middleware('auth');
Route::get('/coaches/edit/{coach}', "CoachController@edit")->middleware('auth');
Route::get('/coaches/{coach}', "CoachController@show");
Route::post('/coaches', "CoachController@store")->middleware('auth');
Route::put('/coaches/{coach}', "CoachController@update")->middleware('auth');
Route::delete('/coaches/{coach}', "CoachController@destroy")->middleware('auth');

// TeamCoachController
Route::get('/coaches/edit/{coach}/team_coach', "TeamCoachController@edit")->middleware('auth');
Route::put('/coaches/edit/{coach}/team_coach', "TeamCoachController@update")->middleware('auth');
Route::delete('/coaches/edit/{coach}/team_coach', "TeamCoachController@destroy")->middleware('auth');
Route::post('/coaches/edit/{coach}/team_coach', "TeamCoachController@store")->middleware('auth');

// MatchesController
// Ukoliko nam mecevi nisu na home page-u
Route::get('/matches', "MatchController@index");            // prikaz liste meceva (kesirani ???) // prikaz konkretnog meca
Route::get('/matches/create', "MatchController@create")->middleware('auth');    // pogled za kreiranje meca

Route::get('/matches/data', "MatchController@getData"); // test za pub/sub

Route::post('/matches', "MatchController@store")->middleware('auth');           // usnimanje kreiranog meca
Route::put('/matches', "MatchController@update")->middleware('auth');
Route::get('/matches/{match}', "MatchController@show");
Route::delete('/matches/{match}', "MatchController@destroy")->middleware('auth');


// StatisticController
Route::get('/statistics', "StatisticController@index");          // prikazuje za svaku od par statistika po 5 igraca npr.
Route::get('/statistics/full', "StatisticController@full");    // prikazuje celokupnu stats tabelu

// StandingsController
Route::get('/standings', "StandingsController@index");
Route::get('/standings/points', "StandingsController@points");
Route::get('/standings/wins', "StandingsController@wins");
Route::get('/standings/losses', "StandingsController@losses");
Route::get('/standings/percentage', "StandingsController@percentage");
Route::get('/standings/home', "StandingsController@home");
Route::get('/standings/road', "StandingsController@road");
Route::get('/standings/streak', "StandingsController@streak");

// CommentController
// Komentari su u okviru meca
Route::post('/matches/{match}/comments', "CommentController@store")->middleware('auth');   // usnimanje novog komentara (mozda ne treba kontroler)
Route::delete('/matches/{match}/comments', "CommentController@destroy")->middleware('auth');   // usnimanje novog komentara (mozda ne treba kontroler)

// ArticleController
Route::get('/articles', "ArticleController@index");
Route::get('/articles/{article}', "ArticleController@show");
Route::get('/articles/create', "ArticleController@create")->middleware('auth');
Route::post('/articles', "ArticleController@store")->middleware('auth');
Route::delete('/articles', "ArticleController@destroy")->middleware('auth');

//SearchController
Route::get('/search', "SearchController@index");


