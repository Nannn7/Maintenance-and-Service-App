<?php

namespace Database\Seeders;

use App\Models\SlaConfig;
use Illuminate\Database\Seeder;

class SlaConfigSeeder extends Seeder
{
    /**
     * SLA matrix straight from PRD section 3.2.
     */
    public function run(): void
    {
        $matrix = [
            ['priority_level' => 'urgent', 'response_time_minutes' => 15, 'resolution_time_minutes' => 120],
            ['priority_level' => 'high', 'response_time_minutes' => 30, 'resolution_time_minutes' => 240],
            ['priority_level' => 'medium', 'response_time_minutes' => 120, 'resolution_time_minutes' => 720],
            ['priority_level' => 'low', 'response_time_minutes' => 240, 'resolution_time_minutes' => 1440],
        ];

        foreach ($matrix as $row) {
            SlaConfig::updateOrCreate(
                ['priority_level' => $row['priority_level']],
                $row
            );
        }
    }
}
