@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Match $match */
    @endphp
    <div class="container mt-4">
        <div class="row">
            <div id="home" class="col-md-4 p-4">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">p</th>
                            <th scope="col">b</th>
                            <th scope="col">r</th>
                            <th scope="col">f</th>
                            <th scope="col">a</th>
                            <th scope="col">s</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($match->team_match->home->current_players as $current_player)
                            <tr>
                                <th scope="row">{{$current_player->player->id}}</th>
                                <td>{{$current_player->player->name}}</td>
                                <td>{{$current_player->player->statistics->points}}</td>
                                <td>{{$current_player->player->statistics->blocks}}</td>
                                <td>{{$current_player->player->statistics->rebounds}}</td>
                                <td>{{$current_player->player->statistics->fouls}}</td>
                                <td>{{$current_player->player->statistics->assists}}</td>
                                <td>{{$current_player->player->statistics->steals}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="match-view" class="col-md-4">
                <div class="row">
                    <div class="col-md-3">
                        <img class="float-left" id="club-logo" src="{{$match->team_match->home->image}}">
                    </div>
                    <div class="col-md-6 text-center result">{{$match->team_match->home_statistic->points}} - {{$match->team_match->guest_statistic->points}}</div>
                    <div class="col-md-3">
                        <img class="float-right" id="club-logo" src="{{$match->team_match->guest->image}}">
                    </div>
                </div>
                <div class="row p-4">
                    <table class="table text-center">
                        <tbody>
                        <tr>
                            <th scope="row">blocks</th>
                            <td>{{$match->team_match->home_statistic->blocks}}</td>
                            <td>{{$match->team_match->guest_statistic->blocks}}</td>
                            <th scope="row">blocks</th>
                        </tr>
                        <tr>
                            <th scope="row">rebounds</th>
                            <td>{{$match->team_match->home_statistic->rebounds}}</td>
                            <td>{{$match->team_match->guest_statistic->rebounds}}</td>
                            <th scope="row">rebounds</th>
                        </tr>
                        <tr>
                            <th scope="row">fouls</th>
                            <td>{{$match->team_match->home_statistic->fouls}}</td>
                            <td>{{$match->team_match->guest_statistic->fouls}}</td>
                            <th scope="row">fouls</th>
                        </tr>
                        <tr>
                            <th scope="row">assists</th>
                            <td>{{$match->team_match->home_statistic->assists}}</td>
                            <td>{{$match->team_match->guest_statistic->assists}}</td>
                            <th scope="row">assists</th>
                        </tr>
                        <tr>
                            <th scope="row">steals</th>
                            <td>{{$match->team_match->home_statistic->steals}}</td>
                            <td>{{$match->team_match->guest_statistic->steals}}</td>
                            <th scope="row">steals</th>
                        </tr>
                        </tbody>
                    </table>
                    <div class="col-md-12">
                        <p>
                            <button class="btn btn-primary col-md-12" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Comments
                            </button>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <form action="/matches/{{$match->id}}/comments" method="post">
                                @csrf
                                <input type="text" name="name" placeholder="name" class="form-control form-group" required>
                                <textarea name="content" placeholder="comment" class="form-control form-group" id="" cols="30" rows="4" required></textarea>
                                <button type="submit" class="btn btn-secondary btn-sm form-group">Post</button>
                            </form>
                            @foreach($comments as $comment)
                                <div class="card card-body">
                                    <div>
                                        <small>{{ $comment->convertToDiffForHumans() }}</small>
                                        @auth
                                            <form class="float-right" action="/matches/{{$match->id}}/comments" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="delete" />
                                                <input type="hidden" name="id" value="{{$comment->id}}" />
                                                <button type="submit" class="btn btn-danger btn-sm"><strong>x</strong></button>
                                            </form>
                                        @endauth
                                    </div>
                                    <strong>{{$comment->publisher}}</strong>
                                    <p>{{$comment->content}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div id="guest" class="col-md-4 p-4">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">p</th>
                            <th scope="col">b</th>
                            <th scope="col">r</th>
                            <th scope="col">f</th>
                            <th scope="col">a</th>
                            <th scope="col">s</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($match->team_match->guest->current_players as $current_player)
                            <tr>
                                <th scope="row">{{$current_player->number}}</th>
                                <td>{{$current_player->player->name}}</td>
                                <td>{{$current_player->player->statistics->points}}</td>
                                <td>{{$current_player->player->statistics->blocks}}</td>
                                <td>{{$current_player->player->statistics->rebounds}}</td>
                                <td>{{$current_player->player->statistics->fouls}}</td>
                                <td>{{$current_player->player->statistics->assists}}</td>
                                <td>{{$current_player->player->statistics->steals}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

