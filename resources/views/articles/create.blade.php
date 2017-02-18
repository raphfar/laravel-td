@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ajout d'article</div>
                        @include('messages.error')
                    <div class="panel-body">
                        <form method="POST" action="{{ route('article.store') }}">
                            {{csrf_field()}}
                            <input class="form-control" type="text" name="title" placeholder="Titre">
                            <textarea class="form-control" name="content" placeholder="Contenu"></textarea>
                            <textarea class="form-control" name="images" placeholder="placez l'url de votre image"></textarea>
                            <input type="submit" value="publier" class="btn btn-info">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection