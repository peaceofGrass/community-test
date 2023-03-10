<div class="blog-masthead">
    <div class="container">
        <form action="/posts/search" method="GET">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <a class="blog-nav-item " href="/posts">首页</a>
            </li>
            <li>
                <a class="blog-nav-item" href="/posts/create">写文章</a>
            </li>
            <li>
                <a class="blog-nav-item" href="/notices">通知</a>
            </li>
            <li>
                <input name="query" type="text" value="@if(!empty($query)){{$query}}@endif" class="form-control" style="margin-top:10px" placeholder="搜索词">
            </li>
            <li>
                <button class="btn btn-default" style="margin-top:10px" type="submit">Go!</button>
            </li>
        </ul>
        </form>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <div>
                    @if (\Auth::check())
                        <img src="{{\Auth::user()->avatar}}" alt="" class="img-rounded" style="border-radius:500px; height: 30px">
                        <a href="#" class="blog-nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ \Auth::user()->name }}
                        </a>
                        <span class="caret"></span>
                        <ul class="dropdown-menu">
                            <li><a href="/user/{{ \Auth::user()->id }}">我的主页</a></li>
                            <li><a href="/user/me/setting">个人设置</a></li>
                            <li><a href="/logout">登出</a></li>
                        </ul>
                    @else
                        <a href="/login" class="blog-nav-item dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">
                            登录
                        </a>
                    @endif
                </div>
            </li>
        </ul>
    </div>
</div>