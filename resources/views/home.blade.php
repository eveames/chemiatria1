@extends('layouts.app')

@section('header')
<h4>Hi {{$user->name}}! This is your Dashboard</h4>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!

                </div>
                @can('create_word') 
                <div class="panel-body"><a href="{{ url('/words') }}">View Vocab Words</a></div>
                <div class="panel-body"><a href="{{ url('/words/create') }}">Add new Vocab Word</a></div>
                @endcan


            </div>
        </div>
    </div>
</div>
@endsection
