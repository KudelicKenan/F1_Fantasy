<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamDriver;
use Illuminate\Database\Seeder;

class FantasyTeamDriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fantasyTeams = FantasyTeam::all();
        $drivers = Driver::all();

        foreach ($fantasyTeams as $fantasyTeam) {
            // Dodaj 2-5 vozača u svaki fantasy tim
            $selectedDrivers = $drivers->random(rand(2, 5));
            
            foreach ($selectedDrivers as $driver) {
                FantasyTeamDriver::create([
                    'fantasy_team_id' => $fantasyTeam->id,
                    'driver_id' => $driver->id,
                    'points' => rand(0, 300),
                ]);
            }
        }
    }
}
