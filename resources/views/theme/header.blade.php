@php
    $active = isset($active) ? $active : 'home';
@endphp
<!DOCTYPE html>
<html lang="fa">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>{{ empty($title) ? 'وبلاگ من' : $title }}</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/rtl/bootstrap.min.css?v=' . time()) }}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/theme/style.css?v=' . time()) }}">
    <!-- Responsive-->
    <link rel="stylesheet" href="{{ url('css/theme/responsive.css?v=' . time()) }}">
    <!-- fevicon -->
    {{-- <link rel="icon" href="./images/fevicon.png" type="image/gif" /> --}}
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{ url('css/theme/jquery.mCustomScrollbar.min.css?v=' . time()) }}">
    <!-- Tweaks for older IEs-->

    <!-- our project just needs Font Awesome Solid + Brands -->
    <link rel="stylesheet" href="{{ url('fontawesome/css/fontawesome.min.css?v=' . time()) }}">
    <link rel="stylesheet" href="{{ url('fontawesome/css/brands.css?v=' . time()) }}">
    <link rel="stylesheet" href="{{ url('fontawesome/css/solid.css?v=' . time()) }}">

    <!-- owl stylesheets -->
    {{-- <link rel="stylesheet" href="{{ url('css/theme/owl.carousel.min.css') }}"> --}}
    <link rel="stylesoeet" href="{{ url('css/theme/owl.theme.default.min.css?v=' . time()) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">

    @yield('stylesheet')
    <script type="text/javascript">
        var APP_URL = "{{ url('/') }}";
    </script>
</head>

<body>
    <!-- header section start -->
    <div class="header_section">
        <div class="container-fluid header_main">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="logo" href="index.html"><img src="{{ url('images/logo.png') }}" width="50px"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button class="nav-link btn-link">خروج</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $active == 'profile' ? 'active' : '' }}"
                                        href="{{ url('profile', []) }}">پروفایل</a>
                                </li>

                                @can('manage-posts', App\Models\Post::class)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('posts', []) }}">میزکار</a>
                                    </li>
                                @endcan
                            @else
                                <li class="nav-item">
                                    <a class="nav-link  {{ $active == 'login' ? 'active' : '' }}"
                                        href="{{ url('login', []) }}">ورود</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link  {{ $active == 'register' ? 'active' : '' }}"
                                            href="{{ route('register') }}">ثبت نام</a>
                                    </li>
                                @endif
                            @endauth

                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ $active == 'home' ? 'active' : '' }}"
                                href="{{ url('/', []) }}">خانه</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ $active == 'blog' ? 'active' : '' }}"
                                href="{{ url('blog/posts', []) }}">بلاگ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $active == 'about' ? 'active' : '' }}"
                                href="{{ url('page/about', []) }}">درباره ما</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('page/contact', []) }}">ارتباط با ما</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><img src="{{ url('images/serach-icon.png') }}"></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- banner section start -->
        @yield('banner_slider')
        <!-- banner section end -->
    </div>
    <!-- header section end -->
