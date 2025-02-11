<div class="card">
    <div class="card-header">
        ثبت
    </div>
    <div class="card-body">

        @if (!empty($tag))
            <form action="{{ url('tags/' . $tag->id, []) }}" method="post" enctype="multipart/form-data">
                @method('patch')
            @else
                <form action="{{ url('tags/', []) }}" method="post" enctype="multipart/form-data">
        @endif

        @csrf

        <small> {{ !empty($tag->title) ? 'عنوان ذخیره شده قبلی:' . $tag->title : '' }} </small>

        <div class="form-group">
            <label for="title">عنوان</label>
            <input type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder=""
                name="title" value="{{ old('title', !empty($tag->title) ? $tag->title : '') }}">
            <small id="titleHelp" class="form-text text-muted">
                عنوان حداکثر 255 کاراکتر باشد.
            </small>
        </div>

        @if (!empty($tag))
            <button type="submit" class="btn btn-warning btn-sm">ذخیره تغییرات</button>
            <a href="{{ url('tags') }}" class="btn btn-danger btn-sm">انصراف</a>
        @else
            <button type="submit" class="btn btn-primary">ثبت</button>
        @endif

        </form>

    </div>
</div>
@section('external_script')
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script></script>
@endsection
