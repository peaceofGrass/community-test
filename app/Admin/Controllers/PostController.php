<?php

namespace App\Admin\Controllers;

use App\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::withoutGlobalScope('available')
            ->where('status', 0)
            ->orderby('created_at', 'desc')
            ->paginate(10);
        return view('admin.post.index', compact('posts'));
    }

    public function status(Post $post) {
        $this->validate(request(), [
            'status' => 'required|in:1,-1'
        ]);

        $post->status = request('status');
        $post->save();

        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}