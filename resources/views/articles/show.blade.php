@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @include('messages.success')
                    @include('messages.error')

                    @if(!empty($articles->picture))
                        <img src="/uploads/{{$articles->picture}}">
                    @endif


                    <div class="panel-heading"><h1>{{ $article->title }}</h1></div>

                    <div class="panel-body">Article publié par : {{ $article->user->name }}</div>
                    <div class="panel-body">

                        {{ $article->content }} </div>
                    <form method="POST" action="{{ route('article.destroy', $article->id)}}">
                        {{csrf_field()}}
                        <div class="panel-default">
                            @if(Auth::check() and auth()->user()->isAdmin or Auth::check() and $articles = Auth::user()->id == $article->user->id)
                                <a href="{{ route('article.edit', $article->id) }}" class="btn btn-primary">Modifier</a>
                                <input type="hidden" name="_method" value="DELETE">
                                <input class="btn btn-danger " type="submit" value="supprimer">
                            @endif
                        </div>
                    </form>

                </div>
                <div class="well">
                    <div class="panel-body">
                        @if(Auth::check())
                            <form method="POST" action="{{ route('comment.store') }}">
                                {{csrf_field()}}
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <textarea class="form-control" name="content" placeholder="Commentaire"></textarea>
                                <div class="panel-default">
                                    <input type="submit" value="envoyer" class="btn btn-info">
                                </div>
                            </form>
                        @endif
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($comments as $comment)
                                @if($comment->article_id == $article->id)
                                    <h4>{{ $comment->content }}</h4>
                                    <h5>Commentaire publié par : {{$comment->user->name}} </h5>

                                    <div class="panel-heading">
                                        @if(Auth::check() and auth()->user()->isAdmin or Auth::check() and $comments = Auth::user()->id == $comment->user->id)
                                            <a href="{{ route('comment.edit', $comment->id) }}" class="btn btn-primary">Modifier</a>
                                            <form method="POST" action="{{ route('comment.destroy', $comment->id) }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="delete">
                                                <input type="submit" value="Supprimer" class="btn btn-danger">
                                            </form>
                                        @else
                                        @endif
                                    </div>
                                @else
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>

@endsection