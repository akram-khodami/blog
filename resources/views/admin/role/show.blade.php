@extends('theme.admin_theme')
@section('operations')
    <a href="{{ url('roles') }}" class="btn btn-outline-success btn-sm btn-shadow">
        <i class="fa fa-plus text-sucess"></i>
    </a>
@endsection
@section('content')
    <div class="row">
        @foreach ($permissions as $permission)
            @php
                $checked = in_array($permission->id, $role_permissions);
            @endphp
            <label for="" id="label{{ $permission->id }}" class="col-md-2 {{ $checked ? 'text-dark' : '' }}">
                {{ $permission->name }}
            </label>
            <div class="col-md-2">
                <input type="checkbox" name="permission" id="permission{{ $permission->id }}" value="{{ $permission->id }}"
                    onchange="addPermission( {{ $role->id }}, {{ $permission->id }})" @checked($checked)>
            </div>
        @endforeach
    </div>
@endsection
@section('external_script')
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script></script>
@endsection
