<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Package;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Create sample customer
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '081234567891',
        ]);

        // Create sample packages
        Package::create([
            'name' => 'Regular',
            'description' => 'Regular laundry service with 2-3 days processing time',
            'price' => 7000,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'Express',
            'description' => 'Express laundry service with 1 day processing time',
            'price' => 10000,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'Premium',
            'description' => 'Premium laundry service with special treatment',
            'price' => 15000,
            'is_active' => true,
        ]);

        $this->call([
            UserSeeder::class,
            // PackageSeeder::class, // Comment this if you don't have PackageSeeder
            // Tambahkan seeder lain jika ada
        ]);
    }
}
