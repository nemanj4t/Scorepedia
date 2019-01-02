@extends('layouts.app')

@section('content')

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
                                <input type="hidden" name="team_id" value="{{$rel['team']['id']}}"/>
                                <input type="text" name="prev_team" value="{{$rel['team']['name']}}"/>
                                <input type="date" name="since"
                                       value="{{$rel['coached']['coached_since']}}"/>

                                <input type="date" name="until"
                                       value="{{$rel['coached']['coached_until']}}"/>
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
                    <div class="list-group-item" id="team">
                        <select name="team_name" required="required">
                            @foreach($teams as $team)
                                <option value="{{$team['id'] }}">{{ $team['name'] }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="coached_since" required="required"/>
                        <input type="date" name="coached_until" required="required"/>
                    </div>
                    <button type="submit" class="btn btn-primary" value="add">Add</button>
                </form>
            </div>
        </div>
    </div>

@endsection
