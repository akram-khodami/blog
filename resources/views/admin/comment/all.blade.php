@extends('theme.admin_theme')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12 col-sm-12">
            @php $confirmed = request('confirmed'); @endphp

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?= !in_array($confirmed, [0, 1]) ? 'active' : '' ?>" id="all_comments_tab"
                        href="{{ url('comments?confirmed=all') }}" role="tab" aria-controls="all_comments"
                        aria-selected="true">نظرات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $confirmed == 1 ? 'active' : '' ?>" id="confirmed_comments_tab"
                        href="{{ url('comments?confirmed=1') }}" role="tab" aria-controls="confirmed_comments"
                        aria-selected="false">نظرات تایید شده
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $confirmed == 0 ? 'active' : '' ?>" id="not_confirmed_comments_tab"
                        href="{{ url('comments?confirmed=0') }}" role="tab" aria-controls="not_confirmed_comments"
                        aria-selected="false">نظرات تایید نشده</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?= !in_array($confirmed, [0, 1]) ? 'show active' : '' ?>" id="all_comments"
                    role="tabpanel" aria-labelledby="all_comments_tab">
                    @if (!in_array($confirmed, [0, 1]))
                        @include('admin.post.post_comments')
                    @endif
                </div>
                <div class="tab-pane fade <?= $confirmed == 1 ? 'show active' : '' ?>" id="confirmed_comments"
                    role="tabpanel" aria-labelledby="confirmed_comments_tab">
                    @if ($confirmed == 1)
                        @include('admin.post.post_comments')
                    @endif
                </div>
                <div class="tab-pane fade <?= $confirmed == 0 ? 'show active' : '' ?>" id="not_confirmed_comments"
                    role="tabpanel" aria-labelledby="not_confirmed_comments_tab">
                    @if ($confirmed == 0)
                        @include('admin.post.post_comments')
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
@section('external_script')
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script></script>
@endsection
