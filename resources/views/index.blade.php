@extends('layouts.app')

@section('content')
    <!--Jumbotron-->
<div class="jumbotron pt-3 pb-3">
  <h1 class="display-4">Page Analyzer</h1>
  <p class="lead">Check your site for SEO suitability</p>
  <hr>
<br>

{{Form::open(['url' => route('domains.index'), 'method' => 'POST', 'class' => 'form-row'])}}
    {{Form::button('Search', ['class' => 'btn btn-outline-success mb-2', 'type' => 'submit'])}}
    <div class="form-group col-lg mb-2">
    {{Form::text('name', '', ['class' => 'form-control form-control-lg', 'placeholder' => "Enter webpage URL", 'aria-label' => 'Search'])}}
    </div>
{{Form::close()}}

{{-- <form class="form-row" action="/domains" method="POST">
    @csrf
<button type="submit" class="btn btn-outline-success mb-2">Search</button>
<div class="form-group col-lg mb-2">
<input type="text" name="name" class="form-control form-control-lg" placeholder="Enter webpage URL" aria-label="Search">
</div>
</form> --}}

<br>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert" align="center">
    @foreach ($errors->all() as $error)
    (!) {{ $error }}
    @endforeach
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif

@endsection
