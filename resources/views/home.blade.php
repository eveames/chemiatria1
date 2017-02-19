@extends('layouts.app')

@section('header')
<h4>Hi {{$user->name}}! This is your Dashboard</h4>
@endsection

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@section('content')
<example></example>
<test></test>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a class="btn btn-small btn-success" href="{{ URL::to('home/report') }}">Email me my progress</a>
                </div>

                @can('create_word')
                <div class="panel-body">
                  <a class="btn btn-small btn-success" href="{{ url('/words') }}">View Vocab Words</a>
                </div>
                @endcan
                

            </div>
        </div>
    </div>
    <app-root>Loading...</app-root>
      <script type="text/javascript" src="/js/inline.bundle.js"></script>
      <script type="text/javascript" src="/js/polyfills.bundle.js"></script>
      <script type="text/javascript" src="/js/styles.bundle.js"></script>
      <script type="text/javascript" src="/js/vendor.bundle.js">
      </script><script type="text/javascript" src="/js/main.bundle.js"></script>
</div>

@endsection
