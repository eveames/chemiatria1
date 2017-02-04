@extends('layouts.app')

@section('header')
<h4>Hi {{$user->name}}! This is your Dashboard</h4>
@endsection

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <a class="btn btn-small btn-success" href="{{ URL::to('home/report') }}">Email me my progress</a>
                </div>

                @can('create_word') 
                <div class="panel-body"><a href="{{ url('/words') }}">View Vocab Words</a></div>
                @endcan


            </div>
        </div>
    </div>
</div>
@endsection
