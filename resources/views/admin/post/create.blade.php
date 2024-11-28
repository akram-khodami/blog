@extends('theme.admin_theme')
@section('stylesheet')
    <link href="{{ url('css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            ثبت مطلب
        </div>
        <div class="card-body">

            @if (!empty($post))
                <form action="{{ url('posts/' . $post->id, []) }}" method="post" enctype="multipart/form-data">
                    @method('patch')
                @else
                    <form action="{{ url('posts/', []) }}" method="post" enctype="multipart/form-data">
            @endif

            @csrf

            <div class="form-group">
                <label for="title">عنوان</label>
                <input type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder=""
                    name="title" value="{{ old('title', !empty($post->title) ? $post->title : '') }}">
                <small id="titleHelp" class="form-text text-muted">
                    عنوان حداکثر 255 کاراکتر باشد.
                </small>
            </div>

            <div class="form-group">
                <label for="categories">دسته بندی</label>
                <select class="form-control select2" id="categories" name="categories[]" multiple>
                    @if (!empty($categories))
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ !empty($post_categories) ? (in_array($category->id, $post_categories) ? 'selected' : '') : (in_array($category->id, old('categories', [])) ? 'selected' : '') }}>
                                {{ $category->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="tags">تگ ها</label>
                <select class="form-control select2" id="tags" name="tags[]" multiple>
                    @if (!empty($tags))
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ !empty($post_tags) ? (in_array($tag->id, $post_tags) ? 'selected' : '') : (in_array($tag->id, old('tags', [])) ? 'selected' : '') }}>
                                {{ $tag->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="image">تصویر شاخص</label>
                <input type="file" class="form-control" id="image" name="image"
                    value="{{ old('image', !empty($post->image) ? $post->image : '') }}">
            </div>

            <?php if(!empty($post)){ ?>
            <img src="{{ Storage::url($post->image) }}" class="img-thumbnail">
            <?php } ?>

            <div class="form-group">
                <label for="content">متن</label>
                <textarea class="form-control" id="content" rows="10" name="content">{{ old('content', !empty($post->content) ? $post->content : '') }}</textarea>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="published" value="0" name="published"
                    {{ old('published', isset($post) ? $post->published : '') == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="published">ثبت موقت و عدم نمایش در وبلاگ</label>
            </div>

            @if (!empty($post))
                <button type="submit" class="btn btn-outline-warning">ذخیره تغییرات</button>
            @else
                <button type="submit" class="btn btn-primary">ثبت</button>
            @endif

            </form>

        </div>
    </div>
    @if (!empty($post))
        <div class="card mt-1">
            <div class="card-header">
                مدیریت نظرها
            </div>
            <div class="card-body">
                <hr>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" onclick="show_post_comments('{{ $post->id }}','all')">
                        <a class="nav-link" id="all_comments_tab" data-toggle="tab" href="#all_comments" role="tab"
                            aria-controls="all_comments" aria-selected="true">نظرات</a>
                    </li>
                    <li class="nav-item" onclick="show_post_comments('{{ $post->id }}','1')">
                        <a class="nav-link" id="confirmed_comments_tab" data-toggle="tab" href="#confirmed_comments"
                            role="tab" aria-controls="confirmed_comments" aria-selected="false">نظرات تایید شده</a>
                    </li>
                    <li class="nav-item" onclick="show_post_comments('{{ $post->id }}','0')">
                        <a class="nav-link" id="not_confirmed_comments_tab" data-toggle="tab" href="#not_confirmed_comments"
                            role="tab" aria-controls="not_confirmed_comments" aria-selected="false">نظرات تایید نشده</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="all_comments" role="tabpanel" aria-labelledby="all_comments_tab">
                    </div>
                    <div class="tab-pane fade" id="confirmed_comments" role="tabpanel"
                        aria-labelledby="confirmed_comments_tab">
                    </div>
                    <div class="tab-pane fade" id="not_confirmed_comments" role="tabpanel"
                        aria-labelledby="not_confirmed_comments_tab"></div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('external_script')
    <script src="{{ url('js/select2.min.js') }}"></script>
    <script src="{{ url('js/editor/nicEdit.js') }}"></script>
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script type="text/javascript">
        bkLib.onDomLoaded(function() {
            new nicEditor({
                fullPanel: true
            }).panelInstance('content');

        });
        $(document).ready(function() {

            $('.select2').select2();

        });
    </script>
@endsection
