@extends('layouts.app')

@section('header')
<h4>Single Word View</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

    <div>
        <h2>{{ $word->word }}</h2>

        <p>
            <strong>Prompts</strong> 
            <ul>
            @foreach(json_decode($word->prompts) as $prompt)
            <li>{{ $prompt }}</li>
            @endforeach
            </ul>
            
            <strong>Alternates</strong> 
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
            				<td>{{ $altword->alt }}</td>
            				<td>{{ $altword->correct }}</td>
            				<td>{{ $altword->message }}</td>
        				</tr>
    				@endforeach
    			</tbody>
			</table>
            <br>
            <strong>Topics</strong> 
            <ul>
            @foreach($topics as $topic)
            <li>{{ $topic->topic }}</li>
            @endforeach
            </ul>

			<br>
			<a class="btn btn-small btn-primary" href="{{ URL::to('words/' . $word->id . '/edit') }}">Edit this word</a>
			<a class="btn btn-small btn-primary" href="{{ URL::to('words/') }}">Back to search</a>
       	</p>
    </div>

@endsection

