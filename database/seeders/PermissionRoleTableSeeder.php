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

        $notMasterAdmin = $admin_permissions->filter(function ($permission) {
            // List of conditions
            $notPermissions = substr($permission->title, 0, 11) != "permission_";
            $notRole = substr($permission->title, 0, 5) != 'role_';
            $notMonthlyBillToBill = substr($permission->title, 0, 21) != "monthly_bill_to_bill_";
            $notScope = substr($permission->title, 0, 6) != "scope_";

            return $notPermissions
                && $notRole
                && $notMonthlyBillToBill
                && $notScope
                ;
        });

        $scopedUser = $notMasterAdmin->filter(function ($permission) {
            // List of conditions
            $notUserManagement = substr($permission->title, 0, 5) != 'user_';
            return $notUserManagement;
        });

        Role::findOrFail(2)->permissions()->sync($user_permissions);

        // Not Master Admin
        Role::findOrFail(3)->permissions()->sync($notMasterAdmin);
        Role::findOrFail(4)->permissions()->sync($notMasterAdmin);
        Role::findOrFail(5)->permissions()->sync($notMasterAdmin);

        // User 
        Role::findOrFail(6)->permissions()->sync($scopedUser);
        Role::findOrFail(7)->permissions()->sync($scopedUser);
        Role::findOrFail(8)->permissions()->sync($scopedUser);
    }
}
