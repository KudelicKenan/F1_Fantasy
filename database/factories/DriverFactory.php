<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nationalities = ['British', 'Dutch', 'Spanish', 'French', 'German', 'Finnish', 'Australian', 'Mexican', 'Canadian', 'Japanese'];
        
        return [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'nationality' => $this->faker->randomElement($nationalities),
            'date_of_birth' => $this->faker->dateTimeBetween('-40 years', '-18 years'),
            'team_id' => Team::factory(),
            'points' => $this->faker->numberBetween(0, 500),
            'photo' => null,
            'driver_number' => $this->faker->unique()->numberBetween(1, 99),
        ];
    }
}
