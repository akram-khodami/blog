@if (!empty($permission))
    <form action="{{ url('permissions/' . $permission->id) }}" method="post">
        @method('patch')
    @else
        <form action="{{ url('permissions') }}" method="post">
@endif

@csrf
<div class="form-group">
    <label for="name">عنوان</label>
    <input type="text" name="name" id="name" class="form-control"
        value="{{ old('name', isset($permission->name) ? $permission->name : '') }}">
</div>

<div class="form-group">
    <label for="ability">قابلیت</label>
    <input type="text" name="ability" id="ability" class="form-control"
        value="{{ old('ability', isset($permission->ability) ? $permission->ability : '') }}">
</div>

<div class="form-group">
    <label for="description">توضیحات</label>
    <textarea name="description" id="description" class="form-control">{{ old('description', isset($permission->description) ? $permission->description : '') }}</textarea>
</div>

@if (!empty($permission))
    <button type="submit" class="btn btn-outline-warning btn-sm">ذخیره تغییرات</button>
    <a href="{{ url('permissions') }}" class="btn btn-outline-danger btn-sm">انصراف</a>
@else
    <button type="submit" class="btn btn-primary btn-sm">ثبت</button>
@endif

</form>
