@extends('layouts.app')

@section('title','- Contact page')

@section('content')

@can('home.secret')
    <p> Special contact details
        <a href="{{ route('secret') }}">
        Go to special contact details!
        </a>
    </p>
@endcan
<center>
<h3>Please feel free to contact us by submitting your query in the form below</h3>

<label>First Name</label>
<input type="text"></input><br>
<label>Last Name</label>
<input type="text"></input><br>
<label>Contact Number</label>
<input type="text"></input><br>
<label>Email address</label>
<input type="text"></input><br>
<label>Query</label>
<input type="text"></input><br>
<input type="submit"></input>
</center>

@endsection