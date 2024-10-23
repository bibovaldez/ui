<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => config('user.super_admin.email'),
            'password' => Hash::make(config('user.super_admin.password')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ])->assignRole('super_admin');

        // Create Sub Admin
        User::create([
            'name' => 'Sub Admin',
            'email' => config('user.sub_admin.email'),
            'password' => Hash::make(config('user.sub_admin.password')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ])->assignRole('sub_admin');

        // Create Regular User
        User::create([
            'name' => 'User',
            'email' => config('user.user.email'),
            'password' => Hash::make(config('user.user.password')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ])->assignRole('user');

    }
}