<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        Package::create([
            'name' => 'Basic Wash',
            'description' => 'Basic washing and drying service',
            'price' => 15000,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'Premium Wash',
            'description' => 'Premium washing with ironing service',
            'price' => 25000,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'Express Service',
            'description' => 'Same day service with premium washing and ironing',
            'price' => 35000,
            'is_active' => true,
        ]);
    }
} 