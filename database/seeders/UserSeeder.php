<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder {
    public function run(): void {
        User::insert([
            [
                'name' => 'dwi',
                'email' => 'dwinursyafa73@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
            ],
            [
                'name' => 'Karyawan Borongan',
                'email' => 'karyawanborongan@gmail.com',
                'password' => Hash::make('karyawanborongan123'),
                'role' => 'karyawan_borongan',
                'created_at' => now(),
            ],
            [
                'name' => 'Karyawan Bulanan',
                'email' => 'karyawanbulanan@gmail.com',
                'password' => Hash::make('karyawanbulanan123'),
                'role' => 'karyawan_bulanan',
                'created_at' => now(),
            ]
        ]);
    }
}
