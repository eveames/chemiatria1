@extends('layouts.app')

@section('header')
<h4>Intro to Lewis Structures</h4>
@endsection

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@section('content')
<lewis-intro></lewis-intro>
@endsection
