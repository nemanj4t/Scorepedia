@extends('layouts.app')

@section('content')
    <style>
        #coach-img {
            max-width:200px;
        }
        .team-members {
            margin-bottom: unset;
        }
        .team-title {
            margin-bottom: 20px;
        }
    </style>

    @php
        /** @var \App\Team $team */
        /** @var \App\Team_Coach $teamCoach */
        /** @var \App\Player_Team[] $currentPlayers */
    @endphp

    <div class="container content">
        <div class="row" style=" background-position: center; background-size:100%; background:url({{$team->background_image}});">
            <div class="col-md-4">
                <img class="img-thumbnail rounded-circle" style="max-width: 200px; margin: 50px;" src={{$team->image}}>
            </div>
            <div class="col-md-4">
                <div class="heading">
                    <h2 style="padding-top: 50px; color:white;"><strong>{{$team->name}}</strong></h2>
                    <h3 style="color: white;">{{$team->short_name}}</h3>
                </div><!-- //end heading -->
            </div>
        </div>
        <div class="row shadow p-3 mb-5 bg-white rounded">
            <span style="margin-right: 90px;">PTS | <strong>{{$standings['points']}}</strong></span>
            <span style="margin-right: 90px;">Wins | <strong>{{$standings['wins']}}</strong></span>
            <span style="margin-right: 90px;">Losses | <strong>{{$standings['losses']}}</strong></span>
            <span style="margin-right: 90px;">Percentage | <strong>{{$standings['percentage']}}%</strong></span>
            <span style="margin-right: 90px;">Home | <strong>{{$standings['home']}}</strong></span>
            <span style="margin-right: 90px;">Road | <strong>{{$standings['road']}}</strong></span>
            <span style="margin-right: 90px;">Streak | <strong>{{$standings['streak']}}</strong></span>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    @if ($team->current_coach != null)
                    <div class="col-md-6">
                        <div class="team-members">
                            <div class="team-avatar">
                                <img class="img-thumbnail" id="coach-img" src={{$team->current_coach->image}} alt="">
                            </div>
                            <a href="/coaches/{{$team->current_coach->id}}">
                            <div class="team-desc">
                                <h3>{{$team->current_coach->name}}</h3>
                                <span>Coach</span>
                            </div>
                            </a>
                        </div>
                        <div class="team-title">
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active btn btn-outline-secondary" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="false">All players</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-secondary" id="teams-tab" data-toggle="tab" href="#teams" role="tab" aria-controls="teams" aria-selected="true">Current players</a>
                            </li>
                        </ul>
                        <div class="tab-content ml-1" id="myTabContent">
                            {{--Teams tab--}}
                            <div class="tab-pane fade" id="teams" role="tabpanel" aria-labelledby="teams-tab">
                                <div class="container" style="margin-top:20px;">
                                    <div class="row">
                                        <div id="user" class="col-md-12" >
                                            <div class="panel panel-primary panel-table animated slideInDown">
                                                <div class="panel-body">
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="list">
                                                            <table class="table table-striped table-bordered table-list">
                                                                <thead>
                                                                <tr>
                                                                    <th class="avatar">Image</th>
                                                                    <th>Name</th>
                                                                    <th>Position</th>
                                                                    <th>Number</th>
                                                                    <th>Played since</th>
                                                                    <th>Played until</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($team->current_players as $current_player)
                                                                    <tr>
                                                                        <td><img id="img" src="{{$current_player->player->image}}"></td>
                                                                        <td><a href="/players/{{$current_player->player->id}}">{{$current_player->player->name}}</a></td>
                                                                        <td>{{$current_player->position}}</td>
                                                                        <td>{{$current_player->number}}</td>
                                                                        <td>{{$current_player->played_since}}</td>
                                                                        <td>Present</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div><!-- END id="list" -->

                                                    </div><!-- END tab-content -->
                                                </div>
                                            </div><!--END panel-table-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                <div class="container" style="margin-top:20px;">
                                    <div class="row">
                                        <div id="user" class="col-md-12" >
                                            <div class="panel panel-primary panel-table animated slideInDown">
                                                <div class="panel-body">
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="list">
                                                            <table class="table table-striped table-bordered table-list">
                                                                <thead>
                                                                <tr>
                                                                    <th class="avatar">Image</th>
                                                                    <th>Name</th>
                                                                    <th>Position</th>
                                                                    <th>Number</th>
                                                                    <th>Played since</th>
                                                                    <th>Played until</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($team->all_players as $player)
                                                                    <tr>
                                                                        <td><img id="img" src="{{$player['player']['image']}}"></td>
                                                                        <td><a href="/players/{{$player['player']['id']}}">{{$player['player']['name']}}</a></td>
                                                                        <td>{{$player['plays_for']['position']}}</td>
                                                                        <td>{{$player['plays_for']['number']}}</td>
                                                                        <td>{{$player['plays_for']['played_since']}}</td>
                                                                        @if (array_key_exists('played_until', $player['plays_for']))
                                                                            <td>{{$player['plays_for']['played_since']}}</td>
                                                                        @else
                                                                            <td>Present</td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div><!-- END id="list" -->

                                                    </div><!-- END tab-content -->
                                                </div>
                                            </div><!--END panel-table-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @if ($best_players['points'] != null)
                    <div class="row">
                        @foreach($best_players as $key => $best_player)
                            @if ($key == 'rebounds')
                                @break
                            @endif
                            <div class="col-md-4">
                                <div>
                                    <div class="team-members">
                                        <div class="team-avatar">
                                            <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$best_player->player->image}} alt="">
                                        </div>
                                        <a href="/players/{{$best_player->player->id}}">
                                            <div class="team-desc">
                                                <h1 style="text-align: center;">{{$best_player->number}}</h1>
                                                <h4>{{$best_player->player->name}}</h4>
                                            </div>
                                        </a>
                                    </div>
                                    <div style="text-align: center;">
                                        <span>{{$best_player->position}} Most <strong>{{$key}}</strong> | <strong>@if($best_player->player->statistics[$key] == null) 0 @else{{$best_player->player->statistics[$key]}} @endif</strong></span>
                                        <br>
                                        <span><strong>{{$best_player->player->height}}</strong> cm | <strong> {{$best_player->player->weight}} kg</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="team-title">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row" style="justify-content: center;">
                        @foreach($best_players as $key => $best_player)
                            @if($key == 'rebounds' or $key == 'assists')
                                <div class="col-md-4">
                                    <div>
                                        <div class="team-members">
                                            <div class="team-avatar">
                                                <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$best_player->player->image}} alt="">
                                            </div>
                                            <a href="/players/{{$best_player->player->id}}">
                                                <div class="team-desc">
                                                    <h1 style="text-align: center;">{{$best_player->number}}</h1>
                                                    <h4>{{$best_player->player->name}}</h4>
                                                </div>
                                            </a>
                                        </div>
                                        <div style="text-align: center;">
                                            <span>{{$best_player->position}} Most <strong>{{$key}}</strong> | <strong>@if($best_player->player->statistics[$key] == null) 0 @else{{$best_player->player->statistics[$key]}} @endif</strong></span>
                                            <br>
                                            <span><strong>{{$best_player->player->height}}</strong> cm | <strong> {{$best_player->player->weight}} kg</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="team-title">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                </div>
            </div>
        {{--Preporuceni artikli za tim--}}
        @include('articles/recommend')
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>

@endsection
