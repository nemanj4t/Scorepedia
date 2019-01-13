
@if(!empty($recPlayers))
{{--<aside class="col-md-3 blog-sidebar">--}}
<div class="container col-md-3">
    {{-- Odeljak za slicne igrace sidebaru --}}
        <div class="container mt-20">
            <div class="row">
                <h4 class="font-italic text-center">Recommended</h4>
            </div>
            <div class="row">
                <div id="user" class="col-md-12">
                    <div class="panel panel-primary panel-table animated slideInDown">
                        <div class="panel-body">
                            <div class="tab-content">
                                    <table class="table table-striped table-bordered table-list">
                                        <tbody>
                                        @foreach ($recPlayers as $player)
                                            <tr class="ok">
                                                <td class="col-2"><img style="width:100%" src={{$player->image}}></td>
                                                <td class="col-10"><a href="/players/{{$player->id}}">{{$player->name}}</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- END id="list" -->
                            </div><!-- END tab-content -->
                        </div>
                    </div><!--END panel-table-->
                </div>
            </div>
        </div>


            {{--<div class="row col-12 text-center-1">--}}
                {{--<h3>Recommended</h3>--}}
            {{--</div>--}}
            {{--@foreach ($recPlayers as $player)--}}
                {{--<div class="row col-12 text-center-1">--}}
                    {{--<div class="card mb-4 shadow-sm">--}}
                        {{--<div class="card-header">--}}
                            {{--<h4 class="my-0 font-weight-normal">Player</h4>--}}
                        {{--</div>--}}
                        {{--<div class="card-body">--}}
                            {{--<h1 class="card-title pricing-card-title">{{$player->name}}</h1>--}}
                            {{--<img style="width:100%;" src="{{$player->image}}">--}}
                            {{--<a href="/players/{{$player->id}}" class="btn btn-lg btn-block btn-primary">Show More</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endforeach--}}

    {{--<div class="p-3">--}}
        {{--<h4 class="font-italic">Elsewhere</h4>--}}
        {{--<ol class="list-unstyled">--}}
            {{--<li><a href="#">GitHub</a></li>--}}
            {{--<li><a href="#">Twitter</a></li>--}}
            {{--<li><a href="#">Facebook</a></li>--}}
        {{--</ol>--}}
    {{--</div>--}}

{{--</aside>--}}
@endif

