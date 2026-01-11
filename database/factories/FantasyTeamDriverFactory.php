<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\FantasyTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FantasyTeamDriver>
 */
class FantasyTeamDriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fantasy_team_id' => FantasyTeam::factory(),
            'driver_id' => Driver::factory(),
            'points' => $this->faker->numberBetween(0, 300),
        ];
    }
}
