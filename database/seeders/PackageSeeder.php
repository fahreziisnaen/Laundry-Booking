<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Regular',
                'description' => 'Regular laundry service with 2-3 days processing time',
                'price' => 7000,
                'is_active' => true,
            ],
            [
                'name' => 'Express',
                'description' => 'Express laundry service with 1 day processing time',
                'price' => 10000,
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'description' => 'Premium laundry service with special treatment',
                'price' => 15000,
                'is_active' => true,
            ]
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
} 