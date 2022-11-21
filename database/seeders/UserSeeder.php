<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@biolink',
            'password' => bcrypt('Admin@123'),
            'active' => 1,
            'created_by' => 1
        ])->assignRole('Admin');

        User::create([
            'name' => 'User',
            'email' => 'user@biolink',
            'password' => bcrypt('User@123'),
            'active' => 1,
            'created_by' => 1
        ])->assignRole('User');
    }
}
