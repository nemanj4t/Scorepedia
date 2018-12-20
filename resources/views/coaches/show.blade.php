@extends('layouts.app')

@section('content')

    {{--Style--}}
    <style type="text/css">

        .image-container {
            position: relative;
        }

        .image {
            opacity: 1;
            display: block;
            width: 100%;
            height: auto;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .image-container:hover .image {
            opacity: 0.3;
        }

        .image-container:hover .middle {
            opacity: 1;
        }    </style>

    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title mb-4">
                            <div class="d-flex justify-content-start">
                                <div class="image-container">
                                    <img src="{{ $coach['image'] }}" id="image" style="width: 150px; height: 150px" class="img-thumbnail" />
                                </div>
                                <div class="userData ml-3">
                                    <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="javascript:void(0);">{{ $coach['name'] }}</a></h2>
                                    <label style="font-weight:bold;">Bio</label>
                                    <p>{{ $coach['bio'] }}</p>
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
                                                {{ $coach['name'] }}
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Team</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                @if($current_team == '')
                                                    <p>No proffessional engagement currently</p>
                                                    @else
                                                    <p><a href="/teams/{{$current_team['id']}}">{{$current_team['name']}}</a></p>
                                                @endif
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">City</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                {{ $coach['city'] }}
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
                                                                            <th>Coached since</th>
                                                                            <th>Coached until</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach ($coached_teams as $team)
                                                                            <tr class="ok">
                                                                                <td class="avatar"><img id="img" src={{$team['team']['image']}}></td>
                                                                                <td><a href="/teams/{{$team['team']['id']}}">{{$team['team']['name']}}</a></td>
                                                                                <td>{{$team['coach_team']['coached_since']}}</td>
                                                                                <td>{{$team['coach_team']['coached_until']}}</td>
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
                </div>
            </div>
            {{--Sidebar za preporuke igraca--}}
            @include('layouts/sidebar')
        </div>
    </div>

@endsection