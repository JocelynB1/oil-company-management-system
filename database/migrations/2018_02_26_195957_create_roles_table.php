<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Description');
            $table->timestamps();
        });
          
        DB::table('roles')->insert([
            ['Description'=>'Administrator'],
            ['Description'=>'General manager'],
            ['Description'=>'Stock manager'],
            ['Description'=>'Human resources manager'],
            ['Description'=>'Accountant'],
            ['Description'=>'Rate manager'],
            ['Description'=>'Output manager'],
            ['Description'=>'Inventory manager'],
            ['Description'=>'Sales Rate Manager'],
            
        ]);
    }
public function users()
{
return $this->belongsToMany('User','users_roles');
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
