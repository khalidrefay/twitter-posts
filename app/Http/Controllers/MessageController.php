<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function send(Request $request, User $user)
    {
        // Validate the message input
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Save the message
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->message,
        ]);

        // Redirect back to the chat page with a success message
        return redirect()->route('chat.show', ['user' => $user->id])->with('success', 'Message sent!');
    }

    

    public function index()
{
    // Get unique users who have sent or received messages with the authenticated user
    $sentMessages = Message::where('sender_id', Auth::id())->get();
    $receivedMessages = Message::where('receiver_id', Auth::id())->get();

    // Merge the sent and received messages to get unique users
    $userIds = $sentMessages->pluck('receiver_id')->merge($receivedMessages->pluck('sender_id'))->unique();

    // Fetch the user data for those users (excluding the logged-in user)
    $chats = User::whereIn('id', $userIds)->where('id', '!=', Auth::id())->get()->map(function($user) use ($sentMessages, $receivedMessages) {
        // Find the last message exchanged with this user
        $lastMessage = $sentMessages->where('receiver_id', $user->id)->last() ?? 
                       $receivedMessages->where('sender_id', $user->id)->last();

        // Add the last message content and time to the user data
        $user->last_message_content = $lastMessage ? $lastMessage->content : 'No messages';
        $user->last_message_time = $lastMessage ? $lastMessage->created_at : now();

        return $user;
    });

    return view('messages.index', compact('chats'));
}
}
