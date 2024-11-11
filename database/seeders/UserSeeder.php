<?php

namespace Database\Seeders;

use App\Enums\PermissionLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Invoice',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'permission_level' => PermissionLevel::SUPER_ADMIN,
        ]);
    }
}
