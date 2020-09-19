<?php

use Illuminate\Database\Seeder;

class RefundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Refund::class, 200)->create();
        
    }
}
