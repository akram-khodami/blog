<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Category $category)
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

        if (!in_array('create-category', $permissions_array)) {

            return Response::deny('شما مجوز ثبت دسته بندی را ندارید.');

        }

        return true;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Category $category)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('update-category', $permissions_array)) {

            return Response::deny('شما مجوز ویرایش دسته بندی ها را ندارید.');

        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Category $category)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('delete-category', $permissions_array)) {

            return Response::deny('شما مجوز حذف دسته بندی ها را ندارید.');

        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Category $category)
    {
        //
    }

    public function manageCategories(User $user)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('manage-categories', $permissions_array)) {

            return Response::deny('شما مجوز دسترسی به مدیریت دسته بندی ها را ندارید.');

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
