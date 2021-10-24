@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <h1>{{ $post->title }}
        <x-badge type="success" :show="now()->diffInMinutes($post->created_at)<5">
            Brand new Post!
        </x-badge>
    </h1>

    <p> {{ $post->content }} </p>

    <x-updated :date="$post->created_at" :name="$post->user->name">
        By {{ $post->user->name }}
    </x-updated>

    <h4>Comments</h4>

    @forelse($post->comments as $comment)
        <p>
            {{ $comment->content }}
        </p>

        <x-updated :date="$comment->created_at">
        </x-updated>
    @empty
        <p>No comments yet!</p>
    @endforelse

@endsection
