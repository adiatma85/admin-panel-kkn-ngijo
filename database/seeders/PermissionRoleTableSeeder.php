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
            // Non Announecement create, edit, or delete
            $notAnnouncemenetCreate = $permission->title != "announcement_create";
            $notAnnouncemenetEdit = $permission->title != "announcement_edit";
            $notAnnouncemenetDelete = $permission->title != "announcement_delete";
            // Non UserToMonthlyBill
            $notUserToMonthlyBillCreate = $permission->title != "user_to_monthly_bill_create";
            $notUserToMonthlyBillEdit = $permission->title != "user_to_monthly_bill_edit";
            $notUserToMonthlyBillDelete = $permission->title != "user_to_monthly_bill_delete";
            // Non Misc Access
            $notMiscAccess = $permission->title != "misc_access";
            // Not MonthlyBill Create Edit and Delete
            $notMonthlyBillCreate = $permission->title != "monthly_bill_create";
            $notMonthlyBillEdit = $permission->title != "monthly_bill_edit";
            $notMonthlyBillDelete = $permission->title != "monthly_bill_delete";
            // Non Bill create edit or delete
            $notBillCreate = $permission->title != "bill_create";
            $notBillEdit = $permission->title != "bill_edit";
            $notBillDelete = $permission->title != "bill_delete";

            // Return filtered permission
            return $notUserManagement
                && $notAnnouncemenetCreate
                && $notAnnouncemenetEdit
                && $notAnnouncemenetDelete
                && $notUserToMonthlyBillCreate
                && $notUserToMonthlyBillEdit
                && $notUserToMonthlyBillDelete
                && $notMiscAccess
                && $notMonthlyBillCreate
                && $notMonthlyBillEdit
                && $notMonthlyBillDelete
                && $notBillCreate
                && $notBillEdit
                && $notBillDelete
            ;
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
