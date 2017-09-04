@extends('layouts.app')

@section('header')
<h3>Manage topic detail</h3>
<h5>Choose which words, facts and skills in this topic you want to study.</h5>
@endsection

@section('content')

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
@endif

{{ Form::open(['url' => '/home/plan/detail']) }}
{{ Form::hidden('input', json_encode($data)) }}
{{ Form::submit('Set new session!', array('class' => 'btn btn-success')) }}
<!-- will be used to show progress on previously studied -->
@if($data != null)
<h4>Material associated with {{$data['name']}}</h4>
<p>Leave it checked if you want to include it in your current session, or uncheck to remove it.</p>
<dl>
  @if(!empty($data['words']))
  @foreach($data['words'] as $key => $word)
  <dt>{{ Form::checkbox('data[' . 'words' .'][' . $key .']', '1', true) }}
  {{ Form::label('data[' . 'words' .'][' . $key .']', $word) }}</dt>
  @endforeach
  @endif
</dl>
<dl>
  @if(!empty($data['skills']))
  @foreach($data['skills'] as $key => $skill)
  <dt>{{ Form::checkbox('data[' . 'skills' .'][' . $key .']', '1', true) }}
  {{ Form::label('data[' . 'skills' .'][' . $key .']', $skill) }}</dt>
  @endforeach
  @endif
</dl>
<dl>
  @if(!empty($data['facts']))
  @foreach($data['facts'] as $key => $fact)
  <dt>{{ Form::checkbox('data[' . 'facts' .'][' . $key .']', '1', true) }}
  {{ Form::label('data[' . 'facts' .'][' . $key .']', $fact) }}</dt>
  @endforeach
  @endif
</dl>
<hr>

@else
<div>This topic doesn't seem to have anything to study associated with it yet.</div>
@endif
<hr>
{{ Form::submit('Set new session!', array('class' => 'btn btn-success')) }}

@endsection
