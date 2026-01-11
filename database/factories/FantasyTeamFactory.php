<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FantasyTeam>
 */
class FantasyTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teamNames = ['Speed Demons', 'Racing Legends', 'Track Masters', 'Podium Chasers', 'Fast & Furious', 'Victory Lane', 'Checkered Flag', 'Turbo Charged'];
        
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->randomElement($teamNames) . ' ' . $this->faker->numberBetween(1, 100),
            'total_points' => $this->faker->numberBetween(0, 2000),
        ];
    }
}
