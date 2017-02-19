@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('messages.success')
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Liste des articles</h1></div>

                    <div class="panel-body">
                        <ul>
                            @foreach($articles as $article)
                                <li><a href="{{ route('article.show', $article->id) }}">{{ $article->title }}</a></li>
                            @endforeach
                        </ul>

                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
