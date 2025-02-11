<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('create-post', $permissions_array)) {

            return Response::deny('شما مجوز ثبت نوشته را ندارید.');

        }

        return true;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Post $post)
    {
        //===گرفتن اجازه های کاربر
        $permissions_array = $this->getUserPermissionsArray($user);

        //===شرط اول
        if (!in_array('update-post', $permissions_array)) {

            return Response::deny('شما اجازه ویرایش پست ها را ندارید.');

        }

        //===شرط دوم
        if ($user->id !== $post->user_id) {

            return Response::deny('شما صرفا اجازه ویرایش پست های خود را دارید.');

        }

        // return Response::allow('message', 200);
        return true;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Post $post)
    {
        //===گرفتن اجازه های کاربر
        $permissions_array = $this->getUserPermissionsArray($user);

        //===شرط اول
        if (!in_array('delete-post', $permissions_array)) {

            return Response::deny('شما اجازه حذف پست ها را ندارید.');

        }

        //===شرط دوم
        if ($user->id !== $post->user_id) {

            return Response::deny('شما صرفا اجازه حذف پست های خود را دارید.');

        }

        // return Response::allow('message', 200);
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }

    public function managePosts(User $user)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('manage-posts', $permissions_array)) {

            return Response::deny('شما مجوز دسترسی به مدیریت نوشته ها را ندارید.');

        }

        return true;
    }
    
    public function getUserPermissionsArray($user)
    {
        $permissions_array = $user->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('ability')
            ->toArray();

        return $permissions_array;

    }
}
