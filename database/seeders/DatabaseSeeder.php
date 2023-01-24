<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Memoir;
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

        $user1 = \App\Models\User::factory()->create([
             'name' => 'Jair Pariona',
             'email' => 'riuyagami@gmail.com',
             'password' => '$2a$12$S.WKj5Mm0ein0CQzc6dyPOOjMyzxJjJWX/KA.bS8cQ75Gja77sP3y'
        ])->assignRole('Admin');

        Memoir::create([
            'user_id' => $user1->id,
            'area' => 'admin'
        ]);

        $user2 = \App\Models\User::factory()->create([
            'name' => 'Berenice',
            'email' => 'ventas@gmail.com',
            'password' => '$2a$12$fFXGRX43WileiQFiKeeLte/3EC9oEEMode1mksa/wUGnWbrmzPAKW'
        ])->assignRole('Seller');

        Memoir::create([
        'user_id' => $user2->id,
        'area' => 'sales'
        ]);

        $user3 = \App\Models\User::factory()->create([
        'name' => 'Eduardo',
        'email' => 'edu@inbestiga.com',
        'password' => '$2a$12$S.H8l6XSNTc/tSAzJUcZz.T1Fvn7p.b8.b9SyQO5A1gfR5T8ZsKqK' //hola
        ])->assignRole('AdminAcad');

        Memoir::create([
        'user_id' => $user3->id,
        'area' => 'acad'
        ]);

        \App\Models\User::factory()->create([
        'name' => 'Anto',
        'email' => 'anto@inbestiga.com',
        'password' => '$2a$12$S.H8l6XSNTc/tSAzJUcZz.T1Fvn7p.b8.b9SyQO5A1gfR5T8ZsKqK'
        ])->assignRole('Acad');
        

        $this->call(ProductSeeder::class);
        $this->call(FixedActivitySeeder::class);
        $this->call(FixedTaskSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(TeamSeeder::class);
    }
}
