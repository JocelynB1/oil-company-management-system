<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('expense_category');
            $table->date('transaction_date');
            $table->string('invoice_number')->nullable();
            $table->decimal('amount', 65, 2);
            $table->string('narration')->nullabe();
            $table->string('payment_to');
            $table->string('customer_type');
            $table->string('cheque_number')->nullable();
            $table->string('payment_mode');
            $table->string('bank_name')->nullable();
            $table->string('created_by');
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
        Schema::dropIfExists('expense_payments');
    }
}
