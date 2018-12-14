@extends('layouts.app')

@section('content')

    {{--Unos liste timova za koje igrac igrac igra ili je igrao--}}
    <div id="input-container" style="display:block">
        <input type="text" name="team" id="team_0" onkeyup="addNewInput(this)" />
    </div>

@endsection