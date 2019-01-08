@extends('layouts.app')

@section('content')

    @php
        /** @var \App\Team_Coach[] $team_coach */
        /** @var \App\Team[] $teams */
    @endphp

    <div class="container" class="col-xs-1 center-block">
        @foreach($team_coach as $rel)
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/coaches/edit/{{ $coach_id }}/team_coach">
                        <input type="hidden" name="_method" id="methodType" value=""/>
                        @csrf
                        {{--<input type="hidden" name="plays_id" id="plays_id" value="{{ $plays['id'] }}"/>--}}
                        {{--Unos liste timova za koje igrac igrac igra ili je igrao--}}
                        <div id="input-container" class="list-group">
                            <div class="list-group-item" id="team">
                                <input type="hidden" name="team_id" value="{{$rel->team_id}}"/>
                                <input type="text" class="form-control" name="prev_team" value="{{$rel->team->name}}"/>
                                <input type="date" class="form-control" name="coached_since"
                                       value="{{$rel->coached_since}}"/>

                                <input type="date" class="form-control" name="coached_until"
                                       value="{{$rel->coached_until}}"/>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update" onclick="changeAction(this)"/>
                        <input type="submit" class="btn btn-primary" value="Remove" onclick="changeAction(this)"/>
                    </form>
                </div>
            </div>
        @endforeach
        {{--Dodavanje nove veze--}}
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/coaches/edit/{{ $coach_id }}/team_coach">
                    @csrf
                    <div id="input-container-new" class="list-group">
                        <label>Add previous teams:</label>

                    </div>

                    <button type="button" onclick="addNewInput()" class="btn btn-outline-secondary">Add previous team +</button>
                    <button type="submit" class="btn btn-primary" value="add">Add</button>
                </form>
            </div>
        </div>
    </div>

    <div style="display: none" id="old-team-template">
        <div class="list-group-item">
            <button class="button btn-danger" onclick="deleteInput(this)">X</button>
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

        document.getElementById('input-container-new').insertAdjacentHTML('beforeend', html);
    }
    function deleteInput(el) {
        el.parentNode.parentNode.removeChild(el.parentNode);
    }

    function changeAction(element) {
        let form = element.parentNode;
        let method = form.children[0]; // prvi je hidden input za metodu
        console.log(method);
        if(element.value === "Update") {
            method.value = "PUT";
        } else {
            method.value = "DELETE";
        }
    }
</script>
