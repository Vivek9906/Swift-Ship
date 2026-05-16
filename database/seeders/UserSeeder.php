<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['Ops Admin', 'admin@logistics.test', 'admin'],
            ['Riya Manager', 'riya.manager@logistics.test', 'manager'],
            ['Arjun Manager', 'arjun.manager@logistics.test', 'manager'],
            ['Meera Viewer', 'meera.viewer@logistics.test', 'viewer'],
            ['Kabir Viewer', 'kabir.viewer@logistics.test', 'viewer'],
        ];

        foreach ($users as [$name, $email, $role]) {
            User::updateOrCreate(['email' => $email], [
                'name' => $name,
                'password' => Hash::make('password'),
                'role' => $role,
                'email_verified_at' => now(),
            ]);
        }
    }
}
