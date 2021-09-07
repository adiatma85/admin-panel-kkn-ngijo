<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });

        Role::findOrFail(2)->permissions()->sync($user_permissions);

        // Not Master Admin
        Role::findOrFail(3)->permissions()->sync($admin_permissions);
        Role::findOrFail(4)->permissions()->sync($admin_permissions);
        Role::findOrFail(5)->permissions()->sync($admin_permissions);

        // User 
        Role::findOrFail(6)->permissions()->sync($user_permissions);
        Role::findOrFail(7)->permissions()->sync($user_permissions);
        Role::findOrFail(8)->permissions()->sync($user_permissions);
    }
}
