

{{--<aside class="col-md-3 blog-sidebar">--}}
<div class="container col-md-3">
    {{-- Odeljak za slicne igrace sidebaru --}}
        @if(!empty($recPlayers))
            <div class="row">
                <div class="col-md-12 text-center m-1">
                    <h4 class="font-weight-bold">Recommended</h4>
                    @foreach ($recPlayers as $player)
                        <div class="row">
                            <div class="card mb-4 shadow-sm text-white col-md-8 offset-md-2">
                                <img class="card-img" style="height:7vw;object-fit: fill" src="{{ $player->image }}">
                                <p class="card-text">
                                    <a class="link font-weight-bold" href="/players/{{ $player->id }}">
                                        {{ $player->name }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(!empty($articles))
            {{--Artikli--}}
            <div class="row">
                <div class="col-md-12 text-center m-1">
                    <h4 class="font-weight-bold">Related Articles</h4>
                    @foreach($articles as $article)
                        <div class="row">
                            <div class="card mb-4 shadow-sm text-white">
                                <img class="card-img" style="width:100%;object-fit: cover; height:10vw" src="{{ $article->image }}">
                                <h5 class="bottom-left-img-text">
                                    <a class="link-article" href="/articles/{{ $article->id }}">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    {{--<div class="p-3">--}}
        {{--<h4 class="font-italic">Elsewhere</h4>--}}
        {{--<ol class="list-unstyled">--}}
            {{--<li><a href="#">GitHub</a></li>--}}
            {{--<li><a href="#">Twitter</a></li>--}}
            {{--<li><a href="#">Facebook</a></li>--}}
        {{--</ol>--}}
    {{--</div>--}}

{{--</aside>--}}

</div>
