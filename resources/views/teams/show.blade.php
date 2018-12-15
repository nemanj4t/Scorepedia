@extends('layouts.app')

@section('content')
    <style>
        #coach-img {
            max-width:200px;
        }
    </style>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <!--
    Bootstrap Line Tabs by @keenthemes
    A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
    Licensed under MIT
    -->
    <div class="container content">
        <row>
            <div class="col-md-16 container-fluid" style=" background-size:100%; background:url({{$team['background_image']}});">
                <div class="col-md-4">
                    <img class="img-thumbnail" style="max-width: 200px; margin: 50px;" src={{$team['image']}}>
                </div>
                <div class="col-md-4">
                    <div class="heading">
                        <h2 style="padding-top: 50px; color:white;"><strong>{{$team['name']}}</strong></h2>
                        <h3 style="color: white;">{{$team['short_name']}}</h3>
                    </div><!-- //end heading -->
                </div>
            </div>
        </row>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-6">
                    <div class="team-members">
                        <div class="team-avatar">
                            <img class="img-thumbnail" id="coach-img" src={{$coach['image']}} alt="">
                        </div>
                        <a href="/coaches/{{$coach['id']}}">
                        <div class="team-desc">
                            <h3>{{$coach['name']}}</h3>
                            <span>Coach</span>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
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
                                            @foreach ($players as $player)
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
                            <div class="panel-footer text-center">
                                <ul class="pagination">
                                    <li ><a>«</a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li ><a href="#">2</a></li>
                                    <li ><a href="#">3</a></li>
                                    <li ><a>»</a></li>
                                </ul>
                            </div>
                        </div><!--END panel-table-->
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @for($i = 0; $i<3; $i++)
                    <div class="col-md-4">
                        <div class="team-members">
                            <div class="team-avatar">
                                <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$players[$i]['image']}} alt="">
                            </div>
                            <a href="/players/{{$players[$i]['id']}}">
                                <div class="team-desc">
                                    <h4>{{$players[$i]['name']}}</h4>
                                    <span>Height: {{$players[$i]['height']}} cm</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endfor
                <div class="col-sm-4 col-sm-offset-2">
                    <div class="team-members">
                        <div class="team-avatar">
                            <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$players[3]['image']}} alt="">
                        </div>
                        <a href="/players/{{$players[3]['id']}}">
                            <div class="team-desc">
                                <h4>{{$players[3]['name']}}</h4>
                                <span>Height: {{$players[3]['height']}} cm</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-members">
                        <div class="team-avatar">
                            <img class="img-responsive img-thumbnail" style="max-height: 250px;" src={{$players[4]['image']}} alt="">
                        </div>
                        <a href="/players/{{$players[4]['id']}}">
                            <div class="team-desc">
                                <h4>{{$players[4]['name']}}</h4>
                                <span>Height: {{$players[4]['height']}} cm</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div><!-- //end row -->
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