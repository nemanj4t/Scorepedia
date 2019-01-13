@extends('layouts.admin')

@section('nav-items')
    <li class="nav-item">
        <a class="nav-link" href="/apanel">Overview </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/apanel/teams">Teams </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/apanel/players">Players </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/apanel/coaches">Coaches </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/apanel/matches">Matches </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/apanel/articles">Articles </a>
    </li>
@endsection

@section('main')
    <br>
    <div class="table-responsive">
        <table class="table table-striped mb-5">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>City</th>
                <th>Image</th>
                <th><a href="/players/create" class="btn btn-primary float-right">Add</a></th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $single_data)
                <tr>
                    <td>{{$single_data->id}}</td>
                    <td><a href="/players/{{$single_data->id}}">{{$single_data->name}}</a></td>
                    <td>{{$single_data->city}}</td>
                    <td><img id="img" src="{{$single_data->image}}"></td>
                    <td>
                        <form action="/players/{{$single_data->id}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="delete" />
                            <button class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                        </form>
                        <a href="/players/edit/{{$single_data->id}}" class="btn btn-sm btn-primary float-right">Edit</a>
                        <a href="/players/edit/{{$single_data->id}}/plays_for_teams" class="btn btn-sm btn-primary mr-2 float-right">Edit Career</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection