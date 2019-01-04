@extends('layouts.app')

@section('content')
    @if(!empty($liveMatches))
    <div class="container card mt-4 mb-4">
        <div class="card-body">
            <h3>Live</h3>
            <div class="row justify-content-between">
                @foreach($liveMatches as $match)
                    <div class="col-md-5 m-4" style="border: dashed 4px; padding: 20px">
                        <div class="row">
                            <div class="col-md-4">
                                <img style="max-width: 100%;" src={{$match['home']['image']}}>
                            </div>
                            <div class="col-md-4" style="font-size: 20px;">
                                <div class="col-md-12 text-center">{{$match['home']['points']}} - {{$match['guest']['points']}}</div>
                                <div class="col-md-12 text-center"><a href="/matches/{{$match['id']}}" class="btn btn-sm btn-dark ">Details</a></div>
                            </div>
                            <div class="col-md-4">
                                <img class="" style="max-width: 100%;" src={{$match['guest']['image']}}>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>{{$match['home']['short_name']}}</strong>
                            </div>
                            <div class="col-md-4 text-center">
                                <small><i>started {{(new \Carbon\Carbon($match['date']." ".$match['time']))->diffForHumans()}}</i></small>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>{{$match['guest']['short_name']}}</strong>
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
                    <div class="col-md-5 m-4" style="border: dashed 2px; padding: 20px">
                        <div class="row">
                            <div class="col-md-4">
                                <img style="max-width: 100%;" src={{$match['home']['image']}}>
                            </div>
                            <div class="col-md-4" style="font-size: 20px;">
                                <div class="col-md-12 text-center">{{$match['home']['points']}} - {{$match['guest']['points']}}</div>
                                <div class="col-md-12 text-center"><a href="/matches/{{$match['id']}}" class="btn btn-sm btn-dark ">Details</a></div>
                            </div>
                            <div class="col-md-4">
                                <img class="" style="max-width: 100%;" src={{$match['guest']['image']}}>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>{{$match['home']['short_name']}}</strong>
                            </div>
                            <div class="col-md-4 text-center">
                                <small><i>starts {{(new \Carbon\Carbon($match['date']." ".$match['time']))->diffForHumans()}}</i></small>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>{{$match['guest']['short_name']}}</strong>
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
                    <div class="col-md-5 m-4" style="border: dashed 2px; padding: 20px">
                        <div class="row">
                            <div class="col-md-4">
                                <img style="max-width: 100%;" src={{$match['home']['image']}}>
                            </div>
                            <div class="col-md-4" style="font-size: 20px;">
                                <div class="col-md-12 text-center">{{$match['home']['points']}} - {{$match['guest']['points']}}</div>
                                <div class="col-md-12 text-center"><a href="/matches/{{$match['id']}}" class="btn btn-sm btn-dark ">Details</a></div>
                            </div>
                            <div class="col-md-4">
                                <img class="" style="max-width: 100%;" src={{$match['guest']['image']}}>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>{{$match['home']['short_name']}}</strong>
                            </div>
                            <div class="col-md-4 text-center">
                                <small><i>{{$match['date']}}</i></small>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>{{$match['guest']['short_name']}}</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection