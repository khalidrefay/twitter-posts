@extends('layout')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Your Posts</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="post-container">
            @if($posts->isEmpty())
                <p>No posts found. Create your first post!</p>
            @else
                @foreach($posts as $post)
                    <div class="post-card mb-4">
                        <div class="post-header">
                            <h2 class="post-title">{{ $post->title }}</h2>
                            <div class="post-meta">
                                <span>Posted by <a href="{{ route('user.profileshow', ['id' => $post->user->id]) }}">
    {{ $post->user->name }}
</a> on {{ $post->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <p class="post-description">{{ $post->description }}</p>
                        <div class="post-footer">
                            {{-- Show the Edit button only for the owner of the post --}}
                            @if(Auth::id() === $post->user_id)
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this post?');">Remove</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection