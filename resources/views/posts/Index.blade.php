@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')

    <div class="row">
        <div class="col-8">
            @forelse($posts as $post)
                <p>
                <h3>
                    @if ($post->trashed())
                        <del>
                    @endif
                    <a class="{{ $post->trashed() ? 'text-muted' : '' }}"
                        href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                    @if ($post->trashed())
                        </del>
                    @endif
                </h3>

                <x-updated :date="$post->created_at" :name="$post->user->name">
                    By {{ $post->user->name }}
                </x-updated>

                <x-updated :date="$post->updated_at" :name="$post->user->name">
                    Updated
                </x-updated>

                @if ($post->comment_count >= 0)
                    <p> {{ $post->comments_count }} comments </p>
                @else
                    <p>No comments yet! </p>
                @endif

                @can('update', $post)
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">
                        Edit
                    </a>
                @endcan

                @if (!$post->trashed())
                    @can('delete', $post)
                        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <input type="submit" value="Delete!" class="btn btn-primary">
                        </form>
                    @endcan
                @endif
                </p>

            @empty
                No posts found!
            @endforelse
        </div>

        <div class="row">
            <x-card title="Most Commented" subtitle="What people are currently talking about">
                @slot('items')
                    @foreach ($mostCommented as $post)
                        <li class="list-group-item">
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                {{ $post->title }}
                            </a>
                        </li>
                    @endforeach
                @endslot
            </x-card>
        </div>
        
        <div class="row mt-4">
            <x-card title="Most Active" subtitle="Users with most posts written"
                :items="collect($mostActive)->pluck('name')">
            </x-card>
        </div>
        <div class="row mt-4">
            <x-card title="Most Active Last Month" subtitle="Users with most posts written in the last month"
                :items="collect($mostActiveLastMonth)->pluck('name')">
            </x-card>
        </div>
    </div>

    </div>
    </div>
    </div>

@endsection
