@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Match</div>

                    <div class="card-body">
                        <form method="POST" action="/matches">
                            @csrf

                            <div class="form-group row">
                                <label for="hometeam" class="col-md-4 col-form-label text-md-right">Home Team</label>

                                <div class="col-md-6">
                                    <select type="select" class="form-control" name="hometeam" required>
                                        @foreach($teams as $team)
                                            <option value="{{$team->id}}">{{$team->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('hometeam'))
                                        <div class="alert-danger">{{ $errors->first('hometeam', 'Home team and guest team must differ') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="guestteam" class="col-md-4 col-form-label text-md-right">Guest Team</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="guestteam" required>
                                        @foreach($teams as $team)
                                            <option value="{{$team->id}}">{{$team->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('guestteam'))
                                        <div class="alert-danger">{{ $errors->first('guestteam', 'Guest team and home team must differ') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label text-md-right">Start Date</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="date" required>
                                    @if ($errors->has('date'))
                                        <div class="alert-danger">{{ $errors->first('date', 'Match can not start before today') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="time" class="col-md-4 col-form-label text-md-right">Start Time</label>
                                <div class="col-md-6">
                                    <input type="time" class="form-control" name="time" required>
                                </div>
                            </div>

                            <div class="form-group row col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection