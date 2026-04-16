<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{


    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }


    public function create()
    {
        return view('posts.create');
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


    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts,title,' . $post->id,
            'content' => 'required|min:10',
        ]);
        $post->update($request->all());
        return redirect()->route('posts.index');
    }


    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('posts.index');
    }
    public function restore(Post $post, $id)
    {
        Post::withoutTrashed()->find($id)->restore();
        return redirect()->route('posts.index');
    }
}