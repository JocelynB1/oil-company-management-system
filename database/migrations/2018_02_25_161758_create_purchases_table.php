<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_name')->nullable();
            $table->string('supplier_number')->nullable();
            $table->string('product_type')->nullable();
            $table->string('truck_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->decimal('litres_loaded', 65, 2)->nullable();
            $table->decimal('shortages_in_litres', 65, 2)->nullable();
            $table->decimal('total_shortage', 65, 2)->nullable();
            $table->decimal('unit_price', 65, 2)->nullable();
            $table->decimal('net_loading_in_litres', 65, 2)->nullable();
            $table->decimal('price_per_litre', 65, 2)->nullable();
            $table->decimal('total_cost', 65, 2)->nullable();
            $table->decimal('amount_paid', 65, 2)->nullable();
            $table->decimal('balance', 65, 2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('narration')->nullable();
            $table->string('transaction_code')->nullable();
            $table->timestamp('transaction_date')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
        /*
        Schema::table('purchases', function (Blueprint $table){


        $table->foreign('supplier_name')->references("supplier_name")->on("suppliers");
        $table->foreign('product_type')->references("product_type")->on("products");
        });
        */
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
