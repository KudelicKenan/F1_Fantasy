<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kreiraj test korisnika
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        // Kreiraj dodatne korisnike
        User::factory(5)->create();

        // Seed tabele u ispravnom redoslijedu (zbog foreign key-jeva)
        $this->call([
            TeamSeeder::class,
            DriverSeeder::class,
            RaceSeeder::class,
            FantasyTeamSeeder::class,
            FantasyTeamDriverSeeder::class,
        ]);
    }
}
