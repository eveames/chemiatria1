@extends('layouts.app')

@section('header')
<h4>Single Skill View</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

    <div>
        <h2>Skill</h2>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>id</td>
                    <td>skill</td>
                    <td>description</td>
                    <td>subtype</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $skill->id }}</td>
                    <td>{{ $skill->skill }}</td>
                    <td>{{ $skill->description }}</td>
                    <td>{{ $skill->subtype }}</td>
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
			<a class="btn btn-small btn-primary" href="{{ URL::to('skills/' . $skill->id . '/edit') }}">Edit this skill</a>
			<a class="btn btn-small btn-primary" href="{{ URL::to('skills/') }}">Back to index</a>
       	</p>
    </div>

@endsection
