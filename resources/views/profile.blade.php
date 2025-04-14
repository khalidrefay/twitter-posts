@extends('layout')

@section('content')

<div class="container my-5">
    <div class="profile-container text-center">
        <!-- Profile Section -->
        <div class="profile-header mb-5">
            <h1 class="mb-3">{{ $user->name }}'s Profile</h1>
            @if ($user->profile_photo)
                <img 
                    src="{{ asset('profile_photos/' . $user->profile_photo) }}" 
                    alt="Profile Photo" 
                    class="rounded-circle border" 
                    style="width: 150px; height: 150px; object-fit: cover;"
                >
            @else
                <img 
                    src="{{ asset('default-profile.png') }}" 
                    alt="Default Profile Photo" 
                    class="rounded-circle border" 
                    style="width: 150px; height: 150px; object-fit: cover;"
                >
            @endif
        </div>

        <!-- User Info -->
        <div class="card shadow-sm p-4 mb-4">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Joined on:</strong> {{ $user->created_at->format('d M, Y') }}</p>
        </div>

        <!-- Profile Photo Upload -->
        <div class="card shadow-sm p-4 mb-4">
            <form action="{{ route('user.updateProfilePhoto') }}" method="POST" enctype="multipart/form-data" class="text-start">
                @csrf
                <div class="mb-3">
                    <label for="profile_photo" class="form-label">Upload New Profile Photo:</label>
                    <input type="file" name="profile_photo" id="profile_photo" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Upload Photo</button>
            </form>
        </div>
    </div>

    <!-- User Posts Section -->
    <div class="user-posts mt-5">
        <h2 class="mb-4">Your Posts</h2>
        @if ($user->posts->isEmpty())
            <p class="text-muted">No posts yet. Create your first post!</p>
        @else
            @foreach ($user->posts as $post)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title">{{ $post->title }}</h3>
                        <p class="card-text">{{ $post->description }}</p>
                        <p class="text-muted small mb-0">Posted on {{ $post->created_at->format('d M, Y') }}</p>

                        <!-- Display Post Image (if exists) -->
                        @if($post->image)
                            <div class="post-image mt-3">
                                <img 
                                    src="{{ asset('images/posts/' . $post->image) }}" 
                                    alt="Post Image" 
                                    class="img-fluid rounded"
                                    style="max-height: 300px; object-fit: cover; width: 100%;"
                                >
                            </div>
                        @endif

                        <!-- Edit and Remove Buttons -->
                        @if(Auth::id() === $post->user_id)
                            <div class="post-actions mt-3">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to remove this post?');">Remove</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@endsection
