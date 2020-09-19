<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesRatesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_rates_histories', function (Blueprint $table) {
            $table->string('id')->nullable();
            $table->decimal('selling_rate', 65, 2)->nullable();
            $table->string('product_type')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->date("entry_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_rates_histories');
    }
}
