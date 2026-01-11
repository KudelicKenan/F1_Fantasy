<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Team;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::all();
        
        // Kreiraj tačno 2 vozača za svaki tim
        foreach ($teams as $team) {
            Driver::factory(2)->create([
                'team_id' => $team->id,
            ]);
        }
    }
}
