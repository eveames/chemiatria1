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
                    <a class="btn btn-small btn-success" href="{{ URL::to('home/report') }}">Email me my progress</a>
                </div>
                <div class="panel-body">
                    <a class="btn btn-small btn-success" href="{{ URL::to('home/play') }}">Start session</a>
                </div>
                <div class="panel-body">
                  <div>Use this button to review your progress, add new material to study, and setup your new study session</div>
                    <a class="btn btn-small btn-success" href="{{ URL::to('home/plan') }}">Setup new session</a>
                </div>

                <div class="panel-body">
                  @if('numDueToReview' != 0)
                    <div>You have {{ $numDueToReview }} topics to review! We recommend that you do some review regularly so you don't forget.</div>
                  @else
                    <div>You are caught up and have no recommended review topics, but you can review anyway.</div>
                  @endif
                    <a class="btn btn-small btn-success" href="{{ URL::to('home/play/all') }}">Review now</a>
                </div>

                @can('create_word')
                <div class="panel-body">
                  <a class="btn btn-small btn-success" href="{{ url('/words') }}">View Vocab Words</a>
                </div>
                <div class="panel-body">
                  <a class="btn btn-small btn-success" href="{{ url('/facts') }}">View Facts</a>
                </div>
                <div class="panel-body">
                  <a class="btn btn-small btn-success" href="{{ url('/skills') }}">View Skills</a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

@endsection
