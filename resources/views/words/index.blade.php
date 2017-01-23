@extends('layouts.app')

@section('header')
<h4>All the words so far</h4>
@endsection

@section('content')
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Word</td>
            <td>Prompts</td>
        </tr>
    </thead>
    <tbody>
    @foreach($words as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->word }}</td>
            <td>{{ $value->prompts }}</td>
            

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- delete the word (uses the destroy method DESTROY /words/{id} -->
                <!-- we will add this later since its a little more complicated than the other two buttons -->

                <!-- show the word (uses the show method found at GET /words/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('words/' . $value->id) }}">Show this word</a>

                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('words/' . $value->id . '/edit') }}">Edit this word</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</div>
</body>
</html>