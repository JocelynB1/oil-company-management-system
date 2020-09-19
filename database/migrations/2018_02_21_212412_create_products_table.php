<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_type');
            $table->string('created_by');
            $table->string('modified_by');
            $table->timestamps();
        });

        DB::table('products')->insert([
            ['product_type'=>'AGO','created_by'=>'Administrator','modified_by'=>'Administrator'],
            ['product_type'=>'PMS','created_by'=>'Administrator','modified_by'=>'Administrator'],
            ['product_type'=>'Nafta','created_by'=>'Administrator','modified_by'=>'Administrator'],
            ['product_type'=>'RFO','created_by'=>'Administrator','modified_by'=>'Administrator']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
