<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@siklinik.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Dokter + profil dokter + jadwal
        $userDokter = User::create([
            'name' => 'dr. Andi Saputra',
            'email' => 'dokter@siklinik.test',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        $dokter = Doctor::create([
            'user_id' => $userDokter->id,
            'specialization' => 'Dokter Umum',
            'license_number' => 'STR-123456',
            'bio' => 'Berpengalaman 8 tahun di bidang kesehatan umum.',
        ]);

        // Jadwal Senin & Rabu, 08:00 - 12:00
        Schedule::create([
            'doctor_id' => $dokter->id,
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '12:00',
            'quota' => 10,
        ]);

        Schedule::create([
            'doctor_id' => $dokter->id,
            'day_of_week' => 3,
            'start_time' => '08:00',
            'end_time' => '12:00',
            'quota' => 10,
        ]);

        // 3. Akun Pasien contoh
        $userPasien = User::create([
            'name' => 'Budi Santoso',
            'email' => 'pasien@siklinik.test',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);

        Patient::create([
            'user_id' => $userPasien->id,
            'nik' => '3271000000000001',
            'date_of_birth' => '1998-05-10',
            'gender' => 'L',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 10, Jakarta',
        ]);
    }
}
