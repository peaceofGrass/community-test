<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Comment;
use App\Like;
use Illuminate\Contracts\Test\Testechoservice;
use Illuminate\Support\Facades\TestechoFacade;

class PostController extends Controller
{
    public function index() {
//        echo phpinfo();
//        exit;
//        $log = app()->make('log');
//        $log->info('hahaha', ['a' => 'aa']);
//
//        \Log::info('haha', ['b' => 'bb']);
//        var_dump($_COOKIE);

//        \Log::info('aaa');
//
//        \Testecho::show();
//        echo "<br>";
//        TestechoFacade::show();
//        echo "<br>";
//        app('testecho')->show();
//        echo "<br>";
//        $aa = new Testechoservice;
//        $aa->show();


//        var_dump(\Auth::viaRemember());

        $posts = Post::orderBy('created_at', 'desc')
            ->withCount(['comments', 'likes'])
//            ->with('user')
            ->paginate(5);

        $posts->load('user');

        return view('post/index', compact('posts'));
    }

    public function search() {
        $this->validate(request(), [
            'query' => 'required'
        ]);

        $query = request('query');
        $post = new Post();
//        $posts = $post->search($query)->paginate(10);
        $posts = $post->search($query);

        return view('/post/search', compact('posts', 'query'));
    }

    public function show(Post $post) {
        $post->load('comments');
//        dd($post);
//        $post = $post::with('comments')->get(); 포스트 리스트에 코멘트가 따라붙음
//        $comments = $post->comments;
//        dd($comments);
        return view('post/show', compact(['post']));
    }

    public function create() {
        return view('post/create');
    }

    public function store() {
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:3',
            'content' => 'required|string|min:5'
        ]);

        $params = request(["title", "content"]);
        $params['user_id'] = \Auth::id();
        Post::create($params);

        return redirect("/posts");
    }

    public function edit(Post $post, User $user) {
//        $this->authorize('update', $post);
//        dd(\Auth::user());
        if (!\Auth::user()->can('update', $post)) {
            return alertThenRedirect('안돼!');
        }
        return view('post/edit', compact('post'));
    }

    public function update(Post $post) {
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:3',
            'content' => 'required|string|min:5'
        ]);

//        $this->authorize('update', $post);
        if (!\Auth::user()->can('update', $post)) {
            return alertThenRedirect('안돼!');
        }

        $post->title = request('title');
        $post->content = request('content');
        $post->save();

//        return redirect('/posts/' . $post->id);
        return redirect("/posts/{$post->id}");
    }

    public function delete(Post $post) {
//        $this->authorize('update', $post);

        if (!\Auth::user()->can('update', $post)) {
            return alertThenRedirect('안돼!');
        }

        $post->delete();
        return redirect("/posts");
    }

    public function imageUpload(Request $request) {
//        dd(\request()->all());
//        return 'aaa';
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
    }

    public function comment(Post $post) {
        $this->validate(request(), [
            'content' => 'required|min:5'
        ]);

        $comment = new Comment;
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        $post->comments()->save($comment);

        return back();
    }

    public function commentDelete(Comment $comment) {
        $comment->delete();
        return back();
    }

    public function like(Post $post) {
        $param = [
            'user_id' => \Auth::id(),
            'post_id' => $post->id
        ];
        Like::firstOrCreate($param);
        return back();
    }

    public function unlike(Post $post) {
        $post->like(\Auth::id())->delete();
        return back();
    }
}
