<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrCategory>
 */
class PrCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Laptops',
            'Desktops',
            'Monitors',
            'Keyboards',
            'Mouse',
            'Printers',
            'Networking',
            'Storage Devices',
            'Components',
            'Accessories',
            'Cables',
            'Power Supplies',
            'Graphics Cards',
            'Processors',
            'Memory',
            'Motherboards',
            'Cooling Systems',
            'Audio Devices',
            'Smart Devices',
            'Peripherals'
        ];

        $name = fake()->unique()->randomElement($categories);

        return [
            'cat_name' => $name,
            'is_active' => fake()->boolean(90),
        ];
    }
}
