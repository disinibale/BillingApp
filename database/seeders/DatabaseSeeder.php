<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(RolesAndPermissionSeeder::class);

        $users = User::create([
            'name' => 'Tiara',
            'email' => 'tiara@mail.com',
            'password' => bcrypt('password')
        ])->assignRole('user');

        $admin = User::create([
            'name' => 'Admin Tiara',
            'email' => 'admin.tiara@mail.com',
            'password' => bcrypt('password')
        ])->assignRole('admin');

    }
}
