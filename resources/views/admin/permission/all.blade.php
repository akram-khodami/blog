@extends('theme.admin_theme')
@section('content')

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

    @if (!empty($permission))
        <button type="submit" class="btn btn-outline-warning btn-sm">ذخیره تغییرات</button>
        <a href="{{ url('permissions') }}" class="btn btn-outline-danger btn-sm">انصراف</a>
    @else
        <button type="submit" class="btn btn-primary btn-sm">ثبت</button>
    @endif

    </form>

    <hr>

    <div class="table-responsive">
        @if (!empty($permissions))
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($permissions as $permission)
                        <tr id="tr{{ $permission->id }}">
                            <td>{{ $i }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <i class="btn fa fa-trash-alt text-danger"
                                    onclick="deletePermission({{ $permission->id }})"></i>

                                <a href="{{ url('permissions/' . $permission->id . '/edit') }}">
                                    <i class="btn fa fa-pencil-alt text-warning"></i>
                                </a>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            {{ $permissions->links() }}
        @endif
    </div>
@endsection
@section('external_script')
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script></script>
@endsection
