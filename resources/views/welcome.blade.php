@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3 text-center m-4">
            <h3>Feautured</h3>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Player</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{$player['name']}}</h1>
                    <img style="width:100%;" src="{{$player['image']}}">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>{{$player['city']}}</li>
                    </ul>
                    <a href="/players/{{$player['id']}}" class="btn btn-lg btn-block btn-primary">Show More</a>
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Team</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{$team['name']}}</h1>
                    <img style="width:100%;" src="{{$team['image']}}">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>{{$team['city']}}</li>
                    </ul>
                    <a href="/teams/{{$team['id']}}" class="btn btn-lg btn-block btn-primary">Show More</a>
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Coach</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{$coach['name']}}</h1>
                    <img style="width:100%;" src="{{$coach['image']}}">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>{{$coach['city']}}</li>
                    </ul>
                    <a href="/coaches/{{$coach['id']}}" class="btn btn-lg btn-block btn-primary">Show More</a>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-4">
            <div class="container">
                <h3>Matches</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="jumbotron justify-content-center text-center">
                <h1 class="display-4">Content!</h1>
                <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                <hr class="my-4">
                <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                </p>
            </div>
        </div>
    </div>

    <div class="container">


        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    <img class="mb-2" src="../../assets/brand/bootstrap-solid.svg" alt="" width="24" height="24">
                    <small class="d-block mb-3 text-muted">&copy; 2017-2018</small>
                </div>
                <div class="col-6 col-md">
                    <h5>Features</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Cool stuff</a></li>
                        <li><a class="text-muted" href="#">Random feature</a></li>
                        <li><a class="text-muted" href="#">Team feature</a></li>
                        <li><a class="text-muted" href="#">Stuff for developers</a></li>
                        <li><a class="text-muted" href="#">Another one</a></li>
                        <li><a class="text-muted" href="#">Last time</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Resources</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Resource</a></li>
                        <li><a class="text-muted" href="#">Resource name</a></li>
                        <li><a class="text-muted" href="#">Another resource</a></li>
                        <li><a class="text-muted" href="#">Final resource</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>About</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Team</a></li>
                        <li><a class="text-muted" href="#">Locations</a></li>
                        <li><a class="text-muted" href="#">Privacy</a></li>
                        <li><a class="text-muted" href="#">Terms</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
@endsection