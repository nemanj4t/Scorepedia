@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="container">
        <div class="row">
            <nav class="col-sm-3 col-md-2 hidden-xs-down bg-dark sidebar">
                <ul class="nav nav-pills flex-column mt-4" id="sidenav">
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Overview' ? "active" : ""}}" href="/apanel">Overview </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Team' ? "active" : ""}}" href="/apanel?active=Team&route=teams">Teams </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Player' ? "active" : ""}}" href="/apanel?active=Player&route=players">Players </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Coach' ? "active" : ""}}" href="/apanel?active=Coach&route=coaches">Coaches </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active == 'Match' ? "active" : ""}}" href="/apanel?active=Match&route=matches">Matches </a>
                    </li>
                </ul>
            </nav>

            <main class="col-sm-8 offset-sm-3 col-md-8 offset-md-1 pt-3 mt-4">
                <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
                <div class="container">
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
                </div>
                @if(isSet($_GET['active']) && ($_GET['route'] == "players" || $_GET['route'] == "coaches" || $_GET['route'] == "teams"))
                <br>
                <div class="table-responsive">
                    <table class="table table-striped mb-5">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Image</th>
                            <th><a href="{{$_GET['route']}}/create" class="btn btn-primary float-right">Add</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $single_data)
                        <tr>
                            <td>{{$single_data->id}}</td>
                            <td><a href="{{$_GET['route']}}/{{$single_data->id}}">{{$single_data->name}}</a></td>
                            <td>{{$single_data->city}}</td>
                            <td><img id="img" src="{{$single_data->image}}"></td>
                            <td>
                                <form action="{{$_GET['route']}}/{{$single_data->id}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete" />
                                    <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                                </form>
                                <a href="{{$_GET['route']}}/edit/{{$single_data->id}}" class="btn btn-sm btn-primary float-right">Edit</a>
                                @if($_GET['route'] == 'players')
                                    <a href="/coaches/edit/{{$single_data->id}}/team_coach" class="btn btn-sm btn-primary mr-2 float-right">Edit Career</a>
                                @elseif($_GET['route'] == 'coaches')
                                    <a href="/players/edit/{{$single_data->id}}/plays_for_teams" class="btn btn-sm btn-primary mr-2 float-right">Edit Career</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif(isset($_GET['active']) && $_GET['route'] == "matches")
                    <div class="container mt-4 mb-4">
                        <h2>Matches</h2>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><a href="{{$_GET['route']}}/create" class="btn btn-primary float-right">Add</a></th>
                            </tr>
                            </thead>
                        </table>

                        @if(!empty($data['live']))
                        <h3>Live</h3>
                        <div class="row justify-content-between">
                            @foreach($data['live'] as $match)
                                <div class="col-md-5 m-4 card" style="border: solid 1px; padding: 0">
                                    <div class="card-header">
                                        <label class="float-left" for="">{{(new \Carbon\Carbon($match['date']." ".$match['time']))->diffForHumans()}}</label>
                                        <form action="matches/{{$match['id']}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                                        </form>
                                        <a href="/admin/matches/{{$match['id']}}" class="btn btn-primary btn-sm float-right">Manage</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img class="float-left" style="max-width: 100%;" src={{$match['home']['image']}}>
                                            </div>
                                            <div class="col-md-4" style="font-size: 20px;">
                                                <div class="col-md-12 text-center">{{$match['home']['points']}} - {{$match['guest']['points']}}</div>
                                                <div class="col-md-12 text-center"><a href="/matches/{{$match['id']}}" class="btn btn-sm btn-dark">Details</a></div>
                                            </div>
                                            <div class="col-md-4">
                                                <img class="float-right" style="max-width: 100%;" src={{$match['guest']['image']}}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif

                        @if(!empty($data['upcoming']))
                        <hr>
                        <h3>Upcoming</h3>
                        <div class="row justify-content-between">
                            @foreach($data['upcoming'] as $match)
                                <div class="col-md-5 m-4 card" style="border: solid 1px; padding: 0">
                                    <div class="card-header">
                                        <label class="float-left" for="">{{(new \Carbon\Carbon($match['date']." ".$match['time']))->diffForHumans()}}</label>
                                        <form action="matches/{{$match['id']}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img class="float-left" style="max-width: 100%;" src={{$match['home']['image']}}>
                                            </div>
                                            <div class="col-md-4" style="font-size: 20px;">
                                                <div class="col-md-12 text-center">{{$match['home']['points']}} - {{$match['guest']['points']}}</div>
                                                <div class="col-md-12 text-center"><a href="/matches/{{$match['id']}}" class="btn btn-sm btn-dark">Details</a></div>
                                            </div>
                                            <div class="col-md-4">
                                                <img class="float-right" style="max-width: 100%;" src={{$match['guest']['image']}}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif

                        @if(!empty($data['finished']))
                        <hr>
                        <h3>Finished</h3>
                        <div class="row justify-content-between">
                            @foreach($data['finished'] as $match)
                                <div class="col-md-5 m-4 card" style="border: solid 1px; padding: 0">
                                    <div class="card-header">
                                        <label class="float-left" for="">{{$match['date']}}</label>
                                        <form action="matches/{{$match['id']}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete" />
                                            <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                                        </form>
                                        <a href="/admin/matches/{{$match['id']}}" class="btn btn-primary btn-sm float-right">Manage</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img class="float-left" style="max-width: 100%;" src={{$match['home']['image']}}>
                                            </div>
                                            <div class="col-md-4" style="font-size: 20px;">
                                                <div class="col-md-12 text-center">{{$match['home']['points']}} - {{$match['guest']['points']}}</div>
                                                <div class="col-md-12 text-center"><a href="/matches/{{$match['id']}}" class="btn btn-sm btn-dark">Details</a></div>
                                            </div>
                                            <div class="col-md-4">
                                                <img class="float-right" style="max-width: 100%;" src={{$match['guest']['image']}}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                @else
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
                @endif
            </main>
        </div>
    </div>
@endsection