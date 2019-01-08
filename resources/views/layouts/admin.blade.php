@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="container">
        <div class="row">
            <nav class="col-sm-3 col-md-2 hidden-xs-down bg-dark sidebar">
                <ul class="nav nav-pills flex-column mt-4" id="sidenav">
                    @yield('nav-items')
                </ul>
            </nav>

            <main class="col-sm-8 offset-sm-3 col-md-8 offset-md-1 pt-3 mt-4">
                <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
                <div class="container">
                    @yield('main')
                </div>

            </main>
        </div>
    </div>
@endsection