@extends('layouts.app')

@section('content')
    <div class="container" class="col-xs-1 center-block">
        <div class="row" style="justify-content: center; margin: 50px;">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><h3>Create new article</h3></div>
                    </div>
                    <div class="card-body">
                        <form action="/articles" method="POST">
                            @csrf
                            <button class="btn btn-primary col-md-12 mb-4" type="button" data-toggle="collapse" data-target="#tags" aria-expanded="false" aria-controls="tags">
                                Add Tags
                            </button>
                            <div class="collapse" id="tags">
                                <h4>Tags</h4>
                                <hr>
                                <h5>Players</h5>
                                <div class="row">
                                @foreach ($players as $player)
                                    <div class="col-md-3">
                                        {{$player->name}}<input type="checkbox" class="float-right" name="players[]" value="{{$player->id}}"/>
                                    </div>
                                @endforeach
                                </div>
                                <hr>

                                <h5>Coaches</h5>
                                <div class="row">
                                @foreach ($coaches as $coach)
                                    <div class="col-md-3">
                                        {{$coach->name}}<input type="checkbox" class="float-right" name="coaches[]" value="{{$coach->id}}"/>
                                    </div>
                                @endforeach
                                </div>
                                <hr>

                                <h5>Teams</h5>
                                <div class="row">
                                @foreach ($teams as $team)
                                    <div class="col-md-3">
                                        {{$team->name}}<input type="checkbox" class="float-right" name="teams[]" value="{{$team->id}}"/>
                                    </div>
                                @endforeach
                                </div>
                                <hr>
                            </div>
                            <div class="form-group">
                                <label>Title:</label>
                                <input type="text" class="form-control" name="title"  required>
                            </div>
                            <div class="form-group">
                                <label>Image:</label>
                                <input type="text" class="form-control" placeholder="url" name="image" required>
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
