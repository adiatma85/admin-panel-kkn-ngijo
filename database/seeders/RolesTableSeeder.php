<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
                'scope_id' => null,
            ],
            [
                'id'    => 2,
                'title' => 'User',
                'scope_id' => null,
            ],
            [
                'id'    => 3,
                'title' => 'Admin Patra Kencana',
                'scope_id' => 1,
                
            ],
            [
                'id'    => 4,
                'title' => 'Admin Randuagung 1',
                'scope_id' => 2,
            ],
            [
                'id'    => 5,
                'title' => 'Admin Randuagung 2',
                'scope_id' => 3,
            ],
            [
                'id'    => 6,
                'title' => 'User Patra Kencana',
                'scope_id' => 1,
                
            ],
            [
                'id'    => 7,
                'title' => 'User Randuagung 1',
                'scope_id' => 2,
                
            ],
            [
                'id'    => 8,
                'title' => 'User Randuagung 2',
                'scope_id' => 3,
                
            ],
        ];

        Role::insert($roles);
    }
}
