@extends('layouts.app')

@section('header')
<h4>Add a Skill</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif


<h1>Add Skill</h1>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <a class="btn btn-small btn-primary" href="{{ URL::to('skills/') }}">Back to index</a>
    </div>


@endif

{!! Form::open(array('url' => 'skills')) !!}
<div class="form-group">
  {!! Form::label('skill', 'Enter skill (this matches the state)') !!}
  {!! Form::text('skill', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('description', 'Enter description') !!}
  {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('subtype', 'Enter subtype (this is the group it belongs to)') !!}
  {!! Form::text('subtype', null, ['class' => 'form-control']) !!}
</div>

    <div class="form-group">
        @foreach($topics as $key => $value)
            <nobr>{{ Form::checkbox('topic[' . $value->id . ']') }}
            {{ Form::label('topic[' . $value->id . ']', $value->topic)}}&emsp;</nobr>
        @endforeach
    </div>

    {!! Form::submit('Add the skill!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}


@endsection
