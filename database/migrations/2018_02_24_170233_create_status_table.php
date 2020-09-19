<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('created_by');
            $table->timestamps();
        });

      
        DB::table('status')->insert([
            ['description'=>'Successful','created_by'=>'Administrator'],
            ['description'=>'Failed','created_by'=>'Administrator'],
            ['description'=>'Incomplete','created_by'=>'Administrator'],
            ['description'=>'Pending Approval','created_by'=>'Administrator'],
            ['description'=>'Rejected','created_by'=>'Administrator']
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
