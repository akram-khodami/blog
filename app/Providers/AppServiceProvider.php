<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
use Gate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();//حل مشکل نمایشی مربوط به صفحه بندی ها در ویو

        \Blade::directive('jalali', function ($expression) {
            return "<?php echo \Morilog\Jalali\CalendarUtils::convertNumbers(\Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($expression))); ?>";
        });//نمایش راحت تر تاریخ جلالی در یو(بدون کمک استفاده از هلپر)


        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);

        // Gate::define('show-post', function (User $user, Post $post) {
        //     $permissions_array = $user->roles()->with('permissions')->get()
        //         ->pluck('permissions')->flatten()
        //         ->pluck('ability')->toArray();

        //     if (!in_array('update-post', $permissions_array)) {

        //         return false;

        //     }

        //     if ($user->id !== $post->user_id) {

        //         return false;

        //     }

        //     return true;

        // });

    }
}
