<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create super admin if not exists
        User::updateOrCreate(
            ['email' => 'superadmin@spog-kapal.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('SuperAdmin@2025'),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Super Admin created:');
        $this->command->line('   Email: superadmin@spog-kapal.com');
        $this->command->line('   Password: SuperAdmin@2025');
        $this->command->line('   ⚠️  Ganti password setelah login pertama!');
    }
}
