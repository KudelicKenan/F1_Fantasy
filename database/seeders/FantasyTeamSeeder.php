<?php

namespace Database\Seeders;

use App\Models\FantasyTeam;
use App\Models\User;
use Illuminate\Database\Seeder;

class FantasyTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kreiraj fantasy timove za postojeće korisnike
        $users = User::all();
        foreach ($users as $user) {
            FantasyTeam::factory()->count(rand(1, 3))->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
