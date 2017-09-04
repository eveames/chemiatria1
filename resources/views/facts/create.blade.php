@extends('layouts.app')

@section('header')
<h4>Add a fact</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif


<h1>Add Fact</h1>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <a class="btn btn-small btn-primary" href="{{ URL::to('facts/') }}">Back to index</a>
    </div>


@endif

<h4>Reference Table</h4>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>group_name</td>
            <td>key</td>
            <td>key_name</td>
            <td>prop</td>
            <td>prop_name</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>conversion factor</td>
            <td>1</td>
            <td>mL</td>
            <td>1</td>
            <td>cm^3</td>
        </tr>
        <tr>
            <td>numerical constant</td>
            <td>1</td>
            <td>g/mL</td>
            <td>water</td>
            <td>density</td>
        </tr>
        <tr>
            <td>General, especially name/formula</td>
            <td>H2O</td>
            <td>formula</td>
            <td>water</td>
            <td>name</td>
        </tr>
    </tbody>
</table>

{!! Form::open(array('url' => 'facts')) !!}

    <div class="form-group">
        {!! Form::label('group_name', 'Select type') !!}
        {!! Form::select('group_name',
          ['numerical constant' => 'numerical constant',
          'conversion factor' => 'conversion factor',
          'polyatomic ions' => 'polyatomic ions',
          'acid' => 'acid',
          'common compound' => 'common compound'],
          null, ['placeholder' => 'Pick a type...']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('key', 'Enter key') !!}
      {!! Form::text('key', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('key_name', 'Enter key_name') !!}
      {!! Form::text('key_name', 'formula', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('prop', 'Enter prop') !!}
      {!! Form::text('prop', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('prop_name', 'Enter prop_name') !!}
      {!! Form::text('prop_name', 'name', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        @foreach($topics as $key => $value)
            <nobr>{{ Form::checkbox('topic[' . $value->id . ']') }}
            {{ Form::label('topic[' . $value->id . ']', $value->topic)}}&emsp;</nobr>
        @endforeach
    </div>

    {!! Form::submit('Add the fact!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}


@endsection
