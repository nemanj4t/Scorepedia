@extends('layouts.app')

@section('content')

    @php
        /** @var \App\Coach $coach */
        /** @var \App\Team[] $teams */
    @endphp

    <div class="container col-md-6 mt-4 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="/coaches/{{$coach->id}}" method="POST">
                    <input type="hidden" name="_method" value="put" />
                    @csrf
                    <div class="form-group">
                        <label>Coach name:</label>
                        <input type="text" class="form-control" value="{{$coach->name}}" name="name"  placeholder="Enter name" required>
                        @if ($errors->has('name'))
                            <div class="alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Team:</label>
                        <select class="form-control" name="team" >
                            @if ($coach->current_team == null)
                                <option value="" selected>No current team</option>
                            @else
                                <option value="" >No current team</option>
                                <option value="{{$coach->current_team->team->id}}" selected>{{$coach->current_team->team->name}}</option>
                                @php
                                    $key = array_search($coach->current_team->team->id, $teams);
                                    unset($teams[$key]);
                                @endphp
                            @endif
                            @foreach ($teams as $team)
                                @if ($team->current_coach == null)
                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('team'))
                            <div class="alert-danger">{{ $errors->first('team') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <label>Coached since:</label>
                                @if ($coach->current_team == null)
                                    <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="" name="coached_since">
                                @else
                                    <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="{{$coach->current_team->coached_since}}" name="coached_since">
                                @endif
                                @if ($errors->has('coached_since'))
                                    <div class="alert-danger">{{ $errors->first('coached_since') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label>Coached until: </label>
                                @if ($coach->current_team == null)
                                    <input class="form-control" type="date" value="" name="coached_until">
                                @else
                                    <input class="form-control" type="date" value="{{$coach->current_team->coached_until}}" name="coached_until">
                                @endif
                                @if ($errors->has('coached_until'))
                                    <div class="alert-danger">{{ $errors->first('coached_until') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bio:</label>
                        <input type="textarea" value="{{$coach->bio}}" class="form-control" name="bio" placeholder="Biography" required="required">
                        @if ($errors->has('bio'))
                            <div class="alert-danger">{{ $errors->first('bio') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>City:</label>
                        <input type="text" value="{{$coach->city}}" class="form-control" name="city" placeholder="City" required="required">
                        @if ($errors->has('city'))
                            <div class="alert-danger">{{ $errors->first('city') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Image url:</label>
                        <input type="textarea" value="{{$coach->image}}" class="form-control" name="image" placeholder="url" required="required">
                        @if ($errors->has('image'))
                            <div class="alert-danger">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>


@endsection