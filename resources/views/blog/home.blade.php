@extends('theme.blog_theme')
@section('content')
@section('banner_slider')
    <div class="container-fluid">
        <div class="banner_section layout_padding">
            <h1 class="banner_taital">خوش آمدید </h1>
            <div id="my_slider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @if (!empty($slider1))
                        @foreach ($slider1 as $key => $value)
                            <div class="carousel-item {{ $key == 1 ? 'active' : '' }}">
                                <div class="image_main">
                                    <div class="container">
                                        <img src="{{ $value->image }}" class="image_1">
                                        <div class="contact_bt"><a href="contact.html">{{ $value->title }}</a></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

<div class="container">
    <div class="touch_setion">
        <div class="box_main">
            <div class="image_2 active">
                <h4 class="who_text active">درباره من</h4>
            </div>
        </div>
        <div class="box_main">
            <div class="image_3">
                <h4 class="who_text">در تماس باشید</h4>
            </div>
        </div>
        <div class="box_main">
            <div class="image_4">
                <h4 class="who_text">شبکه های اجتماعی</h4>
            </div>
        </div>
    </div>
</div>

<!-- about section start -->
@if (!empty($posts1))
    @foreach ($posts as $post)
        <div class="about_section layout_padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="about_img"><img src="images/about-img.png"></div>
                        <div class="like_icon"><img src="images/like-icon.png"></div>
                        <p class="post_text">
                            {{ 'نوشته شده توسط ' . ':' . $post->user->name . ' ' . $post->created_at }}
                        </p>
                        <h2 class="most_text">{{ $post->title }}</h2>
                        <p class="lorem_text">
                            {{ $post->content }}
                        </p>
                        <div class="social_icon_main">
                            <div class="social_icon">
                                <ul>
                                    <li><a href="#"><img src="images/fb-icon.png"></a></li>
                                    <li><a href="#"><img src="images/twitter-icon.png"></a></li>
                                    <li><a href="#"><img src="images/instagram-icon.png"></a></li>
                                </ul>
                            </div>
                            <div class="read_bt"><a href="#">مطالعه بیشتر</a></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="image_5"><img src="images/img-5.png"></div>
                        <h1 class="about_taital">درباره ما</h1>
                        <p class="about_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>
                        <div class="read_bt_1"><a href="#">مطالعه بیشتر</a></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
<!-- about section end -->
<!-- blog section start -->

<div class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                @if (!empty($posts))
                    @foreach ($posts as $post)
                        <div class="about_img"><img src="{{ Storage::url($post->image) }}"></div>
                        <div class="like_icon"><img src="{{ url('images/like-icon.png') }}"></div>
                        <p class="post_text">
                        <p class="post_text">
                            {{ 'نوشته شده توسط ' . ':' . $post->user->name . ' ' . $post->created_at }}
                        </p>
                        <small dir="ltr" class="">
                            <?php
                            $date = \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($post->created_at));
                            echo \Morilog\Jalali\CalendarUtils::convertNumbers($date);
                            ?>
                        </small>
                        </p>
                        <h2 class="most_text">
                            <a href="{{ url('blog/posts/' . $post->id) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="lorem_text">
                            @if (strlen($post->content) > 1000)
                                {!! substr($post->content, 0, 1000) !!}
                            @else
                                {!! $post->content !!}
                            @endif
                        </p>
                        <div class="social_icon_main">
                            <div class="social_icon">
                                <ul>
                                    <li><a href="#"><img src="{{ url('images/fb-icon.png', []) }}"></a></li>
                                    <li><a href="#"><img src="{{ url('images/twitter-icon.png') }}"></a></li>
                                    <li><a href="#"><img src="{{ url('images/instagram-icon.png') }}"></a></li>
                                </ul>
                            </div>
                            @if (strlen($post->content) > 1000)
                                <div class="read_bt">
                                    <a href="{{ url('blog/posts/' . $post->id) }}">مطالعه بیشتر</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif

            </div>
            <div class="col-lg-4 col-sm-12">
                @include('blog.post.categories_list')
                @include('theme.follow_icon')
            </div>
        </div>
    </div>
</div>

<!-- tag section start -->
@if (!empty($tags))
    <div class="tag_section layout_padding">
        <div class="container">
            <h1 class="tag_taital">برچسب ها</h1>
            <div class="tag_bt">
                <ul>
                    @foreach ($tags as $tag)
                        <li><a href="#">{{ $tag->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
<!-- tag section end -->
<!-- contact section start -->
<div class="contact_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @for ($i = 1; $i < count($slider2) + 1; $i++)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}"
                                class="{{ $i == 1 ? 'active' : '' }}"
                                style="text-indent: 0; border: none; color: #000; font-size: 18px; text-align: center;">
                                {{ $i }}
                            </li>
                        @endfor
                    </ol>
                    <div class="carousel-inner">
                        @if (!empty($slider2))
                            @foreach ($slider2 as $key => $value)
                                <div class="carousel-item {{ $key == 1 ? 'active' : '' }}">
                                    <div class="contact_img">
                                        <img src="{{ $value->image }}" class="image_1">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mail_section">
                    <h1 class="contact_taital">ارتباط با ما</h1>
                    <input type="" class="email_text" placeholder="نام" name="Name">
                    <input type="" class="email_text" placeholder="تلفن" name="Phone">
                    <input type="" class="email_text" placeholder="ایمیل" name="Email">
                    <textarea class="massage_text" placeholder="پیام" rows="5" id="comment" name="Message"></textarea>
                    <div class="send_bt"><a href="#">ارسال</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contact section end -->
@endsection
