<h3><a href="{{ route('posts.show', ['post'=> $post->id]) }}">{{ $post->title }}</a></h3>

<p class="text-mutes">
    Added {{ $post->created_at->diffForHumans()}}
    By {{ $post->user->name }}
</p>

@if($post->comment_count>=0)
<p> {{ $post->comments_count }} comments </p>
    @else
    <p>No comments yet! </p>
    @endif

<div class="mb-3">
    <a href="{{ route('posts.edit', ['post'=> $post->id]) }}" class="btn btn-primary">Edit</a>
    <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('DELETE')

        <input type="submit" value="Delete!" class="btn btn-primary">
    </form>
</div>