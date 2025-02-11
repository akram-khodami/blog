<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
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
        if (!in_array('create-user', $permissions_array)) {

            return Response::deny('شما اجازه ثبت کاربر را ندارید.');

        }

        return true;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('update-user', $permissions_array)) {

            return Response::deny('شما مجوز ویرایش کاربر ها را ندارید.');

        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('delete-user', $permissions_array)) {

            return Response::deny('شما مجوز حذف کاربر ها را ندارید.');

        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }


    /**
     * Determine whether the user can add role to user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function addUserRole(User $user)
    {
        //===گرفتن اجازه های کاربر
        $permissions_array = $this->getUserPermissionsArray($user);

        //===شرط اول
        if (!in_array('add-user-role', $permissions_array)) {

            return Response::deny('شما اجازه اعطا نقش کاربری به کاربران را ندارید.');

        }

        return true;

    }

    /**
     * Determine whether the user can remove role of user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteUserRole(User $user)
    {
        //===گرفتن اجازه های کاربر
        $permissions_array = $this->getUserPermissionsArray($user);

        //===شرط اول
        if (!in_array('delete-user-role', $permissions_array)) {

            return Response::deny('شما اجازه حذف نقش کاربری کاربران را ندارید.');

        }

        return true;

    }
    public function manageUsers(User $user)
    {
        $permissions_array = $this->getUserPermissionsArray($user);

        if (!in_array('manage-users', $permissions_array)) {

            return Response::deny('شما مجوز دسترسی به مدیریت کاربران را ندارید.');

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
