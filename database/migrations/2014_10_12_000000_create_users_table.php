<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        
        DB::table('users')->insert([
            ['name'=>'Administrator','password'=>Hash::make('Administrator'),'email'=>'Administrator@Administrator.com'],
            ['name'=>'General manager','password'=>Hash::make('General manager'),'email'=>'Generalmanager@Generalmanager.com'],
            ['name'=>'Stock manager','password'=>Hash::make('Stock manager'),'email'=>'Stockmanager@Stockmanager.com'],
            ['name'=>'Humanresourcesmanager','password'=>Hash::make('Humanresourcesmanager'),'email'=>'Humanresourcesmanager@Humanresourcesmanager.com'],
            ['name'=>'Accountant','password'=>Hash::make('Accountant'),'email'=>'Accountant@Accountant.com'],
            ['name'=>'Rate manager','password'=>Hash::make('Rate manager'),'email'=>'Ratemanager@Ratemanager.com'],
            ['name'=>'Output manager','password'=>Hash::make('Output manager'),'email'=>'Outputmanager@Outputmanager.com'],
            ['name'=>'Inventory manager','password'=>Hash::make('Inventory manager'),'email'=>'inventorymanager@inventorymanager.com'],
            ['name'=>'Sales Rate Manager','password'=>Hash::make('Sales Rate Manager'),'email'=>'salesratemanager@salesratemanager.com'],
             
            
        ]);
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }


 
 }

