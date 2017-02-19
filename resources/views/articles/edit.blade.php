@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Editer un article</h1></div>
                    @include('messages.error')
                    <div class="panel-body">
                        <form method="POST" action="{{ route('article.update', $article->id) }}">
                            <input type="hidden" name="_method" value="PUT">
                            {{csrf_field()}}
                            <input class="form-control" type="text" value="{{$article->title}}" name="title" placeholder="Titre">
                            <textarea class="form-control" name="content" placeholder="Contenu">{{$article->content}}</textarea>
                            <textarea class="form-control" name="images" placeholder="placez l'url de votre image">{{$article->images}}</textarea>
                            <input type="submit" value="publier" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection