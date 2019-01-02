@extends('layouts.app')

@section('content')
    <div class="container" class="col-xs-1 center-block">
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
                            <div class="list-group-item" id="team_0">
                                <select name="team_name_0" onchange="addNewInput(this)">
                                    <option value=""></option>
                                    @foreach($teams as $team)
                                        <option value="{{$team['id'] }}">{{ $team['name'] }}</option>
                                    @endforeach
                                </select>
                                <input type="number" min="0" name="player_number_0" placeholder="Number" onchange="addNewInput(this)"/>
                                <select name="player_position_0" onchange="addNewInput(this)">
                                    <option value=""></option>
                                    <option value="PG">Point guard</option>
                                    <option value="SG">Shooting guard</option>
                                    <option value="SF">Small forward</option>
                                    <option value="PF">Power forward</option>
                                    <option value="C">Center</option>
                                </select>
                                <input type="date" name="player_since_0" onchange="addNewInput(this)"/>
                                <input type="date" name="player_until_0" onchange="addNewInput(this)"/>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>

    </script>
@endsection
