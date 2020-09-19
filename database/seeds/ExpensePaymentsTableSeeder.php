<?php

use Illuminate\Database\Seeder;

class ExpensePaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\ExpensePayment::class, 200)->create();
        
    }
}
