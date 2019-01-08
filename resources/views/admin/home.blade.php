@extends('layouts.admin')

@section('nav-items')
    <li class="nav-item">
        <a class="nav-link active" href="/apanel">Overview </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/apanel/teams">Teams </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/apanel/players">Players </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/apanel/coaches">Coaches </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/apanel/matches">Matches </a>
    </li>
@endsection

@section('main')
    <div class="row text-center">
        <div class="col">
            <div class="counter">
                <i class="fa fa-user fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="{{$count_visits}}" data-speed="1500"></h2>
                <p class="count-text ">Count Visitors</p>
            </div>
        </div>
        <div class="col">
            <div class="counter">
                <i class="fas fa-users fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="{{$count_teams}}" data-speed="1500"></h2>
                <p class="count-text ">Registred Teams</p>
            </div>
        </div>
        <div class="col">
            <div class="counter">
                <i class="fas fa-basketball-ball fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="{{$count_players}}" data-speed="1500"></h2>
                <p class="count-text ">Registred Players</p>
            </div>
        </div>
        <div class="col">
            <div class="counter">
                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="{{$count_coaches}}" data-speed="1500"></h2>
                <p class="count-text ">Registred Coaches</p>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="jumbotron text-center">
            <h1>Welcome to Admin Panel</h1>
            <p>Chose from side-menu to manipulate data</p>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row text-center">
            <div class="col">
                <div class="counter">
                    <i class="fab fa-medium-m fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="{{$count_matches}}" data-speed="1500"></h2>
                    <p class="count-text ">Count Matches</p>
                </div>
            </div>
            <div class="col">
                <div class="counter">
                    <i class="far fa-newspaper fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="1700" data-speed="1500"></h2>
                    <p class="count-text ">Count Articles</p>
                </div>
            </div>
            <div class="col">
                <div class="counter">
                    <i class="fas fa-comments fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
                    <p class="count-text ">Count Comments</p>
                </div>
            </div>
            <div class="col">
                <div class="counter">
                    <i class="fa fa-sign-in fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="{{$count_logins}}" data-speed="1500"></h2>
                    <p class="count-text ">Count Logins</p>
                </div>
            </div>
        </div>
    </div>
@endsection