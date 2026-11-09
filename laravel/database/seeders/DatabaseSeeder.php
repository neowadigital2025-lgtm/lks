<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Matikan cek foreign key sementara agar aman dari error proteksi
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Bersihkan data tabel users lama agar tidak bentrok
        User::truncate();

        // 3. Daftarkan akun Admin dengan enkripsi standar Laravel yang sinkron
        User::create([
            'id' => 1,
            'username' => 'admin',
            'password' => Hash::make('adminP@ssWord'), // Sesuai soal hal 1
            'role' => 'admin'
        ]);

        // 4. Daftarkan akun Budi dengan enkripsi standar Laravel yang sinkron
        User::create([
            'id' => 2,
            'username' => 'budi.budiman',
            'password' => Hash::make('Budi1928'), // Sesuai soal hal 1
            'role' => 'user'
        ]);

        // 5. Nyalakan kembali proteksi foreign key demi keamanan database
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
