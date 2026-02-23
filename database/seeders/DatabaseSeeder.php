<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrBrand;
use App\Models\PrCategory;
use App\Models\Vendor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        PrBrand::factory()->count(20)->create();
        Vendor::factory()->count(10)->create();
        Location::factory()->count(10)->create();
        PrCategory::factory()->count(10)->create();

        $this->call([
            UserSeeder::class,
        ]);
    }
}
