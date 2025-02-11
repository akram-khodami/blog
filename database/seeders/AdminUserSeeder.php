<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert or update permissions
        $permissionsData = [
            ['ability' => 'manage-comments', 'name' => 'مدیریت نظرات'],
            ['ability' => 'manage-users', 'name' => 'مدیریت کاربران'],
            ['ability' => 'manage-roles', 'name' => 'مدیریت نقش ها'],
            ['ability' => 'manage-permissions', 'name' => 'مدیریت اجازه ها'],
            ['ability' => 'manage-posts', 'name' => 'مدیریت نوشته ها'],
            ['ability' => 'manage-tags', 'name' => 'مدیریت تگ ها'],
            ['ability' => 'manage-categories', 'name' => 'مدیریت دسته بندی ها'],

            ['ability' => 'add-user-role', 'name' => 'اعطا نقش به کاربر'],

            ['ability' => 'create-user', 'name' => 'ایجاد کاربر'],
            ['ability' => 'create-role', 'name' => 'ایجاد نقش'],
            ['ability' => 'create-permission', 'name' => 'ایجاد اجازه'],
            ['ability' => 'create-post', 'name' => 'ایجاد پست'],
            ['ability' => 'create-tag', 'name' => 'ایجاد تگ'],
            ['ability' => 'create-category', 'name' => 'ایجاد دسته بندی'],

            ['ability' => 'delete-user', 'name' => 'حذف کاربر'],
            ['ability' => 'delete-role', 'name' => 'حذف نقش'],
            ['ability' => 'delete-permission', 'name' => 'حذف اجازه'],
            ['ability' => 'delete-user-role', 'name' => 'حذف نقش اعطا شده کاربر'],
            ['ability' => 'delete-post', 'name' => 'حذف پست'],
            ['ability' => 'delete-tag', 'name' => 'حذف تگ'],
            ['ability' => 'delete-category', 'name' => 'حذف دسته بندی'],

            ['ability' => 'update-user', 'name' => 'ویرایش کاربر'],
            ['ability' => 'update-role', 'name' => 'ویرایش نقش'],
            ['ability' => 'update-permission', 'name' => 'ویرایش اجازه'],
            ['ability' => 'update-post', 'name' => 'ویرایش پست'],
            ['ability' => 'update-tag', 'name' => 'ویرایش تگ'],
            ['ability' => 'update-category', 'name' => 'ویرایش دسته بندی']
        ];

        Permission::upsert($permissionsData, ['ability'], ['name']);

        // Fetch the permissions from the database
        $permissions = Permission::whereIn('ability', collect($permissionsData)->pluck('ability'))->get();

        // Create or find the admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['active' => 1]);

        // Attach permissions to the admin role
        $adminRole->permissions()->syncWithoutDetaching($permissions->pluck('id'));

        // Create or update the admin user
        $adminUser = User::updateOrCreate(
            ['email' => 'akram.khodami@gmail.com'], // Identifier
            [
                'name' => 'اکرم خدامی',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'defaultStrongPassword')),
                'active' => 1,
                'is_permanent' => true,
            ]
        );

        // Attach the admin role if not already attached
        if (!$adminUser->roles()->where('name', 'admin')->exists()) {
            $adminUser->roles()->attach($adminRole->id);
            // $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);//چرا این بهتره؟؟؟
        }

    }
}
