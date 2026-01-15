<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed akun admin default
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kopikeling.com'],
            [
                'email'    => 'admin@kopikeling.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('Admin seeder berhasil: admin@kopikeling.com / admin123');
    }
}
