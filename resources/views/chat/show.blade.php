@extends('layout')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Chat with {{ $user->name }}</h1>

    <!-- Chat Box -->
    <div id="chat-box" class="border rounded p-3 mb-4" style="height: 400px; overflow-y: scroll; background-color: #f8f9fa;">
        @if($messages->isEmpty())
            <p class="text-muted text-center">No messages yet. Start the conversation!</p>
        @else
            @foreach ($messages as $message)
                <div class="message mb-3 {{ $message->sender_id === Auth::id() ? 'text-end' : '' }}">
                    <div class="d-inline-block p-3 rounded {{ $message->sender_id === Auth::id() ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="max-width: 70%;">
                        <strong>{{ $message->sender->name }}:</strong>
                        <p class="mb-0">{{ $message->content }}</p>
                        <small class="d-block text-muted mt-1">{{ $message->created_at->format('d M, Y H:i') }}</small>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Message Input Form -->
    <form action="{{ route('messages.send', ['user' => $user->id]) }}" method="POST" class="d-flex">
        @csrf
        <textarea name="message" class="form-control me-2" rows="1" placeholder="Type a message..." required></textarea>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>
@endsection
