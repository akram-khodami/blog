<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Role $role)
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
        //===گرفتن اجازه های کاربر
        $permissions_array = $this->getUserPermissionsArray($user);

        //===شرط اول
        if (!in_array('create-role', $permissions_array)) {

            return Response::deny('شما اجازه ثبت نقش کاربری را ندارید.');

        }

        return true;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Role $role)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('update-role', $permissions_array)) {

            return Response::deny('شما مجوز ویرایش نقش کاربری ها را ندارید.');

        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Role $role)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('delete-role', $permissions_array)) {

            return Response::deny('شما مجوز حذف نقش کاربری ها را ندارید.');

        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Role $role)
    {
        //
    }


    /**
     * 
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function addPermissionToRole(User $user, Role $role)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('add-permission-to-role', $permissions_array)) {

            return Response::deny('شما مجوز افزودن اجازه برای نقش کاربری ها را ندارید.');

        }

        return true;
    }

    public function manageRoles(User $user)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('manage-roles', $permissions_array)) {

            return Response::deny('شما مجوز دسترسی به مدیریت نقش ها را ندارید.');

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
