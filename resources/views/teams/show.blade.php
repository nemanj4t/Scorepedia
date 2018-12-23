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

    <div class="container content">
            <div class="row container-fluid" style=" background-position: center; background-size:100%; background:url({{$team['background_image']}});">
                <div class="col-md-4">
                    <img class="img-thumbnail rounded-circle" style="max-width: 200px; margin: 50px;" src={{$team['image']}}>
                </div>
                <div class="col-md-4">
                    <div class="heading">
                        <h2 style="padding-top: 50px; color:white;"><strong>{{$team['name']}}</strong></h2>
                        <h3 style="color: white;">{{$team['short_name']}}</h3>
                    </div><!-- //end heading -->
                </div>
            </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="team-members">
                            <div class="team-avatar">
                                <img class="img-thumbnail" id="coach-img" src={{$team['current_coach']['image']}} alt="">
                            </div>
                            <a href="/coaches/{{$team['current_coach']['id']}}">
                            <div class="team-desc">
                                <h3>{{$team['current_coach']['name']}}</h3>
                                <span>Coach</span>
                            </div>
                            </a>
                        </div>
                        <div class="team-title">
                        </div>
                    </div>
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
                                                @foreach ($team['current_players'] as $player)
                                                    <tr class="ok">
                                                        <td class="avatar"><img id="img" src={{$player['image']}}></td>
                                                        <td>number</td>
                                                        <td><a href="/players/{{$player['id']}}">{{$player['name']}}</a></td>
                                                        <td>pos</td>
                                                        <td>{{$player['height']}} cm</td>
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
                    @foreach($team['current_players'] as $key => $player)
                        @if($key == 3)
                            @break
                        @endif
                        <div class="col-md-4">
                            <div class="team-members">
                                <div class="team-avatar">
                                    <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$player['image']}} alt="">
                                </div>
                                <a href="/players/{{$player['id']}}">
                                    <div class="team-desc">
                                        <h4>{{$player['name']}}</h4>
                                        <span>Height: {{$player['height']}} cm</span>
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
                @if(count($team['current_players']) > 3)
                <div class="row" style="justify-content: center">
                    @for($i=3; $i < 5; $i++)
                    <div class="col-sm-4">
                        <div class="team-members">
                            <div class="team-avatar">
                                <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$team['current_players'][$i]['image']}} alt="">
                            </div>
                            <a href="/players/{{$team['current_players'][$i]['id']}}">
                                <div class="team-desc">
                                    <h4>{{$team['current_players'][$i]['name']}}</h4>
                                    <span>Height: {{$team['current_players'][$i]['height']}} cm</span>
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
    <center>
        <strong>Powered by <a href="http://j.mp/metronictheme" target="_blank">KeenThemes</a></strong>
    </center>
    <br>
    <br>

@endsection