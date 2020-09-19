<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->string('supplier_name');
            $table->string('supplier_number');
            $table->string('truck_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('product_type');
            $table->decimal('litres_loaded', 65, 2);
            $table->string('created_by');
            $table->string('supplier_rate');
            $table->string('total_cost');
            $table->string('modified_by');
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
        Schema::dropIfExists('inventories');
    }
}
