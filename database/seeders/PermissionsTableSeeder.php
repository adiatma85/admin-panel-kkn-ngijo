<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'iuran_access',
            ],
            [
                'id'    => 18,
                'title' => 'misc_access',
            ],
            [
                'id'    => 19,
                'title' => 'bill_create',
            ],
            [
                'id'    => 20,
                'title' => 'bill_edit',
            ],
            [
                'id'    => 21,
                'title' => 'bill_show',
            ],
            [
                'id'    => 22,
                'title' => 'bill_delete',
            ],
            [
                'id'    => 23,
                'title' => 'bill_access',
            ],
            [
                'id'    => 24,
                'title' => 'monthly_bill_create',
            ],
            [
                'id'    => 25,
                'title' => 'monthly_bill_edit',
            ],
            [
                'id'    => 26,
                'title' => 'monthly_bill_show',
            ],
            [
                'id'    => 27,
                'title' => 'monthly_bill_delete',
            ],
            [
                'id'    => 28,
                'title' => 'monthly_bill_access',
            ],
            [
                'id'    => 29,
                'title' => 'user_to_monthly_bill_create',
            ],
            [
                'id'    => 30,
                'title' => 'user_to_monthly_bill_edit',
            ],
            [
                'id'    => 31,
                'title' => 'user_to_monthly_bill_show',
            ],
            [
                'id'    => 32,
                'title' => 'user_to_monthly_bill_delete',
            ],
            [
                'id'    => 33,
                'title' => 'user_to_monthly_bill_access',
            ],
            [
                'id'    => 34,
                'title' => 'monthly_bill_to_bill_create',
            ],
            [
                'id'    => 35,
                'title' => 'monthly_bill_to_bill_edit',
            ],
            [
                'id'    => 36,
                'title' => 'monthly_bill_to_bill_show',
            ],
            [
                'id'    => 37,
                'title' => 'monthly_bill_to_bill_delete',
            ],
            [
                'id'    => 38,
                'title' => 'monthly_bill_to_bill_access',
            ],
            [
                'id'    => 39,
                'title' => 'pengumuman_access',
            ],
            [
                'id'    => 40,
                'title' => 'announcement_create',
            ],
            [
                'id'    => 41,
                'title' => 'announcement_edit',
            ],
            [
                'id'    => 42,
                'title' => 'announcement_show',
            ],
            [
                'id'    => 43,
                'title' => 'announcement_delete',
            ],
            [
                'id'    => 44,
                'title' => 'announcement_access',
            ],
            [
                'id'    => 45,
                'title' => 'scope_create',
            ],
            [
                'id'    => 46,
                'title' => 'scope_edit',
            ],
            [
                'id'    => 47,
                'title' => 'scope_show',
            ],
            [
                'id'    => 48,
                'title' => 'scope_delete',
            ],
            [
                'id'    => 49,
                'title' => 'scope_access',
            ],
            [
                'id'    => 50,
                'title' => 'pembayaran_access',
            ],
            [
                'id'    => 51,
                'title' => 'profile_password_edit',
            ],
            // Custom

        ];

        Permission::insert($permissions);
    }
}
