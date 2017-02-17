@if($success = Session::get('success'))
    <div class="alert alert-success">
        {{ $success }}
    </div>
@endif