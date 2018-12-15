@extends('layouts.app')

@section('content')


    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/lumen/bootstrap.min.css">
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
                                        <th class="avatar">Logo</th>
                                        <th>Tim</th>
                                        <th>Oznaka</th>
                                        <th>Grad</th>
                                        <th>Opis</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($teams as $team )
                                        <tr class="ok">
                                            <td class="avatar"><img id="img" src={{$team['image']}}></td>
                                            <td><a href="/teams/{{$team['id']}}">{{$team['name']}}</a></td>
                                            <td>{{$team['short_name']}}</td>
                                            <td>{{$team['city']}}</td>
                                            <td>{{$team['description']}}</td>
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