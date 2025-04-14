@extends('layout')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Follow Relationships</h1>

    <!-- Following List -->
    <div class="mb-5">
        <h2 class="text-primary">People You're Following</h2>
        @if($following->isEmpty())
            <p class="text-muted">You are not following anyone yet.</p>
        @else
            <ul class="list-group">
                @foreach($following as $followedUser)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <img 
                                src="{{ $followedUser->profile_photo ? asset('profile_photos/' . $followedUser->profile_photo) : asset('default_profile.png') }}" 
                                alt="{{ $followedUser->name }}'s Profile" 
                                class="rounded-circle me-3" 
                                style="width: 50px; height: 50px; object-fit: cover;"
                            >
                            <span>{{ $followedUser->name }}</span>
                        </div>
                        <form action="{{ route('friends.unfollow', $followedUser->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Unfollow</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Followers List -->
    <div>
        <h2 class="text-success">People Following You</h2>
        @if($followers->isEmpty())
            <p class="text-muted">You have no followers yet.</p>
        @else
            <ul class="list-group">
                @foreach($followers as $followerUser)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <img 
                                src="{{ $followerUser->profile_photo ? asset('profile_photos/' . $followerUser->profile_photo) : asset('default_profile.png') }}" 
                                alt="{{ $followerUser->name }}'s Profile" 
                                class="rounded-circle me-3" 
                                style="width: 50px; height: 50px; object-fit: cover;"
                            >
                            <span>{{ $followerUser->name }}</span>
                        </div>
                        <form action="{{ route('friends.unfollow', $followerUser->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-warning">Remove Follower</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
