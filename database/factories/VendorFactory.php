<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
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

        $name = fake()->randomElement($techPrefixes)
            . ' ' .
            fake()->randomElement($techSuffixes)
            . ' ' .
            fake()->unique()->numberBetween(1, 9999);

        return [
            'vendor_name' => $name,
        ];
    }
}
