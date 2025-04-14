@extends('layout') 

@section('title') Create Post @endsection

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Create a New Post</h1>

    <!-- Display Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Post Creation Form -->
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light">
        @csrf

        <!-- Title Input -->
        <div class="mb-3">
            <label for="title" class="form-label"><strong>Title</strong></label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="form-control" 
                placeholder="Enter the post title" 
                value="{{ old('title') }}" 
                required>
        </div>

        <!-- Description Input -->
        <div class="mb-3">
            <label for="description" class="form-label"><strong>Description</strong></label>
            <textarea 
                name="description" 
                id="description" 
                class="form-control" 
                rows="4" 
                placeholder="Write the post description here..." 
                required>{{ old('description') }}</textarea>
        </div>

        <!-- Image Upload Input -->
        <div class="mb-3">
            <label for="image" class="form-label"><strong>Upload Image</strong></label>
            <input 
                type="file" 
                name="image" 
                id="image" 
                class="form-control" 
                accept="image/*">
            <small class="form-text text-muted">Optional: Upload an image for your post (e.g., PNG, JPG).</small>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-success px-4">Submit</button>
        </div>
    </form>
</div>
@endsection
