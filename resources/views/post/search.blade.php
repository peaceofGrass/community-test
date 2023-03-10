@extends('layout.main')
@section('content')

    <div class="alert alert-success" role="alert">
{{--        下面是搜索"中国"出现的文章，共{{count($posts)}}条--}}
        下面是搜索"中国"出现的文章，共{{$posts->total()}}条
    </div>
    <div class="col-sm-8 blog-main">

        @foreach ($posts as $post)
        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/posts/{{$post->id}}" >{{$post->title}}</a></h2>
            <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by <a href="#">{{$post->user->name}}</a></p>

            {!! str_limit($post->content, 200, '...') !!}
        </div>
        @endforeach
    </div>
    {{$posts->appends(['query' => $query])->links()}}
@endsection