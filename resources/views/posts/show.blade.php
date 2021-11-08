@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-8">
        @if($post->image)
        <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align:center; background-attachment: fixed;">
            <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
                @else
                <h1>
                    @endif

                    {{ $post->title }}

                    <x-badge type="success" :show="now()->diffInMinutes($post->created_at)<5">
                        Brand new Post!
                    </x-badge>
                    @if($post->image)

                </h1>
        </div>
        @else
        </h1>

        @endif
    </div>
    <div class=" col-8">

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