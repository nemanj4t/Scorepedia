@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Team $team */
    @endphp
    <div class="container mt-4 mb-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="/teams/{{$team->id}}" method="POST">
                        <input type="hidden" name="_method" value="put" />
                        @csrf
                        <div class="form-group">
                            <label>Team name</label>
                            <input type="text" class="form-control" name="name" value="{{$team->name}}" placeholder="Enter name">
                            @if ($errors->has('name'))
                                <div class="alert-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Abbreviation</label>
                            <input type="text" class="form-control" name="short_name" value="{{$team->short_name}}" placeholder="Abbreviation">
                            @if ($errors->has('short_name'))
                                <div class="alert-danger">{{ $errors->first('short_name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Coach</label>
                            <select class="form-control" name="coach">
                                @if ($team->current_coach != null)
                                    <option value="{{$team->current_coach->id}}" selected>{{$team->current_coach->name}}</option>
                                @endif
                                @foreach($coaches as $coach)
                                    <option value={{$coach->id}}>{{$coach->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <label>Coached since:</label>
                                    @if ($team->current_coach != null)
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="{{$team->all_coaches[0]->coached_since}}" name="coached_since">
                                        @if ($errors->has('coached_since'))
                                            <div class="alert-danger">{{ $errors->first('coached_since') }}</div>
                                        @endif
                                    @else
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="" name="coached_since">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label>Coached until: </label>
                                    @if ($team->current_coach != null)
                                        <input class="form-control" type="date" value="{{$team->all_coaches[0]->coached_until}}" name="coached_until">
                                        @if ($errors->has('coached_until'))
                                            <div class="alert-danger">{{ $errors->first('coached_until') }}</div>
                                        @endif
                                    @else
                                        <input class="form-control" type="date" value="" name="coached_until">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="city" value="{{$team->city}}" placeholder="City">
                            @if ($errors->has('city'))
                                <div class="alert-danger">{{ $errors->first('city') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" value="{{$team->description}}" placeholder="Description">
                            @if ($errors->has('description'))
                                <div class="alert-danger">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Image url</label>
                            <input type="text" class="form-control" name="image" value="{{$team->image}}" placeholder="url">
                            @if ($errors->has('image'))
                                <div class="alert-danger">{{ $errors->first('image') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Background image url</label>
                            <input type="text" class="form-control" name="background_image" value="{{$team->background_image}}" placeholder="url">
                            @if ($errors->has('background_image'))
                                <div class="alert-danger">{{ $errors->first('background_image') }}</div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
    </div>

@endsection