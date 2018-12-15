@extends('layouts.app')

@section('content')
    <div class="container" class="col-xs-1 center-block">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-body">
                    <form action="/players/{{ $player['id'] }}" method="post">
                        {{ method_field('PUT') }}
                        @csrf
                        <input type="hidden" name="id" value="{{ $player['id'] }}">
                        <div class="form-group">
                            <label>Player name:</label>
                            <input type="text" class="form-control" name="name"  placeholder="Enter name" required="required" value="{{ $player['name'] }}">
                        </div>
                        <div class="form-group">
                            <label>Bio:</label>
                            <input type="textarea" class="form-control" name="bio" placeholder="Biography" required="required" value="{{ $player['bio'] }}">
                        </div>
                        <div class="form-group">
                            <label>Height(cm):</label>
                            <input type="text" class="form-control" name="height" placeholder="Height" required="required" value="{{ $player['height'] }}">
                        </div>
                        <div class="form-group">
                            <label>Weight(kg):</label>
                            <input type="text" class="form-control" name="weight" placeholder="Weight" required="required" value="{{ $player['weight'] }}">
                        </div>
                        <div class="form-group">
                            <label>City:</label>
                            <input type="text" class="form-control" name="city" placeholder="City" required="required" value="{{ $player['city'] }}">
                        </div>
                        <div class="form-group">
                            <label>Image url:</label>
                            <input type="textarea" class="form-control" name="image" placeholder="url" required="required" value="{{ $player['image'] }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection