@extends('layouts.app')

@section('header')
<h4>Hi {{$user->name}}! This is your Dashboard</h4>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!

                </div>
                @can('edit_word') 
                <div class="panel-body"><a href="{{ url('/words') }}">Add Vocab Words</a></div>
                @endcan


            </div>
        </div>
    </div>
</div>
@endsection