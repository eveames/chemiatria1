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
<p>Use the Edit Word form to add alternate answers</p>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{!! Form::open(array('url' => 'words')) !!}

    <div class="form-group">
        {!! Form::label('word', 'Enter word:') !!}
        {!! Form::text('word', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('prompts', 'Enter prompts, separated by semicolons (;):') !!}
        {!! Form::text('prompts', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Add the word!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}


@endsection