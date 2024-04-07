<?php

namespace Database\Seeders;

use App\Models\Administrateur;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Administrateur::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('p@ssw0rd'),
        ]);

        $this->call([
            ProfilSeeder::class
        ]);
    }
}
