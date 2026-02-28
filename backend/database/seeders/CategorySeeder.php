<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Software & IT',
            'Design & Creative',
            'Marketing & Sales',
            'Accounts & Finance',
            'HR & Admin',
            'Customer Support',
            'Engineering',
            'Education & Training',
            'Healthcare',
            'Logistics & Supply Chain',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
