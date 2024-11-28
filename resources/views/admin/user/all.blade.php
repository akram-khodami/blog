@extends('theme.admin_theme')
@section('stylesheet')
    <link href="{{ url('css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('operations')
    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#addUserModal">
        <i class="fa fa-user-plus text-success"></i>
    </button>
@endsection
@section('content')
    <div class="table-responsive">
        @if (!empty($users))
            @php
                $i = 1;
            @endphp
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>وضعیت</th>
                        <th>نقش ها</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->active == 1 ? 'فعال' : 'غیرفعال' }}</td>
                            <td>
                                @if (count($user->roles) > 0)
                                    @foreach ($user->roles as $role)
                                        <button class="badge badge-primary" id="button_{{ $user->id . '_' . $role->id }}">
                                            {{ $role->name }}
                                            <i class="fa fa-close text text-danger"
                                                onclick="deleteUserRole({{ $user->id }},{{ $role->id }})"></i>
                                        </button>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <i class="btn fa fa-trash-alt text-danger" onclick="deleteUser({{ $user->id }})"></i>

                                <a href="{{ url('users/' . $user->id . '/edit') }}">
                                    <i class="btn fa fa-pencil-alt text-warning"></i>
                                </a>

                                <button type="button" class="btn btn-link" data-toggle="modal"
                                    data-target="#addRoleToUserModal" title="افزودن نقش"
                                    onclick="set_record_id({{ $user->id }},'user_id')">
                                    <i class="fa fa fa-street-view text-success"></i>
                                </button>

                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        @endif
    </div>
@endsection
@section('modal')
    <!-- addUserModal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">افزودن کاربر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('users') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">نام</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="نام را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="email">ایمیل</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="ایمیل را وارد نمایید">
                        </div>
                        <div class="form-group">
                            <label for="password">کلمه عبور</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="کلمه عبور">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">تکرار کلمه عبور</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="تکرار کلمه عبور">
                        </div>
                        <input type="submit" class="btn btn-outline-success" value="ذخیره">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بسته</button>
                </div>
            </div>
        </div>
    </div>
    <!-- addRoleToUserModal -->
    <div class="modal fade" id="addRoleToUserModal" tabindex="-1" role="dialog" aria-labelledby="addRoleToUserModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">افزودن نقش</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('addUserRole') }}" method="post">
                        @csrf
                        <input type="hidden" value="" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="roles" class="col-md-6">نقش کاربری</label>
                            <div class="class="col-md-6"">
                                <select class="form-control select2" id="roles" name="roles[]" multiple>
                                    @if (!empty($roles))
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-outline-success" value="ذخیره">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بسته</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('external_script')
    <script src="{{ url('js/select2.min.js') }}"></script>
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                theme: "classic"
            });
        });
    </script>
@endsection
