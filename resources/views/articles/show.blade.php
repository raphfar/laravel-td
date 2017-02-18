@extends('layouts.app')


<br><br><br>
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Item - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="thumbnail">
                @include('messages.success')
                @include('messages.error')
                <img src="{{ $article->images }}" style: width="150px">
                <div class="caption-full">
                    <h4>
                        Article Posté par : {{ $article->user->name }}
                    </h4>
                    <div class="panel-body">
                        <h1>{{ $article->title }}</h1>

                        <h2>{{ $article->content }}</h2>
                        Partager l'article : {{URL::to('/article/'.$article->id)}}
                        <form method="POST" action="{{ route('article.destroy', $article->id)}}">
                            {{csrf_field()}}
                            <div class="panel-heading">
                                @if(Auth::check() and auth()->user()->isAdmin or Auth::check() and $articles = Auth::user()->id == $article->user->id)
                                    <a href="{{ route('article.edit', $article->id) }}" class="btn btn-primary">Modifier</a>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input class="btn btn-danger "type="submit" value="supprimer">
                                @endif
                            </div>
                        </form>
                    <div class="ratings">
                </div>
            </div>
            <div class="well">
                    <div class="panel-body">
                        @if(Auth::check())
                            <form method="POST" action="{{ route('comment.store') }}">
                                {{csrf_field()}}
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <textarea class="form-control" name="content" placeholder="Commentaire"></textarea>
                                <div class="panel-heading">
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
                                <p>Commentaire Posté par : {{$comment->user->name}} </p>
                                <p>{{ $comment->content }}</p>
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
<!-- /.container -->


<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
        <script src="vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Contact Form JavaScript -->
        <script src="js/jqBootstrapValidation.js"></script>
        <script src="js/contact_me.js"></script>

        <!-- Theme JavaScript -->
        <script src="js/clean-blog.min.js"></script>
</body>
</html>
@endsection