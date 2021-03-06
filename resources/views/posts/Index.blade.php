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

                <x-updated :date="$post->created_at" :name="$post->user->name" :userId="$post->user->id">
                    By {{ $post->user->name }}
                </x-updated>

                <x-updated :date="$post->updated_at" :name="$post->user->name">
                    Updated
                </x-updated>

                <x-tags :tags="$post->tags">

                </x-tags>

                @if ($post->comment_count >= 0)
                    <p> {{ $post->comments_count }} comments </p>
                @else
                    <p>No comments yet! </p>
                @endif

                @auth
                    @can('update', $post)
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">
                            Edit
                        </a>
                    @endcan
                @endauth

                @auth
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
                @endauth
                </p>

            @empty
                No posts found!
            @endforelse
        </div>

        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>
    </div>

@endsection
