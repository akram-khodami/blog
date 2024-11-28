@include('theme.header')
<div class="container mb-1">
    @include('theme.message_box')
    <div class="row">
        <div class="col-md-12">
            @yield('content')
        </div>
    </div>
</div>
@include('theme.footer')
