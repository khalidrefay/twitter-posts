<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Add this line to import the User model
class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateProfilePhoto(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::user();

    // Store the uploaded photo
    if ($request->hasFile('profile_photo')) {
        $filename = time() . '.' . $request->profile_photo->extension();
        $request->profile_photo->move(public_path('profile_photos'), $filename);

        // Update user profile photo path
        $user->profile_photo = $filename;
        $user->save();
    }

    return redirect()->route('profile')->with('success', 'Profile photo updated successfully.');
}

public function showProfile($id)
{
    $user = User::with('posts')->findOrFail($id); // Fetch user and their posts

    return view('profileshow', compact('user'));
}




}
