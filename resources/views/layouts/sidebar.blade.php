<aside class="col-md-3 blog-sidebar">

    {{-- Odeljak za slicne igrace sidebaru --}}
    <div>
        <div class="container" style="margin-top:20px;">
            <h4 class="font-italic">Recommended</h4>
            <div class="row">
                <div id="user" class="col-md-12" >
                    <div class="panel panel-primary panel-table animated slideInDown">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="list">
                                    <table class="table table-striped table-bordered table-list">
                                        <tbody>
                                        @foreach ($recPlayers as $player)
                                            <tr class="ok" class="col-md-12">
                                                <td class="avatar"><img id="img" class="avatar" src={{$player->image}}></td>
                                                <td><a href="/players/{{$player->id}}">{{$player->name}}</a></td>
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
    </div>


    {{--<div class="p-3">--}}
        {{--<h4 class="font-italic">Elsewhere</h4>--}}
        {{--<ol class="list-unstyled">--}}
            {{--<li><a href="#">GitHub</a></li>--}}
            {{--<li><a href="#">Twitter</a></li>--}}
            {{--<li><a href="#">Facebook</a></li>--}}
        {{--</ol>--}}
    {{--</div>--}}

</aside>