<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->date('sales_date');
            $table->string('customer_name')->nullable();
            $table->string('customer_number')->nullable();
            $table->decimal('litres_pumped', 65, 2)->nullable();
            $table->string('product_type')->nullable();
            $table->string('shortages')->nullable();
            $table->decimal('unit_price', 65, 2)->nullable();
            $table->float('cheque_number')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('discount_rate', 65, 2)->nullable();
            $table->string('cash_discount_allowed')->nullable();
            $table->decimal('total_cost', 65, 2)->nullable();
            $table->decimal('amount_paid', 65, 2)->nullable();
            $table->string("payment_status")->nullable();
            $table->decimal('balance', 65, 2)->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('stage_reached')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
