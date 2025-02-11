<?php
namespace App\Traits;

trait AuthorizationsTrait
{
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

    public function getMenuAuthorizations($user)
    {
        $userPermissionsArray = $this->getUserPermissionsArray($user);

        return [
            'manage-users' => in_array('manage-users', $userPermissionsArray),
            'manage-tags' => in_array('manage-tags', $userPermissionsArray),
            'manage-categories' => in_array('manage-categories', $userPermissionsArray),
            'manage-posts' => in_array('manage-posts', $userPermissionsArray),
            'manage-comments' => in_array('manage-comments', $userPermissionsArray),
            'manage-roles' => in_array('manage-roles', $userPermissionsArray),
            'manage-permissions' => in_array('manage-permissions', $userPermissionsArray)
        ];
    }
}