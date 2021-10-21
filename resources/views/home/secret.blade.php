@extends('layouts.app')

@section('title','- Contact page')

@section('content')

@can('home.secret')
    <p> This is the secret email sectionm: secret@laravel.test</p>
@endcan


@endsection