<?php

namespace Database\Seeders;

use App\Models\Bill;

class IuranSeeder
{
    public function run()
    {
        $iuran = [

            // Gaji Satpam
            [
                'name' => 'Gaji Satpam',
                'description' => "Gaji Satpam Patra Kencana",
                'price' => '625000'
            ],

            // Iuran Sampah Patra Kencana
            [
                'mame' => 'Sampah Patra Kencana',
                'description' => "Iuran sampah tiap bulan pada perumahan Patra Kencana",
                "price" => "20000"
            ],

            // Iuran Lainnya dari Patra Kencana
            [
                'mame' => 'iuran lain dari Patra Kencana',
                'description' => "Iuran sampah tiap bulan pada perumahan Patra Kencana",
                "price" => "25000"
            ],

            // Iuran di tempat lainnya
        ];

        Bill::insert($iuran);
    }
}
