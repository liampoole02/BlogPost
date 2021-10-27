@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row>
        <div class=" col-8">

        <h1>{{ $post->title }}
            <x-badge type="success" :show="now()->diffInMinutes($post->created_at)<5">
                Brand new Post!
            </x-badge>
        </h1>

        <p> {{ $post->content }} </p>

        <x-updated :date="$post->created_at" :name="$post->user->name">
        </x-updated>

        <x-updated :date="$post->updated_at">
            Updated {{ $post->user->name }}
        </x-updated>

        <p> Currently read {{ $counter }} people </p>

        <x-tags :tags="$post->tags">

        </x-tags>

        <h4>Comments</h4>

        @include('comments._form')

        @forelse($post->comments as $comment)
            <p>
                {{ $comment->content }}
            </p>

            <x-updated :date="$comment->created_at" :name="$comment->user->name">
            </x-updated>

        @empty
            <p>No comments yet!</p>
        @endforelse

    </div>

    <div class="col-4">
        @include('posts._activity')
    </div>

@endsection
