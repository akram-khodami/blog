@extends('theme.admin_theme')
@section('content')
    @if (!empty($role))
        <form action="{{ url('roles/' . $role->id) }}" method="post">
            @method('patch')
        @else
            <form action="{{ url('roles') }}" method="post">
    @endif

    @csrf
    <div class="form-group">
        <label for="name">عنوان</label>
        <input type="text" name="name" id="name" class="form-control"
            value="{{ old('name', isset($role->name) ? $role->name : '') }}">
    </div>
    <div class="form-group">
        @if (!empty($role))
            <button type="submit" class="btn btn-outline-warning btn-sm">ذخیره تغییرات</button>
            <a href="{{ url('roles') }}" class="btn btn-outline-danger btn-sm">انصراف</a>
        @else
            <button type="submit" class="btn btn-primary btn-sm">ثبت</button>
        @endif
    </div>
    </form>

    <hr>

    <div class="table-responsive">
        @if (!empty($roles))
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
                    @foreach ($roles as $role)
                        <tr id="tr{{ $role->id }}">
                            <td>{{ $i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <i class="btn fa fa-trash-alt text-danger" onclick="deleteRole({{ $role->id }})"></i>

                                <a href="{{ url('roles/' . $role->id . '/edit') }}">
                                    <i class="btn fa fa-pencil-alt text-warning"></i>
                                </a>

                                <a href="{{ url('roles/' . $role->id) }}" title="اجازه ها">

                                    <i class="btn fa fa-universal-access text-success"></i>
                                </a>

                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            {{ $roles->links() }}
        @endif
    </div>
@endsection
@section('external_script')
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script></script>
@endsection
