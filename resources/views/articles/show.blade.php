<x-layout>
    <div class="container-fluid p-5 bg-secondary-subtle text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="display-1">{{ $article->title }}</h1>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 d-flex flex-column">
                <img src="{{ Storage::url($article->image) }}" class="img-fluid" 
                    alt="Immagine dell'articolo: {{ $article->title }}">
                <div class="text-center">
                    <h2>{{ $article->subtitle }}</h2>
                    @if ($article->category)
                        <p class="fs-5">Category:
                            <a href="{{route('articles.byCategory', $article->category)}}" class="text-capitalize fw-bold text-muted">{{ $article->category->name }}</a>
                        </p>
                    @else
                        <p class="fs-5">No category</p>
                    @endif
                    <div class="text-muted my-3">
                        <p>Created at {{$article->created_at->format('d/m/Y')}} by <a class="text-muted" href="{{ route('articles.byUser', $article->user) }}">{{$article->user->name}}</a></p>
                    </div>
                </div>
                <hr>
                <div>{!! $sanitizedBody !!}</div>
                @if (Auth::user() && Auth::user()->is_revisor && !$article->is_accepted)
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-evenly">
                                <form action="{{route('revisor.acceptArticle', $article)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                                <form action="{{route('revisor.rejectArticle', $article)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="text-center">
                    <a href="{{route('articles.index')}}" class="text-secondary">Go to article list</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>