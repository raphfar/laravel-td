@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

            <h1>Contactez-nous !</h1>

            @include('messages.error')
            @include('messages.success')

                <div class="panel-body">
            <form method="POST" action="{{ route('form.store') }}">
                {{csrf_field()}}

                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" placeholder="email">
                        <p class="help-block text-danger"></p>
                    </div>


                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Message</label>
                        <textarea class="form-control" name="content" placeholder="Contenu"></textarea>
                        <p class="help-block text-danger"></p>

                </div>
                </div>
                <div class="panel-body">
                <div id="success"></div>

                    <div class="form-group col-xs-12">
                        <input type="submit" value="Envoyer" class="btn btn-success">
                    </div>
                </div>
            </form>

                </div>
            </div>
    </div>
</div>
@endsection

