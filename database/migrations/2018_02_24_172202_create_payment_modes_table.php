<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentModesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_modes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_mode');
            $table->string('created_by');
            $table->string('modified_by');
            $table->timestamps();
        });

        DB::table('payment_modes')->insert([
            ['payment_mode'=>'Bank','created_by'=>'Administrator','modified_by'=>'Administrator'],
            ['payment_mode'=>'Transfer','created_by'=>'Administrator','modified_by'=>'Administrator'],
            ['payment_mode'=>'Cheque','created_by'=>'Administrator','modified_by'=>'Administrator'],
            ['payment_mode'=>'Credit','created_by'=>'Administrator','modified_by'=>'Administrator'],
            ['payment_mode'=>'Cash','created_by'=>'Administrator','modified_by'=>'Administrator'],
            ['payment_mode'=>'Prepaid','created_by'=>'Administrator','modified_by'=>'Administrator'],
            
            
        ]);
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments_mode');
    }
}
