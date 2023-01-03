<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Post;

class TopicController extends Controller
{
    public function show() {

        $topicId = \request()->topic_id;

        $topic = Topic::withCount('postTopics')->find($topicId);

        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();

        $myposts = Post::belongsToUser(\Auth::id())->notBelongsToTopic($topicId)->get();

        return view('topic/show', compact('topic', 'posts', 'myposts'));
    }

//    public function show(Topic $topic) {
//
//        $topic = Topic::withCount('postTopics')->find($topic->id);
//
////        dd($topic);
//
//        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();
//
////        $myposts = Post::belongsToUser(\Auth::id())->notBelongsToTopic($topicId)->get();
////        $myposts = Post::belongsToUser(\Auth::id())->get();
////        $myposts = \App\Post::NotBelongsToTopic($topic->id)->get();
//
//        $myposts = \App\Post::belongsToUser(\Auth::id())->get();
//
//        dd($myposts);
//
//        return view('topic/show', compact('topic', 'posts', 'myposts'));
//    }

    public function submit(Topic $topic) {
        $this->validate(request(), [
            'post_ids' => 'required|array'
        ]);

        $topic_id = $topic->id;
        $post_ids = request('post_ids');
        foreach($post_ids as $post_id) {
            \App\PostTopic::firstOrCreate(compact('topic_id', 'post_id'));
        }

        return back();
    }
}
