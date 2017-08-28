@extends('layouts.app')

@section('header')
<h4>View skills</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<h2>Skill</h2>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>id</td>
            <td>skill</td>
            <td>description</td>
            <td>subtype</td>
            <td>topics</td>
        </tr>
    </thead>
    <tbody>
      @foreach($skills as $skill)
        <tr>
            <td>{{ $skill->id }}</td>
            <td>{{ $skill->skill }}</td>
            <td>{{ $skill->description }}</td>
            <td>{{ $skill->subtype }}</td>
            <td>{{ $skill->topics->pluck('topic')->implode(', ') }}</td>
            <td><a class="btn btn-small btn-info"
              href="{{ URL::to('skills/' . $skill->id . '/edit') }}">Edit this skill</a></td>
        </tr>
      @endforeach
    </tbody>
</table>

<a href="{{ url('skills/create') }}" class="btn btn-primary btn-sm">Add a skill</a>

@endsection
