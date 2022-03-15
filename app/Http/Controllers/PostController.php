<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
     public function __construct()
     {
          $this->middleware('auth')->except(['list', 'show']);
     }

     public function list()
     {
          $posts = Post::orderByDesc('created_at')
               ->with('user')
               ->paginate(5);
          return view('posts.list', ['posts' => $posts]);
     }

     public function create()
     {
          return view('posts.create');
     }

     public function store(Request $request)
     {
          $data = $request->validate([
               'title' => ['required', 'string', 'max:100'],
               'content' => ['required', 'string', 'max:400'],
               'user_id' => ['integer', Rule::exists('users', 'id')]
          ]);

          Post::create($data);
          return redirect()->route('posts')->with('status', '投稿完了');
     }

     public function show(Post $post)
     {
          return view('posts.show', ['post' => $post]);
     }

     public function edit(Post $post)
     {
          return view('posts.edit', ['post' => $post]);
     }

     public function update(Request $request, Post $post)
     {
          $this->authorize('edit', $post);
          $data = $request->validate([
               'title' => ['required', 'string', 'max:100'],
               'content' => ['required', 'string', 'max:400'],
               'user_id' => ['integer', Rule::exists('users', 'id')]
          ]);

          $post->update($data);
          return redirect()->route('posts')->with('status', '編集完了');
     }

     public function destroy(Post $post)
     {
          $this->authorize('edit', $post);
          $post->delete();
          return redirect()->route('posts')->with('status', '削除完了');
     }
}
