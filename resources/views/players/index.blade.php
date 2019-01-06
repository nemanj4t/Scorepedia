@extends('layouts.app')

@section('content')

    @php
        /** @var \App\Player[] $players */
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
                                        <th>Bio</th>
                                        <th>Height</th>
                                        <th>Weight</th>
                                        <th>City</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($players as $player)
                                        <tr class="ok">
                                            @if (isset($player->image))
                                                <td class="avatar"><img id="img" class="avatar" src={{$player->image}}></td>
                                            @else
                                                <td class="avatar"><img id="img" class="avatar"></td>
                                            @endif
                                            <td><a href="/players/{{$player->id}}">{{$player->name}}</a></td>
                                            <td>{{$player->bio}}</td>
                                            <td>{{$player->height}} cm</td>
                                            <td>{{$player->weight}} kg</td>
                                            <td>{{$player->city}}</td>
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
