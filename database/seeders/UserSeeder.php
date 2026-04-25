<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Superadmin ────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'superadmin@digidas.test'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('superadmin123'),
                'role'     => User::ROLE_SUPERADMIN,
            ]
        );

        // ── Guru ──────────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'guru@digidas.test'],
            [
                'name'     => 'Guru Demo',
                'password' => Hash::make('guru123'),
                'role'     => User::ROLE_GURU,
            ]
        );
    }
}