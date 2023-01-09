<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(RoleSeeder::class);

        \App\Models\User::factory()->create([
             'name' => 'Jair Pariona',
             'email' => 'riuyagami@gmail.com',
             'password' => '$2a$12$S.WKj5Mm0ein0CQzc6dyPOOjMyzxJjJWX/KA.bS8cQ75Gja77sP3y'
        ])->assignRole('Admin');

        $this->call(ProductSeeder::class);
        $this->call(FixedActivitySeeder::class);
        $this->call(FixedTaskSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(TeamSeeder::class);
    }
}
