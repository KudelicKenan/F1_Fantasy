<?php

namespace Database\Seeders;

use App\Models\Race;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $races = [
            ['name' => 'Monaco Grand Prix', 'location' => 'Monaco', 'circuit_name' => 'Circuit de Monaco', 'laps' => 78],
            ['name' => 'British Grand Prix', 'location' => 'Silverstone', 'circuit_name' => 'Silverstone Circuit', 'laps' => 52],
            ['name' => 'Italian Grand Prix', 'location' => 'Monza', 'circuit_name' => 'Autodromo Nazionale Monza', 'laps' => 53],
            ['name' => 'Belgian Grand Prix', 'location' => 'Spa', 'circuit_name' => 'Circuit de Spa-Francorchamps', 'laps' => 44],
            ['name' => 'Brazilian Grand Prix', 'location' => 'São Paulo', 'circuit_name' => 'Autódromo José Carlos Pace', 'laps' => 71],
            ['name' => 'Singapore Grand Prix', 'location' => 'Singapore', 'circuit_name' => 'Marina Bay Street Circuit', 'laps' => 61],
            ['name' => 'Abu Dhabi Grand Prix', 'location' => 'Abu Dhabi', 'circuit_name' => 'Yas Marina Circuit', 'laps' => 58],
            ['name' => 'Bahrain Grand Prix', 'location' => 'Sakhir', 'circuit_name' => 'Bahrain International Circuit', 'laps' => 57],
            ['name' => 'Spanish Grand Prix', 'location' => 'Barcelona', 'circuit_name' => 'Circuit de Barcelona-Catalunya', 'laps' => 66],
            ['name' => 'French Grand Prix', 'location' => 'Le Castellet', 'circuit_name' => 'Circuit Paul Ricard', 'laps' => 53],
            ['name' => 'Austrian Grand Prix', 'location' => 'Spielberg', 'circuit_name' => 'Red Bull Ring', 'laps' => 71],
            ['name' => 'Dutch Grand Prix', 'location' => 'Zandvoort', 'circuit_name' => 'Circuit Zandvoort', 'laps' => 72],
            ['name' => 'Mexican Grand Prix', 'location' => 'Mexico City', 'circuit_name' => 'Autódromo Hermanos Rodríguez', 'laps' => 71],
            ['name' => 'Japanese Grand Prix', 'location' => 'Suzuka', 'circuit_name' => 'Suzuka International Racing Course', 'laps' => 53],
            ['name' => 'Australian Grand Prix', 'location' => 'Melbourne', 'circuit_name' => 'Albert Park Circuit', 'laps' => 58],
        ];

        foreach ($races as $raceData) {
            Race::create([
                'name' => $raceData['name'],
                'location' => $raceData['location'],
                'circuit_name' => $raceData['circuit_name'],
                'race_date' => now()->addDays(rand(1, 365)),
                'laps' => $raceData['laps'],
                'weather' => null,
            ]);
        }
    }
}
