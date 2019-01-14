@extends('layouts.app')

@section('content')
    @php
        /** @var App\Player $player */
    @endphp
    <div class="container mt-4 mb-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="/players/{{ $player->id }}" method="post">
                    {{ method_field('PUT') }}
                    @csrf
                    <input type="hidden" name="id" value="{{ $player->id }}">
                    <div class="form-group">
                        <label>Player name:</label>
                        <input type="text" class="form-control" name="name"  placeholder="Enter name" required="required" value="{{ $player->name }}">
                        @if ($errors->has('name'))
                            <div class="alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Bio:</label>
                        <input type="textarea" class="form-control" name="bio" placeholder="Biography" required="required" value="{{ $player->bio }}">
                        @if ($errors->has('bio'))
                            <div class="alert-danger">{{ $errors->first('bio') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Height(cm):</label>
                        <input type="text" class="form-control" name="height" placeholder="Height" required="required" value="{{ $player->height }}">
                        @if ($errors->has('height'))
                            <div class="alert-danger">{{ $errors->first('height') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Weight(kg):</label>
                        <input type="text" class="form-control" name="weight" placeholder="Weight" required="required" value="{{ $player->weight }}">
                        @if ($errors->has('weight'))
                            <div class="alert-danger">{{ $errors->first('weight') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>City:</label>
                        <input type="text" class="form-control" name="city" placeholder="City" required="required" value="{{ $player->city }}">
                        @if ($errors->has('city'))
                            <div class="alert-danger">{{ $errors->first('city') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Image url:</label>
                        <input type="textarea" class="form-control" name="image" placeholder="url" required="required" value="{{ $player->image }}">
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