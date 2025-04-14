@extends('layout')

@section('content')
<div class="container my-5">
    <!-- Profile Section -->
    <div class="profile-container text-center mb-5">
        <h1 class="mb-3">{{ $user->name }}'s Profile</h1>
        @if ($user->profile_photo)
            <img 
                src="{{ asset('profile_photos/' . $user->profile_photo) }}" 
                alt="Profile Photo" 
                class="rounded-circle border mb-3" 
                style="width: 150px; height: 150px; object-fit: cover;"
            >
        @else
            <img 
                src="{{ asset('default-profile.png') }}" 
                alt="Default Profile Photo" 
                class="rounded-circle border mb-3" 
                style="width: 150px; height: 150px; object-fit: cover;"
            >
        @endif
        <p class="text-muted"><strong>Email:</strong> {{ $user->email }}</p>
        <p class="text-muted"><strong>Joined on:</strong> {{ $user->created_at->format('d M, Y') }}</p>
    </div>

    <!-- Follow & Message Buttons -->
    @if(Auth::id() !== $user->id)
        <div class="d-flex justify-content-center mb-4">
            <form id="follow-form" action="{{ route('toggle.follow', $user->id) }}" method="POST" class="me-2">
                @csrf
                <button type="button" id="follow-button" class="btn btn-primary">
                    {{ Auth::user()->followings->contains($user->id) ? 'Following' : 'Follow' }}
                </button>
            </form>
            <a href="{{ route('chat.show', $user->id) }}" class="btn btn-outline-primary">Message</a>
        </div>
    @endif

    <!-- Posts Section -->
    <div class="posts-section">
        <h2 class="mb-4 text-center">Your Posts</h2>
        @if ($user->posts->isEmpty())
            <p class="text-center text-muted">No posts yet. Create your first post!</p>
        @else
            @foreach ($user->posts as $post)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h3 class="card-title">{{ $post->title }}</h3>
                        <p class="card-text">{{ $post->description }}</p>
                        <p class="text-muted small mb-0">Posted on {{ $post->created_at->format('d M, Y') }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- JavaScript for Follow Button -->
<script>
    document.getElementById('follow-button').addEventListener('click', function() {
        fetch("{{ route('toggle.follow', $user->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const followButton = document.getElementById('follow-button');
            followButton.textContent = data.status === 'following' ? 'Following' : 'Follow';
        });
    });
</script>
@endsection
