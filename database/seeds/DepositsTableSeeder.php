<?php

use Illuminate\Database\Seeder;

class DepositsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Deposit::class, 200)->create();
    }
}
