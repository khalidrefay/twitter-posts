<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){

        $posts = Post::get();
        $msg = ['oK'];

        return response($posts, 200, $msg);
    }
    //
}
