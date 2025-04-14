@extends('layout')

@section('content')

<div class="container my-5">
    <h1 class="text-center mb-4">Your Messages</h1>

    <!-- Display People You Have Chatted With -->
    <div class="chat-list-container">
        <h2 class="text-primary mb-3">Chats</h2>

        @if($chats->isEmpty())
            <p class="text-muted">You have no chats yet. Start a conversation with your friends!</p>
        @else
            <ul class="list-group">
                @foreach ($chats as $chat)
                    <li class="list-group-item d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                            <img 
                                src="{{ $chat->profile_photo ? asset('profile_photos/' . $chat->profile_photo) : asset('default_profile.png') }}" 
                                alt="{{ $chat->name }}'s Profile" 
                                class="rounded-circle me-3" 
                                style="width: 50px; height: 50px; object-fit: cover;"
                            >
                            <div>
                                <strong>
                                    <a href="{{ route('chat.show', ['user' => $chat->id]) }}" class="text-decoration-none text-dark">
                                        {{ $chat->name }}
                                    </a>
                                </strong>
                                <p class="mb-1 text-muted">Last message: {{ $chat->last_message_content }}</p>
                                <small class="text-muted">Sent at: {{ $chat->last_message_time->format('d M, Y H:i') }}</small>
                            </div>
                        </div>
                        <a href="{{ route('chat.show', ['user' => $chat->id]) }}" class="btn btn-sm btn-outline-primary">Open Chat</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

@endsection
