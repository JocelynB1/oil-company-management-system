<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_code');
            $table->string('transaction_description');
            $table->string('created_by');
            $table->timestamps();
        });

        DB::table('trans_codes')->insert([
            ['transaction_code'=>'CAS','transaction_description'=>'Cash Sales','created_by'=>'Administrator'],
            ['transaction_code'=>'DRP','transaction_description'=>'Debt Repayment','created_by'=>'Administrator'],
            ['transaction_code'=>'WDL','transaction_description'=>'Bank Withdrawal','created_by'=>'Administrator'],
            ['transaction_code'=>'CDP','transaction_description'=>'Cash Deposit','created_by'=>'Administrator'],
            ['transaction_code'=>'CHD','transaction_description'=>'Check Deposit','created_by'=>'Administrator'],
            ['transaction_code'=>'RFD','transaction_description'=>'Refund','created_by'=>'Administrator'],
            ['transaction_code'=>'DOB','transaction_description'=>'Debt Opening Balance','created_by'=>'Administrator'],
            ['transaction_code'=>'OTH','transaction_description'=>'Others','created_by'=>'Administrator']
            
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_codes');
    }
}
