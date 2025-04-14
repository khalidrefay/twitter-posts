@extends('layout')

@section('title') Edit @endsection

@section('content')

    <form method="POST" action="{{route('posts.update', $post->id)}}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" value="{{$post->title}}" class="form-control" >
        </div>
        <div class="mb-3">
            <label  class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{$post->description}}</textarea>
        </div>


        <button class="btn btn-primary">Update</button>
    </form>


@endsection
