@extends('theme.admin_theme')
@section('operations')
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group">
                <div class="btn-group dropleft" role="group">
                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropleft</span>
                    </button>
                    <div class="dropdown-menu">
                        <!-- Dropdown menu links -->
                        <a href="{{ url('posts/create', []) }}" class="dropdown-item">
                            + <i class="glyphicon glyphicon-plus"></i>نوشته
                        </a>
                        <!-- Button trigger modal -->
                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#exampleModalLong">
                            + <i class="glyphicon glyphicon-plus"></i>دسته بندی
                        </button>
                        <a href="{{ url('tags/create', []) }}" class="dropdown-item">
                            + <i class="glyphicon glyphicon-plus"></i>تگ
                        </a>
                    </div>
                </div>
                <button class="btn btn-outline-success btn-sm" type="button">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <!-- Split dropright button -->
            <div class="btn-group dropright">
                <button type="button" class="btn btn-outline-danger btn-sm">
                    <i class="fa fa-trash-alt"></i>
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm dropdown-toggle dropdown-toggle-split"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropright</span>
                </button>
                <div class="dropdown-menu">
                    <!-- Dropdown menu links -->
                    <a class="dropdown-item" href="#">تمام نظرات</a>

                    <!-- satrt delete all post -->
                    <form action={{ url('destroy/posts') }} method="POST">
                        @csrf
                        @method('delete')
                        <button class="dropdown-item">تمام نوشته ها</button>
                    </form>
                    <!-- end delete all post -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>نویسنده</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>@jalali($post->created_at)</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ url('posts/' . $post->id . '/edit') }}"
                                    class="btn btn-outline-warning btn-sm btn-shadow">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action={{ url('posts', ['id' => $post->id]) }} method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm btn-shadow">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}
    </div>
@endsection
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLongTitle">افزودن دسته بندی</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('categories', []) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="title" class="form-control" id="title" placeholder="" name="title">
                        </div>

                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    </form>

                    <div class="table-responsive mt-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>عنوان</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($categories))
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $category->title }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{ url('categories/' . $category->id . '/edit') }}"
                                                        class="btn btn-outline-warning btn-sm btn-shadow">
                                                        <i class="fa fa-pencil"></i>
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    </a>
                                                    <form action={{ url('categories', ['id' => $category->id]) }}
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-outline-danger btn-sm btn-shadow">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
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
