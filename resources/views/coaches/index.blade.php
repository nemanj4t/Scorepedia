@extends('layouts.app')

@section('content')

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
                                        <th>Team</th>
                                        <th>City</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($coaches as $coach)
                                        <tr class="ok">
                                            <td class="avatar"><img id="img" class="avatar" src={{$coach['image']}}></td>
                                            <td><a href="/coaches/{{$coach['id']}}">{{$coach['name']}}</a></td>
                                            <td>{{$coach['bio']}}</td>
                                            @if($coach['current_team']== '')
                                                <td>No professional engagement currently</td>
                                                @else
                                                    <td><a href="/teams/{{$coach['current_team']['id']}}">{{$coach['current_team']['name']}}</a></td>
                                            @endif
                                            <td>{{$coach['city']}}</td>
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

@endsection