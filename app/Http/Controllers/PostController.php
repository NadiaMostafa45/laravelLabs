<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
   
    public function index()
    {
        $posts = [
            ['id' => 1, 'title' => 'First Post', 'content' => 'Content 1'],
            ['id' => 2, 'title' => 'Second Post', 'content' => 'Content 2'],
            ['id' => 3, 'title' => 'Third Post', 'content' => 'Content 3'],
        ];

        return view('posts.index', compact('posts'));
    }

 
    public function create()
    {
        return view('posts.create');
    }

   
    public function store(Request $request)
    {
        
        return redirect()->route('posts.index');
    }

 
    public function edit($id)
    {
        $posts = [
            ['id' => 1, 'title' => 'First Post', 'content' => 'Content 1'],
            ['id' => 2, 'title' => 'Second Post', 'content' => 'Content 2'],
            ['id' => 3, 'title' => 'Third Post', 'content' => 'Content 3'],
        ];

        $post = collect($posts)->firstWhere('id', $id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('posts.index');
    }

  
    public function destroy($id)
    {
        return redirect()->route('posts.index');
    }
}