<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('expense_category');
            $table->string('created_by');
            $table->timestamps();
        });
     

        DB::table('expenses')->insert([
            ['expense_category'=>'Cash to Director for Operations','created_by'=>'Administrator'],
            ['expense_category'=>'Salaries','created_by'=>'Administrator'],
            ['expense_category'=>'Travelling & Transport','created_by'=>'Administrator'],
            ['expense_category'=>'Human resources manager','created_by'=>'Administrator'],
            ['expense_category'=>'Moto Running Expense','created_by'=>'Administrator'],
            ['expense_category'=>'Cleaning & Sanitation','created_by'=>'Administrator'],
            ['expense_category'=>'Electricity & Water','created_by'=>'Administrator'],
            ['expense_category'=>'Chop Monies Paid','created_by'=>'Administrator'],
            ['expense_category'=>'Afiayah Project','created_by'=>'Administrator'],
            ['expense_category'=>'Asutwari Project','created_by'=>'Administrator'],
            ['expense_category'=>'Pumping Expenses','created_by'=>'Administrator'],
            ['expense_category'=>'State Security Tips','created_by'=>'Administrator'],
            ['expense_category'=>'Loading Charges','created_by'=>'Administrator'],
            ['expense_category'=>'Weekend Allowance','created_by'=>'Administrator'],
            ['expense_category'=>'Overtime Allowance','created_by'=>'Administrator'],
            ['expense_category'=>'Office Furniture','created_by'=>'Administrator'],
            ['expense_category'=>'Office Building Maintenance','created_by'=>'Administrator'],
            ['expense_category'=>'Indirect Opera Exp. (Protocall)','created_by'=>'Administrator'],
            ['expense_category'=>'Justice Harbor Load','created_by'=>'Administrator'],
            ['expense_category'=>'Administrative Expense','created_by'=>'Administrator'],
            ['expense_category'=>'Communication','created_by'=>'Administrator'],
            ['expense_category'=>'Asset- Equipt.','created_by'=>'Administrator'],
            ['expense_category'=>'Asset- Fixture& Fitting','created_by'=>'Administrator'],
            ['expense_category'=>'Asset- Moto Vehicl.','created_by'=>'Administrator'],
            ['expense_category'=>'General Repairs & Mainte.','created_by'=>'Administrator'],
            ['expense_category'=>'Donation','created_by'=>'Administrator']
            
        ]);

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
