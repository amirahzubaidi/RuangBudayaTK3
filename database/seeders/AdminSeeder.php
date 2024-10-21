<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan 2 akun admin menggunakan Eloquent ORM
        User::create([
            'name' => 'Admin One',
            'username' => 'adminone',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password123'), // Enkripsi password
            'role' => 'admin',
            'profile_picture' => null, // Bisa diisi dengan path gambar profil jika ada
        ]);

        User::create([
            'name' => 'Admin Two',
            'username' => 'admintwo',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'), // Enkripsi password
            'role' => 'admin',
            'profile_picture' => null, // Bisa diisi dengan path gambar profil jika ada
        ]);
    }
}
