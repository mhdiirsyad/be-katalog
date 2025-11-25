<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin (Platform)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@katalog.com',
            'password' => Hash::make('password123'), // Password admin
            'email_verified_at' => now(),
        ]);

        // Opsional: Pesan di terminal biar tahu kalau berhasil
        $this->command->info('User Admin berhasil dibuat!');
    }
}