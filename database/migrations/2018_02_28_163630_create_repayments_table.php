<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_reference_number');
            $table->date('transaction_date');
            $table->string('client_name');
            $table->string('client_account_number');
            $table->decimal('outstanding_balance', 65, 2);
            $table->decimal('repayment_amount', 65, 2);
            $table->decimal('current_balance', 65, 2);
            $table->string('created_by');
            $table->string('transaction_codes');
            $table->string('transaction_description');
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
        Schema::dropIfExists('repayments');
    }
}
