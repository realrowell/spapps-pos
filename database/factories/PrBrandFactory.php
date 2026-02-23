<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrBrand>
 */
class PrBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $techPrefixes = [
            'Tech',
            'Micro',
            'Info',
            'Data',
            'Cyber',
            'Net',
            'Cloud',
            'Digital',
            'Smart',
            'Nano',
            'Pixel',
            'Core',
            'Next',
            'Future',
            'Quantum',
            'Logic',
            'Vision',
            'Global',
            'Prime',
            'Dynamic'
        ];

        $techSuffixes = [
            'Systems',
            'Solutions',
            'Technologies',
            'Labs',
            'Works',
            'Corp',
            'Inc',
            'Group',
            'Innovations',
            'Networks',
            'Software',
            'Devices'
        ];

        $name = fake()->unique()->randomElement($techPrefixes)
            . ' ' .
            fake()->randomElement($techSuffixes);

        return [
            'brand_name' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function real(): static
    {
        $brands = [
            'Apple',
            'Samsung',
            'Intel',
            'AMD',
            'NVIDIA',
            'Microsoft',
            'Sony',
            'Dell',
            'HP',
            'Lenovo',
            'Asus',
            'Acer',
            'Cisco',
            'Oracle',
            'IBM',
            'Logitech',
            'Razer',
            'MSI',
            'Gigabyte'
        ];

        return $this->state(fn() => [
            'brand_name' => fake()->randomElement($brands),
            'is_active' => true,
        ]);
    }
}
