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
        <a class="nav-link" href="/apanel/matches">Matches </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/apanel/articles">Articles </a>
    </li>
@endsection

@section('main')
    <div class="container mt-4 mb-4">
        <h2>Articles</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th><a href="/articles/create" class="btn btn-primary float-right">Add</a></th>
            </tr>
            </thead>
        </table>
        <div class="container">
        @foreach ($articles as $article)
            <div class="mt-4">
                <div class="span8 row">
                    <div class="col-md-4">
                        <img src="{{$article->image}}" style="max-width: 100%" alt="alt">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-10">
                                <p style="font-size: 24px">{{$article->title}} </p>
                            </div>
                            <div class="col-md-2">
                                <form action="/articles/{{$article->id}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete" />
                                    <button class="btn btn-danger btn-sm" type="submit">
                                        <i class="far fa-trash-alt"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="module line-clamp">
                            <p>{{$article->content}}</p>
                        </div>
                    </div>
                </div>
                @foreach($article->taggedPlayers as $player)
                    <a class="btn btn-sm btn-primary mt-2" href="/players/{{$player->id}}">{{$player->name}}</a>
                @endforeach
                @foreach($article->taggedCoaches as $coach)
                    <a class="btn btn-sm btn-secondary mt-2" href="/coaches/{{$coach->id}}">{{$coach->name}}</a>
                @endforeach
                @foreach($article->taggedTeams as $team)
                    <a class="btn btn-sm btn-dark mt-2" href="/teams/{{$team->id}}">{{$team->name}}</a>
                @endforeach
                <a href="/articles/{{$article->id}}" class="float-right"><strong>Read more ... </strong></a>
                <br>
                <hr>
            </div>
        @endforeach
        </div>
    </div>
@endsection