@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-body">
                    <form action="/teams/{{$team["id"]}}" method="POST">
                        <input type="hidden" name="_method" value="put" />
                        @csrf
                        <div class="form-group">
                            <label>Team name</label>
                            <input type="text" class="form-control" name="name" value="{{$team["name"]}}" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label>Abbreviation</label>
                            <input type="text" class="form-control" name="short_name" value="{{$team["short_name"]}}" placeholder="Abbreviation">
                        </div>
                        <div class="form-group">
                            <label>Coach</label>
                            <select class="form-control" name="coach">
                                @if ($team["current_coach"] != '')
                                    <option value="">No current coach</option>
                                    <option value="{{$team["current_coach"]["id"]}}" selected>{{$team["current_coach"]["name"]}}</option>
                                @else
                                    <option value="" selected>No current coach</option>
                                @endif
                                @foreach($coaches as $coach)
                                    <option value={{$coach["id"]}}>{{$coach["name"]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <label>Coached since:</label>
                                    @if ($team["current_coach"] != "")
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="{{$team["current_coach"]["coached_since"]}}" name="coached_since">
                                        @else
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="" name="coached_since">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label>Coached until: </label>
                                    @if ($team["current_coach"] != "")
                                        <input class="form-control" type="date" value="{{$team["current_coach"]["coached_until"]}}" name="coached_until">
                                        @else
                                            <input class="form-control" type="date" value="" name="coached_until">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="city" value="{{$team["city"]}}" placeholder="City">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" value="{{$team["description"]}}" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <label>Image url</label>
                            <input type="text" class="form-control" name="image" value="{{$team["image"]}}" placeholder="url">
                        </div>
                        <div class="form-group">
                            <label>Background image url</label>
                            <input type="text" class="form-control" name="background_image" value="{{$team["background_image"]}}" placeholder="url">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection