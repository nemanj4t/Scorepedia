@extends('layouts.app')

@section('content')


    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://daneden.github.io/animate.css/animate.min.css">

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
                                        <th>Bio</th>
                                        <th>Height</th>
                                        <th>Weight</th>
                                        <th>City</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($players as $player)
                                        <tr class="ok">
                                            <td class="avatar"><img id="img" class="avatar" src={{$player['image']}}></td>
                                            <td><a href="/players/{{$player['id']}}">{{$player['name']}}</a></td>
                                            <td>{{$player['bio']}}</td>
                                            <td>{{$player['height']}} cm</td>
                                            <td>{{$player['weight']}} kg</td>
                                            <td>{{$player['city']}}</td>
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

@endsection