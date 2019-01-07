@extends('layouts.app')

@section('content')

    @php
        /** @var \App\Team[] $teams */
    @endphp

    <div class="container" class="col-xs-1 center-block">
        <div class="row" style="justify-content: center; margin: 50px;">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-body">
                        <form action="/coaches" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Coach name:</label>
                                <input type="text" class="form-control" name="name"  placeholder="Enter name" required="required">
                            </div>
                            <div class="form-group">
                                <label>Team:</label>
                                <select class="form-control" name="team" >
                                    <option value="" selected>No current team</option>
                                    @foreach ($teams as $team)
                                        @if ($team->current_coach == '')
                                            <option value="{{$team->id}}">{{$team->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <label>Coached since:</label>
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="" name="coached_since">
                                        @if ($errors->has('coached_since'))
                                            <div class="alert-danger">{{ $errors->first('coached_since') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label>Coached until: </label>
                                        <input class="form-control" type="date" value="" name="coached_until">
                                        @if ($errors->has('coached_until'))
                                            <div class="alert-danger">{{ $errors->first('coached_until') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Bio:</label>
                                <input type="textarea" class="form-control" name="bio" placeholder="Biography" required="required">
                            </div>
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" class="form-control" name="city" placeholder="City" required="required">
                            </div>
                            <div class="form-group">
                                <label>Image url:</label>
                                <input type="textarea" class="form-control" name="image" placeholder="url" required="required">
                            </div>
                            <div id="input-container" class="list-group">

                            </div>
                            <button type="button" onclick="addNewInput()" class="btn btn-outline-secondary">Add previous team +</button>
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none" id="old-team-template">
        <div class="list-group-item">
            <label>Team:</label>
            <select name="old_team[TEAMID][team_id]" class="form-control" placeholder="Team">
                @foreach($teams as $team)
                    <option value="{{$team->id}}">{{ $team->name }}</option>
                @endforeach
            </select>
            <label> Coached since:</label>
            <input type="date" name="old_team[TEAMID][coached_since]" class="form-control"/>
            <label>Coached until:</label>
            <input type="date" name="old_team[TEAMID][coached_until]" class="form-control"/>
        </div>
    </div>

@endsection


<script>
    var count = 0;
    function addNewInput() {
        let html = document.getElementById('old-team-template').innerHTML;
        html = html.replace(new RegExp('TEAMID', 'g'), count);
        count++;

        document.getElementById('input-container').insertAdjacentHTML('beforeend', html);
    }
</script>