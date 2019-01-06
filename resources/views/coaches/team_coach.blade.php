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
                                <input type="text" name="prev_team" value="{{$rel->team->name}}"/>
                                <input type="date" name="since"
                                       value="{{$rel->coached_since}}"/>

                                <input type="date" name="until"
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
                    <div class="list-group-item" id="team">
                        <select name="team_name" required="required">
                            @foreach($teams as $team)
                                <option value="{{$team->id }}">{{ $team->name }}</option>
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
