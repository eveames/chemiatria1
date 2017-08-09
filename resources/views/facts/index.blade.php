@extends('layouts.app')

@section('header')
<h4>Search for facts</h4>
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
            <td>ID</td>
            <td>Topic</td>
        </tr>
    </thead>
    <tbody>
    @foreach($topics as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->topic }}</td>
            <td>
                <a class="btn btn-small btn-success"
                  href="{{ URL::to('facts/topics/' . $value->id) }}">Show these facts</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

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

<a href="{{ url('facts/create') }}" class="btn btn-primary btn-sm">Add a fact</a>

@endsection
