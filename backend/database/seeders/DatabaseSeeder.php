<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SlaConfigSeeder::class,
            CategorySeeder::class,
        ]);

        // One test account per role so login/RBAC can be tested locally
        // without a full onboarding flow. Password for all: "password".
        $accounts = [
            ['name' => 'Admin GA', 'email' => 'admin@example.com', 'role' => User::ROLE_ADMIN],
            ['name' => 'Teknisi Satu', 'email' => 'technician@example.com', 'role' => User::ROLE_TECHNICIAN],
            ['name' => 'Pelapor Satu', 'email' => 'reporter@example.com', 'role' => User::ROLE_REPORTER],
            ['name' => 'Management Exec', 'email' => 'management@example.com', 'role' => User::ROLE_MANAGEMENT],
        ];

        foreach ($accounts as $account) {
            User::factory()->create([
                'name' => $account['name'],
                'email' => $account['email'],
                'role' => $account['role'],
                'is_active' => true,
            ]);
        }
    }
}
