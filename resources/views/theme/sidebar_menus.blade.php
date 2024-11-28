<div class="card">
    <div class="card-header">
        میزکار
    </div>
    <div class="card-body">

        <div class="btn-group-vertical" role="group" aria-label="Button group with nested dropdown">
            <a href="{{ url('profile', []) }}" class="dropdown-item {{ $active == 'profile' ? 'active' : '' }}">
                پروفایل
            </a>
            <a href="{{ url('tags', []) }}" class="dropdown-item {{ $active == 'tags' ? 'active' : '' }}">
                تگ ها
            </a>
            <a href="{{ url('categories', []) }}" class="dropdown-item {{ $active == 'categories' ? 'active' : '' }}">
                دسته بندی ها
            </a>
            <a href="{{ url('posts', []) }}" class="dropdown-item {{ $active == 'posts' ? 'active' : '' }}">
                نوشته ها
            </a>
            <a href="{{ url('comments?confirmed=all', []) }}"
                class="dropdown-item {{ $active == 'comments' ? 'active' : '' }}">
                نظرات
            </a>
            <a href="{{ url('users', []) }}" class="dropdown-item {{ $active == 'users' ? 'active' : '' }}">
                کاربران
            </a>
            <a href="{{ url('roles', []) }}" class="dropdown-item {{ $active == 'roles' ? 'active' : '' }}">
                نقش ها
            </a>
            <a href="{{ url('permissions', []) }}"
                class="dropdown-item {{ $active == 'permissions' ? 'active' : '' }}">
                اجازه ها
            </a>
        </div>

    </div>
</div>
