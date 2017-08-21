@extends('layouts.app')

@section('header')
<h4>View facts by group</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->


<div>Before you add facts, check if they already exist</div>
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif



<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>id</td>
            <td>group_name</td>
            <td>key</td>
            <td>key_name</td>
            <td>prop</td>
            <td>prop_name</td>
        </tr>
    </thead>
    <tbody>
    @foreach($facts as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->group_name }}</td>
            <td>{{ $value->key }}</td>
            <td>{{ $value->key_name }}</td>
            <td>{{ $value->prop }}</td>
            <td>{{ $value->prop_name }}</td>
            <td>
                <a class="btn btn-small btn-info" href="{{ URL::to('facts/' . $value->id . '/edit') }}">Edit this fact</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ Form::open(array('url' => 'facts/group/' . $facts[0]->group_name)) }}
    <div>
      Add all facts in this group to a topic:
      <div class="form-group">
          @foreach($topics as $key => $value)
              <nobr>{{ Form::checkbox('topic[' . $value->id . ']') }}
              {{ Form::label('topic[' . $value->id . ']', $value->topic)}}&emsp;</nobr>
          @endforeach
      </div>
    </div>
    {{ Form::submit('Add topic', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
    <a class="btn btn-small btn-primary" href="{{ URL::to('facts/') }}">Back to index</a>
<a href="{{ url('facts/create') }}" class="btn btn-primary btn-sm">Add a fact</a>

@endsection
