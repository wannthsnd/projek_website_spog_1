<?php

namespace Database\Seeders;

use App\Models\Upt;
use Illuminate\Database\Seeder;

class UptSeeder extends Seeder
{
    public function run(): void
    {
        $upts = [
            ['name' => 'UPT Pelabuhan Lampung', 'code' => 'LPG', 'region' => 'Sumatera', 'is_active' => true],
            ['name' => 'UPT Pelabuhan Jakarta', 'code' => 'JKT', 'region' => 'Jawa', 'is_active' => true],
            ['name' => 'UPT Pelabuhan Surabaya', 'code' => 'SBY', 'region' => 'Jawa', 'is_active' => true],
            ['name' => 'UPT Pelabuhan Makassar', 'code' => 'MKS', 'region' => 'Sulawesi', 'is_active' => true],
            ['name' => 'UPT Pelabuhan Balikpapan', 'code' => 'BPN', 'region' => 'Kalimantan', 'is_active' => true],
            ['name' => 'UPT Pelabuhan Manado', 'code' => 'MND', 'region' => 'Sulawesi', 'is_active' => true],
            ['name' => 'UPT Pelabuhan Denpasar', 'code' => 'DPS', 'region' => 'Bali & Nusa Tenggara', 'is_active' => true],
            ['name' => 'UPT Pelabuhan Ambon', 'code' => 'AMN', 'region' => 'Maluku', 'is_active' => true],
            ['name' => 'UPT Pelabuhan Jayapura', 'code' => 'JPR', 'region' => 'Papua', 'is_active' => true],
        ];

        foreach ($upts as $upt) {
            Upt::firstOrCreate(['code' => $upt['code']], $upt);
        }
    }
}
