@extends("layout.main")
@section("content")
<div class="col-sm-8 blog-main">
    <div class="blog-post">
        <div style="display:inline-flex">
            <h2 class="blog-post-title">{{$post->title}}</h2>
            @can('update', $post)
            <a style="margin: auto"  href="/posts/{{$post->id}}/edit">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            @endcan
{{--            <form action="/posts/{{$post->id}}/delete" method="POST">--}}
{{--                {{method_field("DELETE")}}--}}
{{--                {{csrf_field()}}--}}
{{--                <button><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>--}}
{{--            </form>--}}
            @can('delete', $post)
            <a style="margin: auto"  href="/posts/{{$post->id}}/delete">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </a>
            @endcan
        </div>

        <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by
            <a href="#">{{ $post->user->name  }}</a>
        </p>

        <p>{!!$post->content!!}</p>
        <div>
            @if ($post->like(\Auth::id())->exists())
            <a href="/posts/{{$post->id}}/unlike" type="button" class="btn btn-primary btn-lg">取消赞</a>
            @else
            <a href="/posts/{{$post->id}}/like" type="button" class="btn btn-default btn-lg">赞</a>
            @endif
        </div>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">评论</div>

        <!-- List group -->
        <ul class="list-group">
            @foreach($post->comments as $comment)
            <li class="list-group-item">
                <h5>{{$comment->created_at}} by {{$comment->user->name}}
                    @if ($comment->user->id == \Auth::id())
                    <a href="/comment/{{$comment->id}}/delete">삭제</a>
                    @endif
                </h5>
                <div>
                    {{$comment->content}}
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">发表评论</div>

        <!-- List group -->
        <ul class="list-group">
            <form action="/posts/{{$post->id}}/comment" method="post">
                {{csrf_field()}}
{{--                <input type="hidden" name="post_id" value="62"/>--}}
                <li class="list-group-item">
                    <textarea name="content" class="form-control" rows="10"></textarea>

                    <button class="btn btn-default" type="submit">提交</button>
                </li>
            </form>

        </ul>
        @include('layout.error')
    </div>

</div><!-- /.blog-main -->
@endsection