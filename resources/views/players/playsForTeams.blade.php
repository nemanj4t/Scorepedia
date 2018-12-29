@extends('layouts.app')

@section('content')


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
                                    <select name="team_id">
                                        <option value="{{ $plays['team']['id'] }}">{{ $plays['team']['name'] }}</option>
                                    </select>
                                    <input type="text" name="number" placeholder="Number" value="{{$plays['plays_for']['number']}}"/>
                                    <select name="position">
                                        <option value="PG" {{ $plays['plays_for']['position'] == "PG" ? "selected":"" }}>Point guard</option>
                                        <option value="SG" {{ $plays['plays_for']['position'] == "SG" ? "selected":"" }}>Shooting guard</option>
                                        <option value="SF" {{ $plays['plays_for']['position'] == "SF" ? "selected":"" }}>Small forward</option>
                                        <option value="PF" {{ $plays['plays_for']['position'] == "PF" ? "selected":"" }}>Power forward</option>
                                        <option value="C"  {{ $plays['plays_for']['position'] == "C" ? "selected":"" }}>Center</option>
                                    </select>
                                    <input type="date" name="since"
                                           value="{{ \Carbon\Carbon::createFromFormat('Ymd', $plays['plays_for']['since'])->format('Y-m-d')}}"/>

                                    @if(isset($plays['plays_for']['until']))
                                        <input type="date" name="until"
                                               value="{{ \Carbon\Carbon::createFromFormat('Ymd', $plays['plays_for']['until'])->format('Y-m-d')}}"/>
                                    @else
                                        <input type="date" name="until"/>
                                    @endif
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
                                <form method="POST" action="/players/edit/{{ $player_id }}/plays_for_teams">
                                    @csrf
                                    <div class="list-group-item" id="team">
                                        <select name="team_name" required="required">
                                            @foreach($teams as $team)
                                                <option value="{{$team['id'] }}">{{ $team['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="player_number" placeholder="Number" required="required"/>
                                        <select name="player_position" required="required">
                                            <option value="PG">Point guard</option>
                                            <option value="SG">Shooting guard</option>
                                            <option value="SF">Small forward</option>
                                            <option value="PF">Power forward</option>
                                            <option value="C">Center</option>
                                        </select>
                                        <input type="date" name="player_since" required="required"/>
                                        <input type="date" name="player_until"/>
                                    </div>
                                    <button type="submit" class="btn btn-primary" value="add">Add</button>
                                </form>
                            </div>
                        </div>
    </div>

@endsection

@section('scripts')
    <script>

        // Promena rute u zavisnosti od buttona
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
@endsection
