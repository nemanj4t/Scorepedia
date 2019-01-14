
@if(!empty($articles))
    {{--Artikli--}}
    <div class="row m-4">
        <div class="col-md-12 text-center">
            <h4 class="font-weight-bold">Related Articles</h4>
            @foreach($articles as $article)
                <div class="row">
                    <div class="card mb-4 shadow-sm text-white flex-fill">
                        <img class="card-img" style="width:100%;object-fit: cover; height:12vw" src="{{ $article->image }}">
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
