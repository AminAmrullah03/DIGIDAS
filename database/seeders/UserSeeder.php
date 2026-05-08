<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production') && ! env('SEED_SUPERADMIN_PASSWORD')) {
            $this->command?->warn('Skipping UserSeeder in production. Set SEED_SUPERADMIN_PASSWORD to create/update the initial admin.');
            return;
        }

        User::updateOrCreate(
            ['nip' => env('SEED_SUPERADMIN_NIP', 'SA0001')],
            [
                'name'     => env('SEED_SUPERADMIN_NAME', 'Super Admin'),
                'password' => Hash::make(env('SEED_SUPERADMIN_PASSWORD', 'superadmin123')),
                'role'     => User::ROLE_SUPERADMIN,
            ]
        );

        if (! app()->environment('production')) {
            User::updateOrCreate(
                ['nip' => 'GR0001'],
                [
                    'name'     => 'Guru Demo',
                    'password' => Hash::make('guru123'),
                    'role'     => User::ROLE_GURU,
                ]
            );
        }
    }
}
