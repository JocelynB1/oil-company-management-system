<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trn_ref_no')->unique();
            $table->date('transaction_date');
            $table->string('product_type')->nullable();
            $table->decimal('liters', 65, 2)->nullable();
            $table->decimal('rate', 65, 2)->nullable();
            $table->decimal('total_cost', 65, 2)->nullable();
            $table->decimal('amount_paid', 65, 2)->nullable();
            $table->decimal('balance', 65, 2)->nullable();
            $table->string('narration')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('shortages')->nullable();
            $table->string('supplier_name')->nullable();
            $table->decimal('unit_price', 65, 2)->nullable();
            $table->string('supplier_rate', 65, 2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('expense_category')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('discount_rate', 65, 2)->nullable();
            $table->decimal('cash_discount_allowed', 65, 2)->nullable();
            $table->string('approval_status')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('account_number')->nullable();
            $table->string('posted_from')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
