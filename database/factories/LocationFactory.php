<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $areas = ['A', 'B', 'C', 'D', 'E'];
        $levels = ['Top', 'Middle', 'Bottom'];

        $area = fake()->randomElement($areas);
        $number = fake()->numberBetween(1, 20);
        $level = fake()->randomElement($levels);

        $loc_code = fake()->randomElement(['A', 'B', 'C']) . '-' .
            fake()->numberBetween(1, 20) . '-' .
            fake()->randomElement(['T', 'M', 'B']);

        return [
            'loc_code' => 'SHELF-' . $area . '-' . $number,
            'loc_name' => 'Shelf ' . $area . $number . ' ' . $level,
            'loc_desc' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
