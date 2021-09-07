<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'scope_id'       => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Admin Patra Kencana',
                'email'          => 'patraKencana@admin.com',
                'password'       => bcrypt('patraKencana'),
                'remember_token' => null,
                'scope_id'       => 1,
            ],
            [
                'id'             => 3,
                'name'           => 'Admin Randuagung 1',
                'email'          => 'randugaung1@adminc.com',
                'password'       => bcrypt('randuagung1'),
                'remember_token' => null,
                'scope_id'       => 2,
            ],
            [
                'id'             => 4,
                'name'           => 'User Patra Kencana',
                'email'          => 'patraKencana@user.com',
                'password'       => bcrypt('patraKencana'),
                'remember_token' => null,
                'scope_id'       => 1,
            ],
            [
                'id'             => 5,
                'name'           => 'User Randuagung 1',
                'email'          => 'randugaung1@user.com',
                'password'       => bcrypt('randuagung1'),
                'remember_token' => null,
                'scope_id'       => 2,
            ],
        ];

        User::insert($users);
    }
}
