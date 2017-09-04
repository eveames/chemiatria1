@extends('layouts.app')

@section('header')
<h4>Single Fact View</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

    <div>
        <h2>Fact</h2>

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
                <tr>
                    <td>{{ $fact->id }}</td>
                    <td>{{ $fact->group_name }}</td>
                    <td>{{ $fact->key }}</td>
                    <td>{{ $fact->key_name }}</td>
                    <td>{{ $fact->prop }}</td>
                    <td>{{ $fact->prop_name }}</td>
                </tr>
            </tbody>
        </table>


            <br>
            <strong>Topics</strong>
            <ul>
            @foreach($topics as $topic)
            <li>{{ $topic->topic }}</li>
            @endforeach
            </ul>

			<br>
			<a class="btn btn-small btn-primary" href="{{ URL::to('facts/' . $fact->id . '/edit') }}">Edit this fact</a>
			<a class="btn btn-small btn-primary" href="{{ URL::to('facts/') }}">Back to index</a>
       	</p>
    </div>

@endsection
