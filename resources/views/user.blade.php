@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    <div class="panel-heading">Dashboard</div>

<h3>Vos informations</h3>
<ul><li>{{ Auth::user()->name }}</li><li>{{ Auth::user()->email }}</li><li>{{ Auth::user()->created_at }}</li></ul>

                    <div class="panel-body">
                        <h1>Mes articles</h1>

                        @forelse(Auth::user()->articles as $article)
                            <h2>{{$article->title}}</h2>
                            <p>{{$article->content}}</p>
                        @empty
                            Aucun article(s)
                        @endforelse

                        <h1>Mes commentaires</h1>
                        @forelse(Auth::user()->comments as $comment)
                            <h3>{{$comment->content}}</h3>
                            {{ Form::open(['route' => ['users.update', $comment->id], 'method'=> 'put']) }}

                            {{ Form::text('content', '', ['class' => 'form-control']) }}

                            {{ Form::submit('Modifier le commentaire', ['class' => 'btn btn-primary']) }}

                            {{ Form::close() }}
                        @empty
                            Aucun commentaire(s)
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
