@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title mb-4">
                            <div class="d-flex justify-content-start">
                                <div class="image-container">
                                    <img src="{{ $player['image'] }}" id="image" style="width: 150px; height: 150px" class="img-thumbnail" />
                                </div>
                                <div class="userData ml-3">
                                    <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="javascript:void(0);">{{ $player['name'] }}</a></h2>
                                    <label style="font-weight:bold;">Bio</label>
                                    <p>{{ $player['bio'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">Basic Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="teams-tab" data-toggle="tab" href="#teams" role="tab" aria-controls="teams" aria-selected="false">Teams</a>
                                    </li>
                                </ul>
                                <div class="tab-content ml-1" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Name</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                {{ $player['name'] }}
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Height</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                {{ $player['height'] }} cm
                                            </div>
                                        </div>
                                        <hr />


                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Weight</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                {{ $player['weight'] }} kg
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">City</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                {{ $player['city'] }}
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
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
                                                                            <th class="avatar">Logo</th>
                                                                            <th>Team</th>
                                                                            <th>Position</th>
                                                                            <th>Number</th>
                                                                            <th>Played since</th>
                                                                            <th>Played until</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach ($plays_for_teams as $team)
                                                                            <tr class="ok">
                                                                                <td class="avatar"><img id="img" src={{$team['team']['image']}}></td>
                                                                                <td><a href="/teams/{{$team['team']['id']}}">{{$team['team']['name']}}</a></td>
                                                                                <td>{{$team['plays_for']['position']}}</td>
                                                                                <td>{{$team['plays_for']['number']}}</td>
                                                                                <td>{{ \Carbon\Carbon::parse($team['plays_for']['since'])->format('d-m-Y')}}</td>
                                                                                @if (isset($team['plays_for']['until']))
                                                                                    <td>{{ \Carbon\Carbon::parse($team['plays_for']['until'])->format('d-m-Y')}}</td>
                                                                                @else
                                                                                    <td> ??? </td>
                                                                                @endif
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--Sidebar za preporuke igraca--}}
            @include('layouts/sidebar')
        </div>
    </div>
@endsection