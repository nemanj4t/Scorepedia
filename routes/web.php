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
Route::get('/', "HomeController@index");

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
Route::get('/apanel/articles', "AdminController@adminArticles");
Route::post('/admin/matches/data/{match}', "AdminController@postAddition");

Route::get('/teams', "TeamController@index");
Route::get('/teams/create', "TeamController@create")->middleware('auth');
Route::get('/teams/edit/{team}', "TeamController@edit")->middleware('auth');
Route::get('/teams/{team}', "TeamController@show");
Route::post('/teams', "TeamController@store")->middleware('auth');
Route::put('/teams/{team}', "TeamController@update")->middleware('auth');
Route::delete('/teams/{team}', "TeamController@destroy")->middleware('auth');

Route::get('/players/edit/{player}/plays_for_teams', "PlaysForTeamController@edit")->middleware('auth');
Route::put('/players/edit/{player}/plays_for_teams', "PlaysForTeamController@update")->middleware('auth');
Route::delete('/players/edit/{player}/plays_for_teams', "PlaysForTeamController@destroy")->middleware('auth');
Route::post('/players/edit/{player}/plays_for_teams', "PlaysForTeamController@store")->middleware('auth');

// PlayerController
Route::get('/players', "PlayerController@index");
Route::get('/players/create', "PlayerController@create")->middleware('auth');
Route::get('/players/edit/{player}', "PlayerController@edit")->middleware('auth');
Route::get('/players/{player}', "PlayerController@show");
Route::post('/players', "PlayerController@store")->middleware('auth');
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


Route::get('/matches', "MatchController@index");
Route::get('/matches/create', "MatchController@create")->middleware('auth');

Route::get('/matches/data', "MatchController@getData");

Route::post('/matches', "MatchController@store")->middleware('auth');
Route::put('/matches', "MatchController@update")->middleware('auth');
Route::get('/matches/{match}', "MatchController@show");
Route::delete('/matches/{match}', "MatchController@destroy")->middleware('auth');

Route::get('/statistics', "StatisticController@index");
Route::get('/statistics/full', "StatisticController@full");

Route::get('/standings', "StandingsController@index");
Route::get('/standings/points', "StandingsController@points");
Route::get('/standings/wins', "StandingsController@wins");
Route::get('/standings/losses', "StandingsController@losses");
Route::get('/standings/percentage', "StandingsController@percentage");
Route::get('/standings/home', "StandingsController@home");
Route::get('/standings/road', "StandingsController@road");
Route::get('/standings/streak', "StandingsController@streak");

Route::post('/matches/{match}/comments', "CommentController@store")->middleware('auth');
Route::delete('/matches/{match}/comments', "CommentController@destroy")->middleware('auth');

Route::get('/articles/create', "ArticleController@create")->middleware('auth');
Route::get('/articles/{article}', "ArticleController@show");
Route::post('/articles', "ArticleController@store")->middleware('auth');
Route::delete('/articles/{article}', "ArticleController@destroy")->middleware('auth');

Route::get('/search', "SearchController@index");


