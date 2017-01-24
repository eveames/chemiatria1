@extends('layouts.app')

@section('header')
<h4>Add a vocab word</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<h1>Add Word</h1>

<!-- if there are creation errors, they will show here {{ HTML::ul($errors->all()) }}-->


<!--{{ Form::open(array('url' => 'words')) }}

    <div class="form-group">
        {{ Form::label('word', 'Enter word:') }}
        {{ Form::text('name', Input::old('word'), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('prompts', 'Enter prompts, separated by semicolons (;):') }}
        {{ Form::text('prompts', Input::old('prompts'), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Add the word!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }} -->


@endsection