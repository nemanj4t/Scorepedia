@extends('layouts.app')

@section('content')
    <div class=" mt-4 mb-4">
        <div class="row">
            <div class="col-3 mt-4 ml-4">
                <div class="contaienr">
                    @if(!empty($liveMatches))
                    @foreach($liveMatches as $match)
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img style="max-width: 100%;" src={{$match->team_match->home->image}}>
                                    </div>
                                    <div class="col-md-4" style="font-size: 20px;">
                                        <div class="col-md-12 text-center" style="font-size: 16px;">{{$match->team_match->home_statistic->points}} - {{$match->team_match->guest_statistic->points}}</div>
                                        <div class="col-md-12 text-center"><a href="/matches/{{$match->id}}" class="btn btn-sm btn-dark ">Details</a></div>
                                        <img src="http://www.pngall.com/wp-content/uploads/2018/03/Live-PNG-File.png" class="col-md-12" style="max-width: 100%; align:center" alt="">
                                    </div>
                                    <div class="col-md-4">
                                        <img class="" style="max-width: 100%;" src={{$match->team_match->guest->image}}>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <strong>{{$match->team_match->home->short_name}}</strong>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <small><i>{{(new \Carbon\Carbon($match->date." ".$match->time, 'Europe/Belgrade'))->diffForHumans()}}</i></small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <strong>{{$match->team_match->guest->short_name}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="jumbotron text-center">
                            <h1 class="display-4">Welcome!</h1>
                            <p class="lead">There is no live matches currently.</p>
                            <hr class="my-4">
                            <p>Enjoy browsing.</p>
                            <p class="lead">
                                <a class="btn btn-primary" href="/players">Learn more</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-8">
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
                                        <a href="/articles/{{$article->id}}" class="float-right"><strong>Read more ... </strong></a>
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
                        <br>
                        <hr>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection