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

              {{--  <x-updated :date="$post->created_at" :name="$post->user->name">
                    By {{ $post->user->name }}
                </x-updated> --}}

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

        <div class="col-4">
            <div class="container">
                <div class="row mt-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                What people are currently talking about
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active users</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                User with most posts
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActive as $user)
                                <li class="list-group-item">
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                        {{ $user->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active last month</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                User with most posts last month
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActiveLastMonth as $user)
                                <li class="list-group-item">
                                    {{ $user->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
