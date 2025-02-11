@extends('theme.admin_theme')
@section('operations')
    <a href="{{ url('permissions') }}" class="btn btn-outline-success btn-sm btn-shadow">
        <i class="fa fa-plus text-sucess"></i>
    </a>
@endsection
@section('content')
    @include('admin.permission.create')
    <hr>
    <div class="table-responsive">
        @if (!empty($permissions))
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>قابلیت</th>
                        <th>توضیحات</th>
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
                            <td>{{ $permission->ability }}</td>
                            <td>{{ $permission->description }}</td>
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
