<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BankAccountsTableSeeder::class);
         $this->call(CustomersTableSeeder::class);
         $this->call(DepositsTableSeeder::class);
         $this->call(ExpensePaymentsTableSeeder::class);
         $this->call(InventoryTableSeeder::class);
         $this->call(PurchasesTableSeeder::class);
         $this->call(SalesTableSeeder::class);
         $this->call(RefundTableSeeder::class);
         $this->call(SalesRateTableSeeder::class);
         $this->call(SuppliersTableSeeder::class);
         $this->call(WithdrawalTableSeeder::class);
     
         // $this->call(UsersTableSeeder::class);
    }
}
