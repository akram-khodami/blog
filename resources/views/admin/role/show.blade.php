@extends('theme.admin_theme')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ $role->name }}
                </div>
                <div class="card-body">

                    <div class="row">
                        @foreach ($permissions as $permission)
                            @php
                                $checked = in_array($permission->id, $role_permissions);
                            @endphp
                            <label for="" id="label{{ $permission->id }}"
                                class="col-md-3 {{ $checked ? 'text-dark' : '' }}">
                                {{ $permission->name }}
                            </label>
                            <div class="col-md-3">
                                <input type="checkbox" name="permission" id="permission{{ $permission->id }}"
                                    value="{{ $permission->id }}"
                                    onchange="addPermission( {{ $role->id }}, {{ $permission->id }})"
                                    @checked($checked)>
                            </div>
                        @endforeach
                    </div>

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
