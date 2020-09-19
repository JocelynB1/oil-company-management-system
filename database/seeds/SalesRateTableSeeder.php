<?php

use Illuminate\Database\Seeder;

class SalesRateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\SalesRate::class, 200)->create();
        
    }
}
