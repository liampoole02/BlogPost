@extends('layouts.app')

@section('title', '- Home page')

@section('content')
<h1>Welcome to the home page</h1>

@for($i=0; $i<10; $i++)
    <div>The current value is {{ $i }}</div>
@endfor

@endsection

