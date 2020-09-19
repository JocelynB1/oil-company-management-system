<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('role_id');
            $table->timestamps();
        });

        DB::table('users_roles')->insert([
            ['user_id'=>'1','role_id'=>'1'],
            ['user_id'=>'2','role_id'=>'2'],
            ['user_id'=>'3','role_id'=>'3'],
            ['user_id'=>'4','role_id'=>'4'],
            ['user_id'=>'5','role_id'=>'5'],
            ['user_id'=>'6','role_id'=>'6'],
            ['user_id'=>'7','role_id'=>'7'],
            ['user_id'=>'8','role_id'=>'8'],   
            ['user_id'=>'9','role_id'=>'9']
            
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
}
