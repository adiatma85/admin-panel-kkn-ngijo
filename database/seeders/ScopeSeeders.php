<?php

namespace Database\Seeders;

use App\Models\Scope;
use Illuminate\Database\Seeder;

class ScopeSeeders extends Seeder
{
    public function run()
    {
        $scopes = [

            // Perumahan Patra Kenacna
            [
                'name' => "Patra Kencana",
            ],

            // Randuagung 1
            [
                'name' => "Randuagung 1",
            ],

            // Randuagung 2
            [
                "name" => "Randuagung 2",
            ]
        ];

        Scope::insert($scopes);
    }
}
