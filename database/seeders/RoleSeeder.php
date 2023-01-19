<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!Admin::where('email', 'admin@gmail.com')->exists()) {
        	Admin::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@123'),
            ]);
        }

        if (!User::where('email', 'developerindiit@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'developerindiit@gmail.com',
                'password' => Hash::make('admin@123'),
            ]);
        }

        if (!Role::where('name', 'buyer')->exists()) {
            Role::create(['name' => 'buyer']);
        }

        if (!Role::where('name', 'influencer')->exists()) {
        	Role::create(['name' => 'influencer']);
        }
    }
}
