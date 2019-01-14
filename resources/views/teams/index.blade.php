@extends('layouts.app')

@section('content')
@php
    /** @var App\Team[] $teams */
@endphp
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
                                        <th>Abbreviation</th>
                                        <th>City</th>
                                        <th>Description</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($teams as $team )
                                        <tr class="ok">
                                            <td class="avatar"><img id="img" src={{$team->image}}></td>
                                            <td><a href="/teams/{{$team->id}}">{{$team->name}}</a></td>
                                            <td>{{$team->short_name}}</td>
                                            <td>{{$team->city}}</td>
                                            <td>{{$team->description}}</td>
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