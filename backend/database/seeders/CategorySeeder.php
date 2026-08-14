<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Category options straight from PRD section 5.2 form spec
     * ("Facility, IT Hardware, Plumbing, Electrical, HVAC").
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Facility', 'code' => 'FACILITY'],
            ['name' => 'IT Hardware', 'code' => 'IT_HARDWARE'],
            ['name' => 'Plumbing', 'code' => 'PLUMBING'],
            ['name' => 'Electrical', 'code' => 'ELECTRICAL'],
            ['name' => 'HVAC', 'code' => 'HVAC'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['code' => $category['code']],
                $category + ['is_active' => true]
            );
        }
    }
}
