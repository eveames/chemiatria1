@extends('layouts.app')

@section('header')
<h4>Hi {{$user->name}}! Let's go.</h4>
@endsection

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@section('content')
<app-root [username] = $user->name >Loading...</app-root>
  <script type="text/javascript" src="/js/inline.bundle.js"></script>
  <script type="text/javascript" src="/js/polyfills.bundle.js"></script>
  <script type="text/javascript" src="/js/styles.bundle.js"></script>
  <script type="text/javascript" src="/js/vendor.bundle.js">
  </script><script type="text/javascript" src="/js/main.bundle.js"></script>
  @endsection
