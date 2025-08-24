<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'slagbaumas.algis@knf.stud.vu.lt',
            'password' => Hash::make('password'), // You should change this to a secure password
            'points' => 0,
            'email_verified_at' => now(),
        ]);

        // Create team members for the admin user (all named "Admin")
        Member::create([
            'user_id' => $adminUser->id,
            'name' => 'Admin',
        ]);

        Member::create([
            'user_id' => $adminUser->id,
            'name' => 'Admin 2',
        ]);

        Member::create([
            'user_id' => $adminUser->id,
            'name' => 'Admin 3',
        ]);
    }
}
