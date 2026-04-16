<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
class PostController extends Controller
{
     public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts);
    }


   public function store(Request $request)
{
    $request->validate([
        'title' => 'required|min:3|unique:posts,title',
        'content' => 'required|min:10',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = [
        'title' => $request['title'],
        'content' => $request['content'],
        'user_id' => auth()->id(),
    ];

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('posts', 'public');
    }

    Post::create($data);

    return redirect()->route('posts.index');
}

public function show($id)
{
    $post=Post::with('user')->findOrFail(($id));
    return new PostResource($post);
}
  




   
    
}
