@extends('layouts.app')

@section('header')
<h4>Edit Word</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
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

{{ Form::model($word, array('route' => array('words.update', $word), 'method' => 'PUT')) }}


    <div>
        <h2>{{ $word->word }}</h2>
        <p>To edit the actual word, unfortunately you will need to create a new one and delete this one.</p>

        <p>
            <strong>Prompts</strong> 
            <ul>
            @foreach(json_decode($word->prompts) as $prompt)
            <li>
                <div class="form-group">
                    {{ Form::text('prompts[]', $prompt, ['class' => 'form-control']) }}
                </div>
            </li>
            @endforeach
            <li>
                <div class="form-group">
                    {{ Form::label('newPrompt', 'Enter additional prompts, separated by semicolons (;):') }}
                    {{ Form::text('newPrompts', null, ['class' => 'form-control']) }}
                </div>
            </li>
            </ul>
            
            
            <strong>Alternates</strong> 
            <p>You can add three new alternates at a time. After that, update and repeat. Please don't change the alternate words themselves, just add new ones.</p>
            <table>
            	<thead>
        			<tr>
            			<td>Alternate Answer</td>
            			<td>Correct?</td>
            			<td>Message</td>
        			</tr>
    			</thead>
    			<tbody>
    				@foreach($altwords as $altword)
        				<tr>
                            <td>{{  Form::text('altwords' . $altword->id . 'alt', $altword->alt, ['class' => 'form-control read-only']) }}</td>
            				<td>{{  Form::text('altwords' . $altword->id. 'correct', $altword->correct, ['class' => 'form-control']) }}</td>
                            <td>{{  Form::text('altwords' . $altword->id. 'message', $altword->message, ['class' => 'form-control']) }}</td>
        				</tr>
    				@endforeach
                    <tr>
                        <td>{{  Form::text('newAltwords0alt', null, ['class' => 'form-control']) }}</td>
                        <td>{{  Form::text('newAltwords0correct', null, ['class' => 'form-control']) }}</td>
                        <td>{{  Form::text('newAltwords0message', null, ['class' => 'form-control']) }}</td>
                    </tr>
                    <tr>
                        <td>{{  Form::text('newAltwords1alt', null, ['class' => 'form-control']) }}</td>
                        <td>{{  Form::text('newAltwords1correct', null, ['class' => 'form-control']) }}</td>
                        <td>{{  Form::text('newAltwords1message', null, ['class' => 'form-control']) }}</td>
                    </tr>
                    <tr>
                        <td>{{  Form::text('newAltwords2alt', null, ['class' => 'form-control']) }}</td>
                        <td>{{  Form::text('newAltwords2correct', null, ['class' => 'form-control']) }}</td>
                        <td>{{  Form::text('newAltwords2message', null, ['class' => 'form-control']) }}</td>
                    </tr>

    			</tbody>
			</table>
			<br>
            
			
       	</p>
    </div>
    {{ Form::submit('Update the word!', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection


    
