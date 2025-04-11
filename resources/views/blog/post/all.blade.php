@extends('theme.blog_theme')
@section('content')
    <!-- blog section start -->
    <div class="about_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    @if (!empty($posts))
                        @foreach ($posts as $post)
                            <div class="mt-5 mb-5">
                                <div class="about_img"><img src="{{ asset('upload/images/'.$post->image) }}"></div>
                                <div class="like_icon"><img src="{{ url('images/like-icon.png') }}"></div>
                                <p class="post_text">
                                    <small class="">
                                        {{ ' نوشته شده توسط: ' . $post->user->name . '  ' }}
                                    </small>
                                    <small dir="ltr" class="">
                                        @jalali($post->created_at)
                                    </small>
                                </p>
                                <h2 class="most_text">
                                    <a href="{{ url('blog/posts/' . $post->id) }}">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                <p class="lorem_text"> {!! $post->content !!}</p>
                                <div class="social_icon_main">
                                    <div class="social_icon">
                                        <ul>
                                            <li><a href="#"><img src="{{ url('images/fb-icon.png', []) }}"></a></li>
                                            <li><a href="#"><img src="{{ url('images/twitter-icon.png') }}"></a></li>
                                            <li><a href="#"><img src="{{ url('images/instagram-icon.png') }}"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    @if (strlen($post->content) > 1000)
                                        <div class="read_bt">
                                            <a href="{{ url('blog/posts/' . $post->id) }}">مطالعه بیشتر</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 col-sm-12">
                    @include('blog.post.categories_list')
                    @include('theme.follow_icon')
                </div>
            </div>
        </div>
    </div>
    <!-- blog section end -->
@endsection
