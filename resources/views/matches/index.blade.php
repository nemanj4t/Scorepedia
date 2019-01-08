@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Match[] $liveMatches */
        /** @var \App\Match[] $finishedMatches */
        /** @var \App\Match[] $upcomingMatches */
    @endphp

    @if(!empty($liveMatches))
    <div class="container card mt-4 mb-4">
        <div class="card-body">
            <h3>Live</h3>
            <div class="row justify-content-between">
                @foreach($liveMatches as $match)
                    <div class="col-md-5 m-4" style="border: dashed 4px; padding: 20px">
                        <div class="row">
                            <div class="col-md-4">
                                <img style="max-width: 100%;" src={{$match->team_match->home->image}}>
                            </div>
                            <div class="col-md-4" style="font-size: 20px;">
                                <div class="col-md-12 text-center">{{$match->team_match->home_statistic->points}} - {{$match->team_match->guest_statistic->points}}</div>
                                <div class="col-md-12 text-center"><a href="/matches/{{$match->id}}" class="btn btn-sm btn-dark ">Details</a></div>
                            </div>
                            <div class="col-md-4">
                                <img class="" style="max-width: 100%;" src={{$match->team_match->guest->image}}>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>{{$match->team_match->home->short_name}}</strong>
                            </div>
                            <div class="col-md-4 text-center">
                                <small><i>started {{(new \Carbon\Carbon($match->date." ".$match->time, 'Europe/Belgrade'))->diffForHumans()}}</i></small>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>{{$match->team_match->guest->short_name}}</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if(!empty($upcomingMatches))
        <div class="container card mt-4 mb-4">
            <div class="card-body">
                <h3>Upcoming</h3>
                <div class="row justify-content-between">
                    @foreach($upcomingMatches as $match)
                        <div class="col-md-5 m-4" style="border: dashed 1px; padding: 20px">
                            <div class="row">
                                <div class="col-md-4">
                                    <img style="max-width: 100%;" src={{$match->team_match->home->image}}>
                                </div>
                                <div class="col-md-4" style="font-size: 20px;">
                                    <div class="col-md-12 text-center">{{$match->team_match->home_statistic->points}} - {{$match->team_match->guest_statistic->points}}</div>
                                    <div class="col-md-12 text-center"><a href="/matches/{{$match->id}}" class="btn btn-sm btn-dark ">Details</a></div>
                                </div>
                                <div class="col-md-4">
                                    <img class="" style="max-width: 100%;" src={{$match->team_match->guest->image}}>
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{$match->team_match->home->short_name}}</strong>
                                </div>
                                <div class="col-md-4 text-center">
                                    <small><i>starts {{(new \Carbon\Carbon($match->date." ".$match->time, 'Europe/Belgrade'))->diffForHumans()}}</i></small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{$match->team_match->guest->short_name}}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(!empty($finishedMatches))
        <div class="container card mt-4 mb-4">
            <div class="card-body">
                <h3>Finished</h3>
                <div class="row justify-content-between">
                    @foreach($finishedMatches as $match)
                        <div class="col-md-5 m-4" style="border: dashed 1px; padding: 20px">
                            <div class="row">
                                <div class="col-md-4">
                                    <img style="max-width: 100%;" src={{$match->team_match->home->image}}>
                                </div>
                                <div class="col-md-4" style="font-size: 20px;">
                                    <div class="col-md-12 text-center">{{$match->team_match->home_statistic->points}} - {{$match->team_match->guest_statistic->points}}</div>
                                    <div class="col-md-12 text-center"><a href="/matches/{{$match->id}}" class="btn btn-sm btn-dark ">Details</a></div>
                                </div>
                                <div class="col-md-4">
                                    <img class="" style="max-width: 100%;" src={{$match->team_match->guest->image}}>
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{$match->team_match->home->short_name}}</strong>
                                </div>
                                <div class="col-md-4 text-center">
                                    <small><i>{{(new \Carbon\Carbon($match->date." ".$match->time, 'Europe/Belgrade'))}}</i></small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{$match->team_match->guest->short_name}}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection