@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Player[] $homePlayers */
        /** @var \App\Player[] $guestPlayers */
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
                        @foreach($homePlayers as $player)
                            <tr>
                                <th scope="row">{{$player->id}}</th>
                                <td>{{$player->name}}</td>
                                <td>{{$player->statistics['points']}}</td>
                                <td>{{$player->statistics['blocks']}}</td>
                                <td>{{$player->statistics['rebounds']}}</td>
                                <td>{{$player->statistics['fouls']}}</td>
                                <td>{{$player->statistics['assists']}}</td>
                                <td>{{$player->statistics['steals']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="match-view" class="col-md-4">
                <div class="row">
                    <div class="col-md-3">
                        <img class="float-left" id="club-logo" src="{{$match['home']['image']}}">
                    </div>
                    <div id="result" class="col-md-6 text-center">{{$home['points']}} - {{$guest['points']}}</div>
                    <div class="col-md-3">
                        <img class="float-right" id="club-logo" src="{{$match['guest']['image']}}">
                    </div>
                </div>
                <div class="row p-4">
                    <table class="table text-center">
                        <tbody>
                        <tr>
                            <th scope="row">blocks</th>
                            <td>{{$home['blocks']}}</td>
                            <td>{{$guest['blocks']}}</td>
                            <th scope="row">blocks</th>
                        </tr>
                        <tr>
                            <th scope="row">rebounds</th>
                            <td>{{$home['rebounds']}}</td>
                            <td>{{$guest['rebounds']}}</td>
                            <th scope="row">rebounds</th>
                        </tr>
                        <tr>
                            <th scope="row">fouls</th>
                            <td>{{$home['fouls']}}</td>
                            <td>{{$guest['fouls']}}</td>
                            <th scope="row">fouls</th>
                        </tr>
                        <tr>
                            <th scope="row">assists</th>
                            <td>{{$home['assists']}}</td>
                            <td>{{$guest['assists']}}</td>
                            <th scope="row">assists</th>
                        </tr>
                        <tr>
                            <th scope="row">steals</th>
                            <td>{{$home['steals']}}</td>
                            <td>{{$guest['steals']}}</td>
                            <th scope="row">rebounds</th>
                        </tr>
                        </tbody>
                    </table>
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
                        @foreach($guestPlayers as $player)
                            <tr>
                                <th scope="row">{{$player->id}}</th>
                                <td>{{$player->name}}</td>
                                <td>{{$player->statistics['points']}}</td>
                                <td>{{$player->statistics['blocks']}}</td>
                                <td>{{$player->statistics['rebounds']}}</td>
                                <td>{{$player->statistics['fouls']}}</td>
                                <td>{{$player->statistics['assists']}}</td>
                                <td>{{$player->statistics['steals']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

