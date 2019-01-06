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
            <div class="row container-fluid" style=" background-position: center; background-size:100%; background:url({{$team->background_image}});">
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
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    @if ($teamCoach)
                    <div class="col-md-6">
                        <div class="team-members">
                            <div class="team-avatar">
                                <img class="img-thumbnail" id="coach-img" src={{$teamCoach->coach->image}} alt="">
                            </div>
                            <a href="/coaches/{{$teamCoach->coach_id}}">
                            <div class="team-desc">
                                <h3>{{$teamCoach->coach->name}}</h3>
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
                    <div class="col-md-12">
                        <div class="row" style="justify-content: center;">
                            <div class="panel panel-primary panel-table animated slideInDown">
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="list">
                                            <table class="table table-striped table-bordered table-list">
                                                <thead>
                                                <tr>
                                                    <th class="avatar">Image</th>
                                                    <th>Number</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Height</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($currentPlayers as $player)
                                                    <tr class="ok">
                                                        <td class="avatar"><img id="img" src={{$player->player->image}}></td>
                                                        <td>{{$player->number}}</td>
                                                        <td><a href="/players/{{$player->player->id}}">{{$player->player->name}}</a></td>
                                                        <td>{{$player->position}}</td>
                                                        <td>{{$player->player->height}} cm</td>
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
            <div class="col-md-6">
                <div class="row">
                    @foreach($currentPlayers as $key => $player)
                        @if($key == 3)
                            @break
                        @endif
                        <div class="col-md-4">
                            <div class="team-members">
                                <div class="team-avatar">
                                    <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$player->player->image}} alt="">
                                </div>
                                <a href="/players/{{$player->player->id}}">
                                    <div class="team-desc">
                                        <h4>{{$player->player->name}}</h4>
                                        <span>Height: {{$player->player->height}} cm</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <div class="team-title">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(count($currentPlayers) > 3)
                <div class="row" style="justify-content: center">
                    @for($i=3; $i < 5; $i++)
                    <div class="col-sm-4">
                        <div class="team-members">
                            <div class="team-avatar">
                                <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$currentPlayers[$i]->player->image}} alt="">
                            </div>
                            <a href="/players/{{$currentPlayers[$i]->player->id}}">
                                <div class="team-desc">
                                    <h4>{{$currentPlayers[$i]->player->name}}</h4>
                                    <span>Height: {{$currentPlayers[$i]->player->height}} cm</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endfor
                </div><!-- //end row -->
                @endif
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>

@endsection