@extends('layouts.app')

@section('header')
<h3>Plan new study session</h3>
<h5>Material you have studied previously will always be prioritized by how well
  you know it, so it's fine to leave material you know well in your session. You
  won't see it unless you need to review it or there's nothing else to work on.
  Make sure something is checked, or you won't have anything to study!</h5>
@endsection

@section('content')

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <p>{{ $word->word }}</p>
@endif

{{ Form::open(['url' => '/home/plan']) }}
{{ Form::hidden('input', json_encode($data)) }}
{{ Form::submit('Set new session!', array('class' => 'btn btn-success')) }}
<!-- will be used to show progress on previously studied -->
@if($data != null)

@if($data['unseen'] != null)
<h4>Material you meant to study but haven't seen yet</h4>
<p>Leave it checked if you want to include it in your current session, or uncheck to remove it.</p>
<dl>
  @foreach($data['unseen'] as $key => $topic)
  <dt>{{ Form::checkbox('data[' . 'unseen' .'][' . $key .']', '1', true) }}
  {{ Form::label('data[' . 'unseen' .'][' . $key .']', $topic['name']) }}</dt>
  <dd>{{ ltrim($topic['string'], ',') }}</dd>
  @endforeach
</dl>
<hr>
@endif
@if($data['due'] != null)
<h4>Material due for review</h4>
<p>Leave it checked if you want to include it in your current session, or uncheck to remove it.</p>
<dl>
  @foreach($data['due'] as $key => $topic)
  <dt>{{ Form::checkbox('data[' . 'due' .'][' . $key .']', '1', true) }}
  {{ Form::label('data[' . 'due' .'][' . $key .']', $topic['name']) }}</dt>
  <dd>{{ ltrim($topic['string'], ',') }}</dd>
  @endforeach
</dl>
<hr>
@endif
@if($data['prev'] != null)
<h4>Material you studied last session</h4>
<p>Leave it checked if you want to include it in your current session, or uncheck to remove it.</p>
<dl>
  @foreach($data['prev'] as $key => $topic)
  <dt>{{ Form::checkbox('data[' . 'prev' .'][' . $key .']', '1', true) }}
  {{ Form::label('data[' . 'prev' .'][' . $key .']', $topic['name']) }}</dt>
  <dd>{{ ltrim($topic['string'], ',') }}</dd>
  @endforeach
</dl>
<hr>
@endif
@if($data['other'] != null)
<h4>Other material you have previously studied, not currently recommended for review</h4>
<p>Check it if you want to include it in your current session.</p>
<dl>
  @foreach($data['other'] as $key => $topic)
  <dt>{{ Form::checkbox('data[' . 'other' .'][' . $key .']', '0', false) }}
  {{ Form::label('data[' . 'other' .'][' . $key .']', $topic['name']) }}</dt>
  <dd>{{ ltrim($topic['string'], ',') }}</dd>
  @endforeach
</dl>
<hr>
@endif
@else
<div>You haven't studied anything yet. Pick a topic below.</div>
@endif
<hr>

<!-- will be used to add new topics -->
@if($new !== null)
<h4>New topics!</h4>
<p> Add all words, facts and skills associated with a topic
   by checking it, or click the button to edit in detail. If you add multiple
  new topics at once, they will be prioritized by their ID (lowest ID studied first).
  If you want to study them in a different order, for right now, you should just add the one
  you want to do first. After you study it, start a new session.</p>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Add</td>
            <td>ID</td>
            <td>Topic</td>
            <td colspan="3">Associated words, facts and skills</td>
        </tr>
    </thead>
    <tbody>
      @foreach($new as $value)
          <tr>
              <td>{{ Form::checkbox('new[' . $value['id'] . ']', $value['selected']) }}</td>
              <td>{{ $value['id'] }}</td>
              <td>{{ $value['name'] }}</td>
              <td>{{ $value['words']->implode(', ') }}</td>
              <td>{{ $value['skills']->implode(', ') }}</td>
              <td>{{ $value['facts']->implode(', ') }}</td>
              <!--<td>
                  <a class="btn btn-small btn-primary"
                  href="{{ URL::to('home/plan/topic/' . $value['id']) }}">Manage topic details</a>
              </td>-->
          </tr>
      @endforeach
    </tbody>
</table>
@endif
{{ Form::submit('Set new session!', array('class' => 'btn btn-success')) }}

@endsection
