<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('selling_rate', 65, 2);
            $table->string('product_type');
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->date("entry_date")->nullable();
            $table->timestamps();
        });

        /*
        DB::table('sales_rates')->insert([
            ['product_type'=>'AGO','selling_rate'=>1],
            ['product_type'=>'Nafta','selling_rate'=>1],
            ['product_type'=>'PMS','selling_rate'=>1],
            ['product_type'=>'RFO','selling_rate'=>1],
        ]);
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_rates');
    }
}
