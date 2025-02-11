@extends('theme.admin_theme')
@section('operations')
    <a href="{{ url('categories') }}" class="btn btn-outline-success btn-sm btn-shadow">
        <i class="fa fa-plus text-sucess"></i>
    </a>
@endsection
@section('content')
    @include('admin.category.create')
    <div class="table-responsive mt-1">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $category->title }}</td>
                        <td>@jalali($category->created_at)</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ url('categories/' . $category->id . '/edit') }}"
                                    class="btn btn-outline-warning btn-sm btn-shadow">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action={{ url('categories', ['id' => $category->id]) }} method="POST">
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
        {{ $categories->links() }}
    </div>
@endsection
@section('external_script')
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script></script>
@endsection
