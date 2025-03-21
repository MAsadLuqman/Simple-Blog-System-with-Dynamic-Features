<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create(['name' => 'admin', 'email' => 'admin@admin.com', 'password' => Hash::make('admin123')]);
        $admin->assignRole('admin');
        $user = User::create(['name' => 'user', 'email' => 'user@user.com', 'password' => Hash::make('user123')]);
        $user->assignRole('user');
    }
}
