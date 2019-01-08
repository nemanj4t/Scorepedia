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
                        <form action="/players" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Player name:</label>
                                <input type="text" class="form-control" name="name"  placeholder="Enter name" required="required">
                            </div>
                            <div class="form-group">
                                <label>Bio:</label>
                                <input type="textarea" class="form-control" name="bio" placeholder="Biography" required="required">
                            </div>
                            <div class="form-group">
                                <label>Height(cm):</label>
                                <input type="text" class="form-control" name="height" placeholder="Height" required="required">
                            </div>
                            <div class="form-group">
                                <label>Weight(kg):</label>
                                <input type="text" class="form-control" name="weight" placeholder="Weight" required="required">
                            </div>
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" class="form-control" name="city" placeholder="City" required="required">
                            </div>
                            <div class="form-group">
                                <label>Image url:</label>
                                <input type="textarea" class="form-control" name="image" placeholder="url" required="required">
                            </div>
                            {{--Unos liste timova za koje igrac igrac igra ili je igrao--}}
                            <div id="input-container" class="list-group">


                            </div>
                            <br>
                            <button type="button" onclick="addNewInput()" class="btn btn-outline-secondary">Add previous team +</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none" id="all-team-template">
        <div class="list-group-item">
            <button class="button btn-danger" onclick="deleteInput(this)">X</button>
            <label>Team:</label>
            <select name="all_team[TEAMID][team_name]" class="form-control">
                <option value=""></option>
                @foreach($teams as $team)
                    <option value="{{$team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
            <label>Number:</label>
            <input type="number" min="0" name="all_team[TEAMID][player_number]" class="form-control" placeholder="Number"/>
            <label>Position:</label>
            <select name="all_team[TEAMID][player_position]" class="form-control">
                <option value=""></option>
                <option value="PG">Point guard</option>
                <option value="SG">Shooting guard</option>
                <option value="SF">Small forward</option>
                <option value="PF">Power forward</option>
                <option value="C">Center</option>
            </select>
            <label>Played since:</label>
            <input type="date" name="all_team[TEAMID][player_since]" class="form-control"/>
            <label>Played until:</label>
            <input type="date" name="all_team[TEAMID][player_until]" class="form-control"/>
        </div>
    </div>


@endsection

<script>
    var count = 0;
    function addNewInput() {
        let html = document.getElementById('all-team-template').innerHTML;
        html = html.replace(new RegExp('TEAMID', 'g'), count);
        count++;

        document.getElementById('input-container').insertAdjacentHTML('beforeend', html);
    }
    function deleteInput(el) {
        el.parentNode.parentNode.removeChild(el.parentNode);
    }
</script>

