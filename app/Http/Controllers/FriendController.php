<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function friendList()
    {
        $user = Auth::user();

        // Retrieve sent and received friend requests
        $receivedRequests = $user->receivedFriendRequests()->where('status', 'pending')->get();
        $sentRequests = $user->sentFriendRequests()->where('status', 'pending')->get();
        $friends = $user->friends()->get();

        // Add followers and following
        $following = $user->followings()->get(); // Users this user is following
        $followers = $user->followers()->get();  // Users following this user

        return view('friends.list', [
            'friends' => $friends,
            'receivedRequests' => $receivedRequests,
            'sentRequests' => $sentRequests,
            'following' => $following,
            'followers' => $followers,
        ]);
    }

    public function acceptRequest($requestId)
    {
        $request = Auth::user()->receivedFriendRequests()->find($requestId);
        if ($request) {
            $request->update(['status' => 'accepted']);
        }
        return redirect()->back()->with('success', 'Friend request accepted!');
    }

    public function declineRequest($requestId)
    {
        $request = Auth::user()->receivedFriendRequests()->find($requestId);
        if ($request) {
            $request->delete();
        }
        return redirect()->back()->with('success', 'Friend request declined.');
    }

    public function cancelRequest($requestId)
    {
        $request = Auth::user()->sentFriendRequests()->find($requestId);
        if ($request) {
            $request->delete();
        }
        return redirect()->back()->with('success', 'Friend request canceled.');
    }

    public function sendRequest($userId)
    {
        $receiver = User::find($userId);

        if (!$receiver) {
            return redirect()->back()->with('error', 'User not found.');
        }

        FriendRequest::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Friend request sent!');
    }

    public function toggleFollow(User $user)
    {
        $currentUser = Auth::user();

        // Check if already following
        if ($currentUser->followings()->where('following_id', $user->id)->exists()) {
            // Unfollow
            $currentUser->followings()->detach($user->id);
            $status = 'follow';
        } else {
            // Follow
            $currentUser->followings()->attach($user->id);
            $status = 'following';
        }

        return response()->json(['status' => $status]);
    }

    public function listFollowRelationships()
    {
        $user = Auth::user();
        $following = $user->followings()->get();
        $followers = $user->followers()->get();

        return view('friends.list', compact('following', 'followers'));
    }

    public function unfollow(User $user)
    {
        Auth::user()->followings()->detach($user->id);
        return redirect()->back()->with('success', 'You have unfollowed ' . $user->name);
    }

    public function removeFollower(User $user)
    {
        Auth::user()->followers()->detach($user->id);
        return redirect()->back()->with('success', $user->name . ' has been removed from your followers');
    }
}
