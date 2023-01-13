<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixedActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fixed_activities')->insert([
            'product_id' => 1,
            'title' => 'Primer Contacto',
            'type' => '0'
        ]);

        DB::table('fixed_activities')->insert([
            'product_id' => 1,
            'title' => 'Asignar Equipo',
            'type' => '0'
        ]);

        DB::table('fixed_activities')->insert([
            'product_id' => 1,
            'title' => 'Programar primera reunión con Dirección Académica',
            'type' => '0'
        ]);

        DB::table('fixed_activities')->insert([
            'product_id' => 1,
            'title' => 'Reunión con dirección académica',
            'type' => '0'
        ]);

        /* DB::table('fixed_activities')->insert([
            'product_id' => 2,
            'title' => 'Introducción',
            'type' => '1'
        ]);

        DB::table('fixed_activities')->insert([
            'product_id' => 2,
            'title' => 'Marco Teórico',
            'type' => '1'
        ]); */
    }
}
