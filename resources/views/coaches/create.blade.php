@extends('layouts.app')

@section('content')
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
                                        @if ($team['current_coach'] == '')
                                            <option value="{{$team['id']}}">{{$team['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <label>Coached since:</label>
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="" name="coached_since">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Coached until: </label>
                                        <input class="form-control" type="date" value="" name="coached_until">
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
                                <div class="list-group-item" id="team_0">
                                    <select name="team_name_0" class="form-control" onkeyup="addNewInput(this)" placeholder="Team">
                                        <option value=""></option>
                                        @foreach($teams as $team)
                                            <option value="{{$team['id'] }}">{{ $team['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <input type="date" name="coached_since_0" class="form-control" onkeyup="addNewInput(this)"/>
                                    <input type="date" name="coached_until_0" class="form-control" onkeyup="addNewInput(this)"/>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


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