@extends("layout.main")
@section("content")
<div class="col-sm-8 blog-main">
    <div>
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example" data-slide-to="1"></li>
                <li data-target="#carousel-example" data-slide-to="2"></li>
            </ol><!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
{{--                    <img src="http://ww1.sinaimg.cn/large/44287191gw1excbq6tb3rj21400migrz.jpg" alt="..." />--}}
                    <img src="https://cdn.pixabay.com/photo/2015/03/28/16/40/lake-696098_960_720.jpg" />
                    <div class="carousel-caption">...</div>
                </div>
                <div class="item">
                    <img src="https://cdn.pixabay.com/photo/2014/10/07/13/48/mountain-477832_960_720.jpg" alt="..." />
                    <div class="carousel-caption">...</div>
                </div>
                <div class="item">
                    <img src="https://cdn.pixabay.com/photo/2017/08/01/01/17/beach-2562563_960_720.jpg" alt="..." />
                    <div class="carousel-caption">...</div>
                </div>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span></a>
            <a class="right carousel-control" href="#carousel-example" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
    </div>        <div style="height: 20px;">
    </div>
    <div>

        @foreach($posts as $post)
        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/posts/{{$post->id}}" >{{$post->title}}</a></h2>
            <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by <a href="/user/{{$post->user->id}}">{{$post->user->name}}</a></p>

            {!! str_limit(strip_tags($post->content), 100, '...') !!}
            <p class="blog-post-meta">??? {{$post->likes_count}}  | ?????? {{$post->comments_count}}</p>
        </div>
        @endforeach

        {{$posts->links()}}

    </div><!-- /.blog-main -->
</div>
@endsection