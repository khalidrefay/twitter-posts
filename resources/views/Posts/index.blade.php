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
                <div class="post-card d-flex flex-column mb-4 p-3 border rounded">
                    <!-- User Profile Photo -->
                    <div class="d-flex align-items-center mb-3">
                        <img 
                            src="{{ $post->user->profile_photo ? asset('profile_photos/' . $post->user->profile_photo) : asset('default-profile.png') }}" 
                            alt="{{ $post->user->name }}'s Profile Photo" 
                            class="rounded-circle me-3" 
                            style="width: 50px; height: 50px; object-fit: cover;"
                        >
                        <div>
                            <h5 class="mb-0">
                                <a href="{{ route('user.profileshow', ['id' => $post->user->id]) }}" class="text-decoration-none text-dark">
                                    {{ $post->user->name }}
                                </a>
                            </h5>
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Post Description -->
                    <p class="mb-1 text-secondary">{{ $post->description }}</p>

                    <!-- Display Uploaded Post Image (if exists) -->
                    @if($post->image)
                        <div class="post-image mb-3">
                            <img 
                                src="{{ asset('images/posts/' . $post->image) }}" 
                                alt="Post Image" 
                                class="img-fluid rounded" 
                                style="max-height: 300px; object-fit: cover; width: 100%;"
                            >
                        </div>
                    @endif

                    <!-- Post Footer with Actions -->
                    <div class="post-footer">
                        @if(Auth::id() === $post->user_id)
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to remove this post?');">Remove</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
