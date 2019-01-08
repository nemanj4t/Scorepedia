@extends('layouts.app')

@section('content')

    @php
        /** @var \App\Player_Team[] $plays_for_teams */
        /** @var \App\Team[] $teams */
    @endphp

    <div class="container" class="col-xs-1 center-block">
        @foreach($plays_for_teams as $plays)
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/players/edit/{{ $player_id }}/plays_for_teams">
                    <input type="hidden" name="_method" id="methodType" value=""/>
                    @csrf
                    {{--<input type="hidden" name="plays_id" id="plays_id" value="{{ $plays['id'] }}"/>--}}
                    {{--Unos liste timova za koje igrac igrac igra ili je igrao--}}
                    <div id="input-container" class="list-group">
                        <div class="list-group-item" id="team">
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="form-control" name="team_id">
                                        <option value="{{ $plays->team->id }}">{{ $plays->team->name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="number" placeholder="Number" value="{{$plays->number}}"/>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="position">
                                        <option value="PG" {{ $plays->position == "PG" ? "selected":"" }}>Point guard</option>
                                        <option value="SG" {{ $plays->position == "SG" ? "selected":"" }}>Shooting guard</option>
                                        <option value="SF" {{ $plays->position == "SF" ? "selected":"" }}>Small forward</option>
                                        <option value="PF" {{ $plays->position == "PF" ? "selected":"" }}>Power forward</option>
                                        <option value="C"  {{ $plays->position == "C" ? "selected":"" }}>Center</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" name="since"
                                        value="{{ \Carbon\Carbon::parse($plays->played_since)->format('Y-m-d')}}"/>
                                </div>

                                @if(isset($plays->played_until))
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" name="until"
                                               value="{{ \Carbon\Carbon::parse($plays->played_until)->format('Y-m-d')}}"/>
                                    </div>
                                @else
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" name="until"/>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Update" onclick="changeAction(this)"/>
                    <input type="submit" class="btn btn-primary" value="Remove" onclick="changeAction(this)"/>
                </form>
            </div>
        </div>
        @endforeach
            {{--Dodavanje nove veze--}}
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/players/edit/{{ $player_id }}/plays_for_teams">
                    @csrf
                    <div id="input-container-new">
                        <label>Add new: </label>
                    </div>
                    <br>
                    <button type="button" onclick="addNewInput()" class="btn btn-outline-secondary">Add previous team +</button>
                    <button type="submit" class="btn btn-primary" value="add">Add</button>
                </form>
            </div>
        </div>
    </div>


    <div style="display: none" id="old-team-template">
        <div class="list-group-item" id="team">
            <div class="row">
                <div class="col-md-2">
                    <button class="button btn-danger" style="display: table; margin: auto;" onclick="deleteInput(this)">X</button>
                </div>
                <div class="col-md-2">
                    <label>Team: </label>
                    <select name="old_team[TEAMID][team_id]" class="form-control" required="required">
                        @foreach($teams as $team)
                            <option value="{{$team->id}}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Number:</label>
                    <input type="text" class="form-control" name="old_team[TEAMID][player_number]" placeholder="Number" required="required"/>
                </div>
                <div class="col-md-2">
                    <label>Position</label>
                    <select name="old_team[TEAMID][player_position]" class="form-control" required="required">
                        <option value="PG">Point guard</option>
                        <option value="SG">Shooting guard</option>
                        <option value="SF">Small forward</option>
                        <option value="PF">Power forward</option>
                        <option value="C">Center</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Played since:</label>
                    <input type="date" name="old_team[TEAMID][player_since]" class="form-control" required="required"/>
                </div>
                <div class="col-md-2">
                    <label>Played until:</label>
                    <input type="date" class="form-control" name="old_team[TEAMID][player_until]"/>
                </div>
            </div>
        </div>
    </div>


@endsection

<script>
    var count = 0;
    function addNewInput() {
        let html = document.getElementById('old-team-template').innerHTML;
        html = html.replace(new RegExp('TEAMID', 'g'), count);
        count++;

        document.getElementById('input-container-new').insertAdjacentHTML('beforeend', html);
    }

    function deleteInput(el) {
        el.parentNode.parentNode.parentNode.parentNode.removeChild(el.parentNode.parentNode.parentNode);
    }

    function changeAction(element) {
        let form = element.parentNode;
        let method = form.children[0];
        console.log(method);
        if(element.value === "Update") {
            method.value = "PUT";
        } else {
            method.value = "DELETE";
        }
    }
</script>

