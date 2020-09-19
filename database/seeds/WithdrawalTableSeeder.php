<?php

use Illuminate\Database\Seeder;

class WithdrawalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Withdrawal::class, 200)->create();
        
    }
}
