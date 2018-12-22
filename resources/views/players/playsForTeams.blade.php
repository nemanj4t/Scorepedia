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
                                    <select name="team_id" onkeyup="addNewInput(this)">
                                        <option value="{{ $plays['team']['id'] }}">{{ $plays['team']['name'] }}</option>
                                    </select>
                                    <input type="text" name="number" onkeyup="addNewInput(this)" placeholder="Number" value="{{$plays['plays_for']['number']}}"/>
                                    <select name="position" onselect="addNewInput(this)">
                                        <option value="PG" {{ $plays['plays_for']['position'] == "PG" ? "selected":"" }}>Point guard</option>
                                        <option value="SG" {{ $plays['plays_for']['position'] == "SG" ? "selected":"" }}>Shooting guard</option>
                                        <option value="SF" {{ $plays['plays_for']['position'] == "SF" ? "selected":"" }}>Small forward</option>
                                        <option value="PF" {{ $plays['plays_for']['position'] == "PF" ? "selected":"" }}>Power forward</option>
                                        <option value="C"  {{ $plays['plays_for']['position'] == "C" ? "selected":"" }}>Center</option>
                                    </select>
                                    <input type="date" name="since" onkeyup="addNewInput(this)"
                                           value="{{ \Carbon\Carbon::createFromFormat('Ymd', $plays['plays_for']['since'])->format('Y-m-d')}}"/>

                                    @if(isset($plays['plays_for']['until']))
                                        <input type="date" name="until" onkeyup="addNewInput(this)"
                                               value="{{ \Carbon\Carbon::createFromFormat('Ymd', $plays['plays_for']['until'])->format('Y-m-d')}}"/>
                                    @else
                                        <input type="date" name="until" onkeyup="addNewInput(this)"/>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" value="update" onclick="changeAction()">Update</button>
                            <button type="submit" class="btn btn-primary" value="remove" onclick="changeAction()">Remove</button>
                            </form>
                        </div>
                    </div>
    </div>
    @endforeach
@endsection

@section('scripts')
    <script>

        // Promena rute u zavisnosti od buttona
        function changeAction(button) {
            let form = button.getParentNode();
            let method = form.getElementById('methodType');
            if(button.value === "update") {
                //form.action = "/players/plays_for_teams/edit/".concat(form.action);
                method.value = "PUT";
            } else {
                //form.action = "/players/plays_for_teams/delete/".concat(form.action);
                method.value = "DELETE";
            }
        }

        // Multiple inputs
        function addNewInput(element) {
            let parent = element.parentNode;    // div u okviru koga se nalazi
            let hasValue = false;
            for(let i = 0; i < parent.children.length; i++) {
                if(parent.children[i].value) {
                    hasValue = true;
                    break;
                }
            }
            if (!hasValue) {
                if(parent.parentNode.children.length === 1) {
                    return;
                } else {
                    parent.parentNode.removeChild(parent);
                    return;
                }
            } else if (parent.nextElementSibling)
                return;

            let newInput = parent.cloneNode(); // novi div
            let nameParts = newInput.id.split('_');
            newInput.id = nameParts[0] + '_' + (parseInt(nameParts[1]) + 1);
            for(let i = 0; i < parent.children.length; i++) {
                let newChild;
                if(parent.children[i].type === "select-one") {
                    newChild = parent.children[i].cloneNode(true);  // cloneNode([deep])

                } else {
                    newChild = parent.children[i].cloneNode();
                }
                let nameParts = newChild.name.split('_');
                let name = nameParts[0] + '_' + nameParts[1] + '_' + (parseInt(nameParts[2]) + 1);
                newChild.name = name;
                newChild.value = "";
                newInput.appendChild(newChild);
            }
            parent.parentNode.appendChild(newInput);
        }
    </script>
@endsection