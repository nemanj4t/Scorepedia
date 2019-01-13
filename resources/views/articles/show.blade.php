@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>{{$article->title}}</h1>
        <p><small>published on {{$article->timestamp}}</small></p>
        @foreach($article->taggedPlayers as $player)
            <a class="btn btn-sm btn-primary mt-2" href="/players/{{$player->id}}">{{$player->name}}</a>
        @endforeach
        @foreach($article->taggedCoaches as $coach)
            <a class="btn btn-sm btn-secondary mt-2" href="/coaches/{{$coach->id}}">{{$coach->name}}</a>
        @endforeach
        @foreach($article->taggedTeams as $team)
            <a class="btn btn-sm btn-dark mt-2" href="/teams/{{$team->id}}">{{$team->name}}</a>
        @endforeach
        <hr>
        <p class="text" style="font-size: 16px; text-align: justify">
            <img class="img-responsive img-rounded float-left m-2" style="max-width: 40%" alt="image" src="{{$article->image}}"/>

            {{$article->content}}
        </p>
    </div>
@endsection
