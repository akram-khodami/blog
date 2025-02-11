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
                        <tr id="tr{{ $user->id }}">
                            <td>{{ $i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td id="active_status{{ $user->id }}">{{ $user->active == 1 ? 'فعال' : 'غیرفعال' }}</td>
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

                                <button type="button" title="ویرایش کاربر" class="btn btn-link" data-toggle="modal"
                                    data-target="#editUserModal{{ $user->id }}">
                                    <i class="btn fas fa-user-edit text-warning"></i>
                                </button>

                                <button type="button" class="btn btn-link" data-toggle="modal"
                                    data-target="#addRoleToUserModal" title="افزودن نقش"
                                    onclick="set_record_id({{ $user->id }},'user_id')">
                                    <i class="btn fa fa fa-street-view text-success"></i>
                                </button>

                                @if ($user->active)
                                    <i class="btn fas fa-user-lock text-dark" id="inActiveUser{{ $user->id }}"
                                        onclick="inActiveUser({{ $user->id }})" title="غیر فعال کردن کاربر"></i>
                                @else
                                    <i class="btn fas fa-user-check text-success" id="activeUser{{ $user->id }}"
                                        onclick="activeUser({{ $user->id }})" title="فعال کردن کاربر"></i>
                                @endif

                                @if (!$user->is_permannet)
                                    <i class="btn fa fa-user-times text-danger" title="حذف کاربر"
                                        onclick="deleteUser({{ $user->id }})" aria-hidden="true"></i>
                                @endif

                                <!-- edit user modal -->
                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editUserModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title" id="editUserModalLongTitle">ویرایش کاربر</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @include('admin.user.edit')
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">بسته</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                    <h5 class="modal-title" id="addUserModalLongTitle">افزودن کاربر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('admin.user.create')
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
                    <h5 class="modal-title" id="addRoleToUserModalLongTitle">افزودن نقش</h5>
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
    <script src="{{ url('js/blog.js?v=' . time()) }}"></script>
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
