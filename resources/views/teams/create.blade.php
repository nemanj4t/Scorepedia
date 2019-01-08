@extends('layouts.app')

@section('content')
    <div class="container" class="col-xs-1 center-block">
        <div class="row" style="justify-content: center; margin: 50px;">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-body">
                        <form action="/teams" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Team name</label>
                                <input type="text" class="form-control" name="name"  placeholder="Enter name">
                                @if ($errors->has('name'))
                                    <div class="alert-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" name="short_name" placeholder="Abbreviation">
                                @if ($errors->has('short_name'))
                                    <div class="alert-danger">{{ $errors->first('short_name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Coach</label>
                                <select class="form-control" name="coach">
                                    @foreach($coaches as $coach)
                                        <option value={{$coach->id}}>{{$coach->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <label>Coached since:</label>
                                        <input class="form-control" style="margin-right: 20px; float: left;" type="date" value="" name="coached_since">
                                        @if ($errors->has('coached_since'))
                                            <div class="alert-danger">{{ $errors->first('coached_since') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label>Coached until: </label>
                                        <input class="form-control" type="date" value="" name="coached_until">
                                        @if ($errors->has('coached_until'))
                                            <div class="alert-danger">{{ $errors->first('coached_until') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" placeholder="City">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="description" placeholder="Description">
                            </div>
                            <div class="form-group">
                                <label>Image url</label>
                                <input type="text" class="form-control" name="image" placeholder="url">
                            </div>
                            <div class="form-group">
                                <label>Background image url</label>
                                <input type="text" class="form-control" name="background_image" placeholder="url">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection