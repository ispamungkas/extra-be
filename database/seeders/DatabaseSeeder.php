<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Eskul;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        if (!\App\Models\User::where('email', 'admin@example.com')->exists()) {
    \App\Models\User::create([
        'name' => 'Admin Utama',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);
}

        // Pembina
        $pembinas = User::factory()->count(3)->create([
            'role' => 'pembina',
            'no_telp' => fake()->phoneNumber(),
        ]);

        // Siswa
        $siswas = User::factory()->count(5)->create([
            'role' => 'siswa',
            'kelas' => 'XII IPA 1',
            'no_telp' => fake()->phoneNumber(),
            'nisn' => fake()->numerify('############')
        ]);

        // Eskul
        foreach (['Pramuka', 'Paskibra', 'PMR'] as $index => $nama) {
            Eskul::create([
                'nama' => $nama,
                'jadwal' => 'Senin, 15:00 WIB',
                'pembina_id' => $pembinas[$index]->id,
                'tempat' => 'Lapangan Utama'
            ]);
        }
    }
}
