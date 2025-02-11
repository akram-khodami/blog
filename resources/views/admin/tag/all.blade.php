@extends('theme.admin_theme')
@section('operations')
    <a href="{{ url('tags') }}" class="btn btn-outline-success btn-sm btn-shadow">
        <i class="fa fa-plus text-sucess"></i>
    </a>
@endsection
@section('content')
    @include('admin.tag.create')
    <div class="table-responsive mt-1">
        <table class="table table-bordered table-stripped">
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
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $tag->title }}</td>
                        <td>@jalali($tag->created_at)</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ url('tags/' . $tag->id . '/edit') }}"
                                    class="btn btn-outline-warning btn-sm btn-shadow">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action={{ url('tags', ['id' => $tag->id]) }} method="POST">
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
        {{ $tags->links() }}
    </div>
@endsection
@section('external_script')
    <script src="{{ url('js/blog.js') }}"></script>
@endsection
@section('internal_script')
    <script></script>
@endsection
