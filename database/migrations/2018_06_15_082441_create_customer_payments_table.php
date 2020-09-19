<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->string('customer_number');
            $table->string('customer_name');
            $table->string('transaction_code');
            $table->string("account_number")->nullable();
            $table->string('product_type')->nullable();
            $table->string('shortages_in_litres')->nullable();
            $table->decimal('unit_price', 65, 2)->nullable();
            $table->decimal('litres_loaded', 65, 2)->nullable();
            $table->decimal('amount_paid', 65, 2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->decimal('total_cost', 65, 2)->nullable();
            $table->string('narration')->nullable();
            $table->decimal('balance', 65, 2)->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('customer_payments');
    }
}
