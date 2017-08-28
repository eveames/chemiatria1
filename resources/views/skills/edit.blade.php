@extends('layouts.app')

@section('header')
<h4>Edit Skill</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <p>Fact</p>
@endif

{{ Form::model($skill, array('route' => array('skills.update', $skill), 'method' => 'PUT')) }}
    <div>

      <div class="form-group">
        {!! Form::label('skill', 'Enter skill (this matches the state)') !!}
        {!! Form::text('skill', $skill->skill, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('description', 'Enter description') !!}
        {!! Form::text('description', $skill->description, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('subtype', 'Enter subtype (this is the group it belongs to)') !!}
        {!! Form::text('subtype', $skill->subtype, ['class' => 'form-control']) !!}
      </div>

        <strong>Selected Topics</strong>
        <div class="form-group">
            @foreach($topics as $key => $value)
                <nobr>{{ Form::checkbox('topic[' . $value->id . ']', '1', true) }}
                {{ Form::label('topic[' . $value->id . ']', $value->topic)}}&emsp;</nobr>
            @endforeach
        </div>
        <strong>Other Topics</strong>
        <div class="form-group">
            @foreach($nonTopics as $key => $value)
                <nobr>{{ Form::checkbox('nonTopic[' . $value->id . ']') }}
                {{ Form::label('nonTopic[' . $value->id . ']', $value->topic)}}&emsp;</nobr>
            @endforeach
        </div>
    </div>
    {{ Form::submit('Update the skill!', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
    <a class="btn btn-small btn-primary" href="{{ URL::to('skills/') }}">Back to index</a>

@endsection
