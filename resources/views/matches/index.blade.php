@extends('layouts.app')

@section('content')
    <div class="container card mt-4 mb-4">
        <div class="card-body">
            <h1>Live</h1>
            <div class="row justify-content-center">
                @foreach($matches as $match)
                    <div class="col-md-5 m-4" style="border: solid 1px; padding: 20px">
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
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection