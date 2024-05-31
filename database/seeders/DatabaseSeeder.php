<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Role::create([
            'name' => 'admin',
        ]);
        \App\Models\Role::create([
            'name' => 'personel',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('secret'),
            'role_id' => 1,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'personel1',
            'email' => 'personel1@mail.com',
            'password' => bcrypt('secret'),
            'role_id' => 2,
        ]);
    }
}
