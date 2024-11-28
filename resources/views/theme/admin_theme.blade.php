@include('theme.header')
<div class="container">
    @include('theme.message_box')
    <div class="row mt-1">
        <div class="col-md-2">
            @include('theme.sidebar_menus')
        </div>
        <div class="col-md-10">

            <div class="row">
                <div class="col-md-12 mb-1">
                    <div class="card">
                        <div class="card-header">
                            عملیات
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @yield('operations')
                                {{-- @include('theme.dashboard') --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            {{ $title }}
                        </div>
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

            @yield('modal')
        </div>
    </div>
</div>
@include('theme.footer')
