@extends('layouts.app')

@section('header')
<h4>Search for words</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->


<div>Before you add words, check if they already exist as words or alternates</div>
<hr>

<!-- search box to see if words exist -->
{!! Form::open(['method'=>'GET','url'=>'words', 'role'=>'search'])  !!}

 
<div class="input-group custom-search-form">
    {!! Form::label('search', 'Enter words to search for, separated by semicolons:') !!}<br>
    {!! Form::text('search', null, ['class' => 'form-control']) !!}<br>
    {!! Form::submit('Search!', array('class' => 'btn btn-small btn-primary')) !!}
</div>
{!! Form::close() !!}

<hr>
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
            

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- delete the word (uses the destroy method DESTROY /words/{id} -->
                <!-- we will add this later since its a little more complicated than the other two buttons -->

                <!-- show the word (uses the show method found at GET /words/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('words/topics/' . $value->id) }}">Show these words</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Word</td>
            <td>Prompts</td>
        </tr>
    </thead>
    <tbody>
    @foreach($words as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->word }}</td>
            <td>{{ $value->prompts }}</td>
            

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- delete the word (uses the destroy method DESTROY /words/{id} -->
                <!-- we will add this later since its a little more complicated than the other two buttons -->

                <!-- show the word (uses the show method found at GET /words/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('words/' . $value->id) }}">Show this word</a>

                <!-- edit this word (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('words/' . $value->id . '/edit') }}">Edit this word</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@if($alternates)
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Alternate</td>
            <td>Word</td>
        </tr>
    </thead>
    <tbody>
    @foreach($alternates as $key => $value)
        <tr>
            <td>{{ $value->alt }}</td>
            <td>{{ $value->word->word }}</td>
            <td>

                <!-- delete the word (uses the destroy method DESTROY /words/{id} -->
                <!-- we will add this later since its a little more complicated than the other two buttons -->

                <!-- show the word (uses the show method found at GET /words/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('words/' . $value->word->id) }}">Show this word</a>

                <!-- edit this word (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('words/' . $value->word->id . '/edit') }}">Edit this word</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif

<a href="{{ url('words/create') }}" class="btn btn-primary btn-sm">Add a word</a>

@endsection