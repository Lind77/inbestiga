<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'title' => 'Inbestiga',
            'description' => 'Inbestiga is the best product ever created.',
            'term' => '0',
            'amount' => 0
        ]);

        DB::table('products')->insert([
            'title' => 'Proyecto de Tesis',
            'description' => '-',
            'term' => '1 mes',
            'amount' => 1000
        ]);
    }
}
