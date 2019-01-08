@extends('layouts.admin')

@section('nav-items')
    <li class="nav-item">
        <a class="nav-link" href="/apanel">Overview </a>
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
        <a class="nav-link active" href="/apanel/matches">Matches </a>
    </li>
@endsection

@section('main')
    <div class="container mt-4 mb-4">
        <h2>Matches</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th><a href="/matches/create" class="btn btn-primary float-right">Add</a></th>
            </tr>
            </thead>
        </table>

        @if(!empty($liveMatches))
            <h3>Live</h3>
            <div class="row justify-content-between">
                @foreach($liveMatches as $match)
                    <div class="col-md-5 m-4 card" style="border: solid 1px; padding: 0">
                        <div class="card-header">
                            <label class="float-left" for="">{{(new \Carbon\Carbon($match->date." ".$match->time, 'Europe/Belgrade'))->diffForHumans()}}</label>
                            <form action="/matches/{{$match->id}}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="delete" />
                                <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                            </form>
                            <a href="/admin/matches/{{$match->id}}" class="btn btn-primary btn-sm float-right">Manage</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="float-left" style="max-width: 100%;" src={{$match->team_match->home->image}}>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12 text-center">{{$match->team_match->home_statistic->points}} - {{$match->team_match->guest_statistic->points}}</div>
                                    <div class="col-md-12 text-center"><a href="/matches/{{$match->id}}" class="btn btn-sm btn-dark">Details</a></div>
                                </div>
                                <div class="col-md-4">
                                    <img class="float-right" style="max-width: 100%;" src={{$match->team_match->guest->image}}>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($upcomingMatches))
            <hr>
            <h3>Upcoming</h3>
            <div class="row justify-content-between">
                @foreach($upcomingMatches as $match)
                    <div class="col-md-5 m-4 card" style="border: solid 1px; padding: 0">
                        <div class="card-header">
                            <label class="float-left" for="">{{(new \Carbon\Carbon($match->date." ".$match->time, 'Europe/Belgrade'))->diffForHumans()}}</label>
                            <form action="/matches/{{$match->id}}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="delete" />
                                <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="float-left" style="max-width: 100%;" src={{$match->team_match->home->image}}>
                                </div>
                                <div class="col-md-4" style="font-size: 20px;">
                                    <div class="col-md-12 text-center result">{{$match->team_match->home_statistic->points}} - {{$match->team_match->guest_statistic->points}}</div>
                                    <div class="col-md-12 text-center"><a href="/matches/{{$match->id}}" class="btn btn-sm btn-dark">Details</a></div>
                                </div>
                                <div class="col-md-4">
                                    <img class="float-right" style="max-width: 100%;" src={{$match->team_match->guest->image}}>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($finishedMatches))
            <hr>
            <h3>Finished</h3>
            <div class="row justify-content-between">
                @foreach($finishedMatches as $match)
                    <div class="col-md-5 m-4 card" style="border: solid 1px; padding: 0">
                        <div class="card-header">
                            <label class="float-left" for="">{{(new \Carbon\Carbon($match->date." ".$match->time, 'Europe/Belgrade'))->diffForHumans()}}</label>
                            <form action="/matches/{{$match->id}}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="delete" />
                                <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                            </form>
                            <a href="/admin/matches/{{$match->id}}" class="btn btn-primary btn-sm float-right">Manage</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="float-left" style="max-width: 100%;" src={{$match->team_match->home->image}}>
                                </div>
                                <div class="col-md-4" style="font-size: 20px;">
                                    <div class="col-md-12 text-center result">{{$match->team_match->home_statistic->points}} - {{$match->team_match->guest_statistic->points}}</div>
                                    <div class="col-md-12 text-center"><a href="/matches/{{$match->id}}" class="btn btn-sm btn-dark">Details</a></div>
                                </div>
                                <div class="col-md-4">
                                    <img class="float-right" style="max-width: 100%;" src={{$match->team_match->guest->image}}>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection