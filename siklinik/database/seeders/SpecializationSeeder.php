<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $items = ['Dokter Umum', 'Dokter Gigi', 'Dokter Anak', 'Dokter Kandungan', 'Dokter Kulit'];

        foreach ($items as $item) {
            Specialization::firstOrCreate(['name' => $item]);
        }
    }
}
