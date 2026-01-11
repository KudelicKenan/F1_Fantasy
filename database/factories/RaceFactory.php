<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Race>
 */
class RaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $raceNames = ['Monaco Grand Prix', 'British Grand Prix', 'Italian Grand Prix', 'Belgian Grand Prix', 'Brazilian Grand Prix', 'Singapore Grand Prix', 'Abu Dhabi Grand Prix', 'Bahrain Grand Prix', 'Spanish Grand Prix', 'French Grand Prix', 'Austrian Grand Prix', 'Dutch Grand Prix', 'Mexican Grand Prix', 'Japanese Grand Prix', 'Australian Grand Prix'];
        $locations = ['Monaco', 'Silverstone', 'Monza', 'Spa', 'São Paulo', 'Singapore', 'Abu Dhabi', 'Sakhir', 'Barcelona', 'Le Castellet', 'Spielberg', 'Zandvoort', 'Mexico City', 'Suzuka', 'Melbourne'];
        $circuits = ['Circuit de Monaco', 'Silverstone Circuit', 'Autodromo Nazionale Monza', 'Circuit de Spa-Francorchamps', 'Autódromo José Carlos Pace', 'Marina Bay Street Circuit', 'Yas Marina Circuit', 'Bahrain International Circuit', 'Circuit de Barcelona-Catalunya', 'Circuit Paul Ricard', 'Red Bull Ring', 'Circuit Zandvoort', 'Autódromo Hermanos Rodríguez', 'Suzuka International Racing Course', 'Albert Park Circuit'];
        
        return [
            'name' => $this->faker->randomElement($raceNames),
            'location' => $this->faker->randomElement($locations),
            'race_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'circuit_name' => $this->faker->randomElement($circuits),
            'weather' => null, // Biti će popunjeno kroz eksterni API
            'laps' => $this->faker->numberBetween(50, 78),
        ];
    }
}
