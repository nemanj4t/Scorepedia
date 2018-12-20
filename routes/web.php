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
Route::post('/logout', "Auth\LoginController@logout")->name('logout');
Route::get('/apanel', "AdminController@index");

// TeamController
Route::get('/teams/create', "TeamController@create");   // pogled za kreiranje tima (zasto je ova ruta morala da se prebaci na vrh?!)
Route::get('/teams', "TeamController@index");          // prikaz svih timova
Route::get('/teams/{team}', "TeamController@show");    // prikaz konkretnog tima

Route::post('/teams', "TeamController@store");          // usnimanje kreiranog tima
Route::put('/teams/{team}', "TeamController@update");
Route::delete('/teams/{team}', "TeamController@destroy");

// PlayerController
Route::get('/players', "PlayerController@index");          // prikaz svih igraca
Route::get('/players/create', "PlayerController@create");   // pogled za kreiranje igraca
Route::get('/players/edit/{player}', "PlayerController@edit");  // pogled za editovanje igraca
Route::get('/players/{player}', "PlayerController@show");  // prikaz konkretnog igraca
Route::post('/players', "PlayerController@store");         // usnimanje kreiranog igraca
Route::put('/players/{player}', "PlayerController@update");
Route::delete('/players/{player}', "PlayerController@destroy");

// CoachController
Route::get('/coaches', "CoachController@index");
Route::get('/coaches/create', "CoachController@create"); // prikaz svih trenera
Route::get('/coaches/{coach}', "CoachController@show");      // prikaz konkretnog trenera // kreiranje novog trenera
Route::post('/coaches', "CoachController@store");            // usnimanje novog trenra
Route::put('/coaches/{coach}', "CoachController@update");
Route::delete('/coaches/{coach}', "CoachController@destroy");

// MatchesController
// Ukoliko nam mecevi nisu na home page-u
Route::get('/matches', "MatchController@index");            // prikaz liste meceva (kesirani ???)
Route::get('/matches/{match}', "MatchController@show");     // prikaz konkretnog meca
Route::get('/matches/create', "MatchController@create");    // pogled za kreiranje meca
Route::post('/matches', "MatchController@store");           // usnimanje kreiranog meca
Route::put('/matches/{match}', "MatchController@update");
Route::delete('/matches', "MatchController@destroy");

// StatisticController
Route::get('/statistics', "StatisticController@index");          // prikazuje za svaku od par statistika po 5 igraca npr.
Route::get('/statistics/points', "StatisticController@points"); // prikazuje detaljnije statistiku za poene npr. sa vise igraca
Route::get('/statistics/rebounds', "StatisticController@rebounds"); // isto kao iznad
// ...

// CommentController
// Komentari su u okviru meca
Route::post('/matches/{match}/comments', "CommentController@store");   // usnimanje novog komentara (mozda ne treba kontroler)

