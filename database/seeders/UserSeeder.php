<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $kasirRole = Role::where('name', 'kasir')->first();

        User::updateOrCreate(
            ['email' => 'raula@gmail.com'],
            [
                'name' => 'Rauleiei',
                'password' => Hash::make('password'),
                'role_id' => $adminRole?->id ?? 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'loisa@gmail.com'],
            [
                'name' => 'Loieiei',
                'password' => Hash::make('password'),
                'role_id' => $kasirRole?->id ?? 2,
            ]
        );
    }
}
