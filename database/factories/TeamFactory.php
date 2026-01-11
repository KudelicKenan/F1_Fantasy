<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teamNames = ['Red Bull Racing', 'Mercedes', 'Ferrari', 'McLaren', 'Alpine', 'Aston Martin', 'AlphaTauri', 'Alfa Romeo', 'Williams', 'Haas'];
        $countries = ['Austria', 'Germany', 'Italy', 'United Kingdom', 'France', 'United Kingdom', 'Italy', 'Switzerland', 'United Kingdom', 'United States'];
        
        return [
            'name' => $this->faker->randomElement($teamNames),
            'country' => $this->faker->randomElement($countries),
            'founded_year' => $this->faker->numberBetween(1950, 2020),
            'logo' => null,
            'total_points' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
