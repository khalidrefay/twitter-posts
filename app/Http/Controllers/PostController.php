<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Import Auth once

class PostController extends Controller
{
    public function index()
    {
        $postsFromDB = Post::all(); // Collection object
        return view('posts.index', ['posts' => $postsFromDB]);
        return view('welcome', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', ['users' => $users]);
    }

    public function store()
{
    // Validate input
    $validated = request()->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle the image upload if exists
    if (request()->hasFile('image')) {
        $imageName = time() . '.' . request()->image->extension();
        request()->image->move(public_path('images/posts'), $imageName);
        $validated['image'] = $imageName;
    }

    // Create the post
    Post::create([
        'title' => request()->title,
        'description' => request()->description,
        'user_id' => Auth::id(),
        'image' => $validated['image'] ?? null,
    ]);

    return redirect()->route('posts.index')->with('success', 'Post created successfully!');
}

    public function edit(Post $post)
    {
        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to edit this post.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update($postId)
    {
        // Validate the data
        request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:5'],
        ]);

        // Find the post
        $post = Post::findOrFail($postId); // This will throw a 404 if not found

        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to edit this post.');
        }

        // Update the post data
        $post->update([
            'title' => request()->title,
            'description' => request()->description, // Corrected typo here
        ]);

        return to_route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($postId)
    {
        $post = Post::findOrFail($postId); // This will throw a 404 if not found

        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to delete this post.');
        }

        $post->delete(); // Delete the post

        return to_route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
