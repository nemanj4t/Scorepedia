@extends('layouts.app')

@section('content')
    <div class="container" class="col-xs-1 center-block">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-body">
                    <form action="/coaches/{{$coach['id']}}" method="POST">
                        <input type="hidden" name="_method" value="put" />
                        @csrf
                        <div class="form-group">
                            <label>Coach name:</label>
                            <input type="text" class="form-control" value="{{$coach['name']}}" name="name"  placeholder="Enter name" required="required">
                        </div>
                        <div class="form-group">
                            <label>Team:</label>
                            <select class="form-control" name="team" >
                                @if ($coach['current_team'] == '')
                                    <option value="" selected>No current team</option>
                                @else
                                    <option value="" >No current team</option>
                                    <option value="{{$coach['current_team']['team']['id']}}" selected>{{$coach['current_team']['team']['name']}}</option>
                                    @php
                                        $key = array_search($coach['current_team']['team']['id'], $teams);
                                        unset($teams[$key]);
                                    @endphp
                                @endif
                                @foreach ($teams as $team)
                                    @if ($team['current_coach'] == '')
                                        <option value="{{$team['id']}}">{{$team['name']}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <label>Coached since:</label>
                                    @if ($coach['current_team'] == '')
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="" name="coached_since">
                                    @else
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="{{$coach['current_team']['coached']['coached_since']}}" name="coached_since">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label>Coached until: </label>
                                    @if ($coach['current_team'] == '')
                                        <input class="form-control" type="date" value="" name="coached_until">
                                    @else
                                        <input class="form-control" type="date" value="{{$coach['current_team']['coached']['coached_until']}}" name="coached_until">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bio:</label>
                            <input type="textarea" value="{{$coach['bio']}}" class="form-control" name="bio" placeholder="Biography" required="required">
                        </div>
                        <div class="form-group">
                            <label>City:</label>
                            <input type="text" value="{{$coach['city']}}" class="form-control" name="city" placeholder="City" required="required">
                        </div>
                        <div class="form-group">
                            <label>Image url:</label>
                            <input type="textarea" value="{{$coach['image']}}" class="form-control" name="image" placeholder="url" required="required">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection