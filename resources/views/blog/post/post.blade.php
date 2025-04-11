@extends('theme.blog_theme')
@section('content')
    <!-- blog section start -->
    <div class="about_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-12">
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
                    <h2 class="most_text">{{ $post->title }}</h2>
                    <p class="lorem_text"> {!! $post->content !!}</p>
                </div>
                <div class="col-lg-4 col-sm-12">
                    @include('blog.post.recent_posts')
                    @include('blog.post.categories_list')
                    @include('theme.follow_icon')
                </div>
            </div>

            <div class="row d-flex justify-content-center">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            ثبت نظر
                        </div>
                        <div class="card-body mb-5">
                            @auth
                                <form action="{{ url('blog/comment', []) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                                    <div class="form-group">
                                        <label class="form-label" for="name">نام</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ Auth::user()->name }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="email">
                                            <i class="fa fa-envelope"></i>&nbsp;ایمیل
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ Auth::user()->email }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="content">متن نظر</label>
                                        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-sm" value="ثبت نظر">
                                </form>
                                <small>نظر شما در مورد این مطلب پس از تایید نویسنده وبلاگ نمایش داده خواهد شد</small>
                            @else
                                <small>برای درج نظر ابتدا وارد حساب وارد شوید</small>
                                <div>
                                    <a href="{{ url('login') }}" class="btn btn-info btn-sm">ثبت نظر</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                    <div class="card text-body mt-1">
                        <div class="card-header">
                            نظرات کاربران
                        </div>
                        <div class="card-body mb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    @if (!empty($comments))
                                        @foreach ($comments as $comment)
                                            <div class="card text-body mt-1">
                                                <div class="card-body mb-5">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p>{{ $comment->content }}</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="d-flex flex-row align-items-center">
                                                                    <p class="small mb-0 ms-2">{{ $comment->name }}
                                                                        <small dir="ltr" class="">
                                                                            <?php
                                                                            $date2 = \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($comment->created_at));
                                                                            echo ' [ تاریخ' . \Morilog\Jalali\CalendarUtils::convertNumbers($date2) . ' ]'; ?>

                                                                        </small>
                                                                    </p>
                                                                    <p class="small text-muted mb-0">موافقید?</p>
                                                                    <i class="far fa-thumbs-up mx-2 fa-xs text-body"
                                                                        style="margin-top: -0.16rem;"></i>
                                                                    <p class="small text-muted mb-0">3</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-sm-12"></div>
            </div>
        </div>
    </div>
    <!-- blog section end -->
@endsection
