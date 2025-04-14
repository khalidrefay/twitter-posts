<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Message;  // Add this line

class ChatController extends Controller
{
    public function showChat(User $user)
    {
        // Ensure the authenticated user isn't trying to chat with themselves
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot chat with yourself.');
        }

        // Retrieve messages between the authenticated user and the user being chatted with
        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', Auth::id());
        })->get();

        return view('chat.show', compact('user', 'messages'));
    }

    public function sendMessage(Request $request, User $user)
    {
        // Validate and save the message
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Store the message in the database (you'll need a Message model)
        // For example:
        $message = new Message([
            'user_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->message,
        ]);
        $message->save();

        // Redirect back to the chat with a success message
        return redirect()->route('chat.show', $user->id)->with('success', 'Message sent!');
    }
}
