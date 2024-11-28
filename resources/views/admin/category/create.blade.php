<div class="card mb-1">
    <div class="card-header">
        ثبت
    </div>
    <div class="card-body">

        @if (!empty($category))
            <form action="{{ url('categories/' . $category->id, []) }}" method="post" enctype="multipart/form-data">
                @method('patch')
            @else
                <form action="{{ url('categories/', []) }}" method="post" enctype="multipart/form-data">
        @endif

        @csrf

        <div class="form-group">
            <label for="title">عنوان</label>
            <input type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder=""
                name="title" value="{{ old('title', !empty($category->title) ? $category->title : '') }}">
            <small id="titleHelp" class="form-text text-muted">
                عنوان حداکثر 255 کاراکتر باشد.
            </small>
        </div>

        @if (!empty($category))
            <button type="submit" class="btn btn-outline-warning">ذخیره تغییرات</button>
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