@extends('layouts.app')

@section('header')
<h4>Hi {{$user->name}}! Let's go.</h4>
@endsection

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@section('content')
<nomenclature-session></nomenclature-session>
@endsection
