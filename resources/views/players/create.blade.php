@extends('layouts.app')

@section('content')

    {{--Unos liste timova za koje igrac igrac igra ili je igrao--}}
    <div id="input-container" class="list-group">
        <div class="list-group-item" id="player_0">
            <input type="text" name="player_name_0" onkeyup="addNewInput(this)"/>
            <input type="text" name="player_number_0" onkeyup="addNewInput(this)"/>
            <select name="player_position_0" onselect="addNewInput(this)">
                <option value=""></option>
                <option value="PG">Point guard</option>
                <option value="SG">Shooting guard</option>
                <option value="SF">Small forward</option>
                <option value="PF">Power forward</option>
                <option value="C">Center</option>
            </select>
            <input type="select" name="player_position_0" onkeyup="addNewInput(this)"/>
            <input type="date" name="player_since_0" onkeyup="addNewInput(this)"/>
            <input type="date" name="player_until_0" onkeyup="addNewInput(this)"/>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
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
                parent.parentNode.removeChild(parent);
                return;
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