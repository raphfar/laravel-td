@extends('layouts.app')

@section('content')



    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-preview">
                        @include('messages.success')
                        @include('messages.error')
                        @foreach($articles as $article)
                        <h2 class="post-title">
                            <a href="{{ route('article.show', $article->id) }}">{{$article->title}}</a>
                        </h2>
                        <h3 class="post-subtitle">
                            <a href="{{ route('article.show', $article->id) }}">{{$article->content}}</a>
                        </h3>
                            <p class="post-meta">Posté par : {{ $article->user->name }} le {{$article->created_at}}</p>
                            <form method="POST" action="{{ route('admin.destroy', $article->id) }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <input type="submit" value="Supprimer" class="btn btn-danger">
                                <br><br>
                            </form>
                    @endforeach
                    {{$articles->links()}}
                </div>
                <hr>
            </div>

@endsection