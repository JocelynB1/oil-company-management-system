<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->string('customer_name');
            $table->string('customer_number');
            $table->string('account_number');
            $table->decimal('refund_amount', 65, 2);
            $table->string('payment_mode');
            $table->string("bank_name");
            $table->string("cheque_number");
            $table->string('created_by');
            $table->string('transaction_code');
            $table->string('approval_status');
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
        Schema::dropIfExists('refunds');
    }
}
