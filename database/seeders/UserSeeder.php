<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['nip' => 'SA0001'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('superadmin123'),
                'role'     => User::ROLE_SUPERADMIN,
            ]
        );

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