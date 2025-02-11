<div class="card">
    <div class="card-header">
        میزکار
        {{ Auth::user()->name }}
    </div>
    <div class="card-body">

        <div class="btn-group-vertical" role="group" aria-label="Button group with nested dropdown">

            <a href="{{ url('profile', []) }}" class="dropdown-item {{ $active == 'profile' ? 'active' : '' }}">
                پروفایل
            </a>

            @if (array_key_exists('manage-tags', $manuAuthorizations) ? $manuAuthorizations['manage-tags'] : false)
                <a href="{{ url('tags', []) }}" class="dropdown-item {{ $active == 'tags' ? 'active' : '' }}">
                    تگ ها
                </a>
            @endif

            @if (array_key_exists('manage-categories', $manuAuthorizations) ? $manuAuthorizations['manage-categories'] : false)
                <a href="{{ url('categories', []) }}"
                    class="dropdown-item {{ $active == 'categories' ? 'active' : '' }}">
                    دسته بندی ها
                </a>
            @endif

            @if (array_key_exists('manage-posts', $manuAuthorizations) ? $manuAuthorizations['manage-posts'] : false)
                <a href="{{ url('posts', []) }}" class="dropdown-item {{ $active == 'posts' ? 'active' : '' }}">
                    نوشته ها
                </a>
            @endif

            @if (array_key_exists('manage-comments', $manuAuthorizations) ? $manuAuthorizations['manage-comments'] : false)
                <a href="{{ url('comments?confirmed=all', []) }}"
                    class="dropdown-item {{ $active == 'comments' ? 'active' : '' }}">
                    نظرات
                </a>
            @endif

            @if (array_key_exists('manage-users', $manuAuthorizations) ? $manuAuthorizations['manage-users'] : false)
                <a href="{{ url('users', []) }}" class="dropdown-item {{ $active == 'users' ? 'active' : '' }}">
                    کاربران
                </a>
            @endif

            @if (array_key_exists('manage-roles', $manuAuthorizations) ? $manuAuthorizations['manage-roles'] : false)
                <a href="{{ url('roles', []) }}" class="dropdown-item {{ $active == 'roles' ? 'active' : '' }}">
                    نقش ها
                </a>
            @endif

            @if (array_key_exists('manage-permissions', $manuAuthorizations) ? $manuAuthorizations['manage-permissions'] : false)
                <a href="{{ url('permissions', []) }}"
                    class="dropdown-item {{ $active == 'permissions' ? 'active' : '' }}">
                    اجازه ها
                </a>
            @endif

        </div>

    </div>
</div>
