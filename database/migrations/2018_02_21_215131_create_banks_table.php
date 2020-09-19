<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name')->unique();
            $table->string('created_by');
            $table->timestamps();
        });
        

        DB::table('banks')->insert([
            ['bank_name'=>'Access Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'ADB Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Bank of Africa Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Bank of Baroda Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'BSIC Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Barclays Bank of Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'CAL Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Ecobank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Energy Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'FBNBank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Fidelity Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'First Atlantic Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'First National Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'GCB Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Guaranty Trust Bank (Ghana) Limited','created_by'=>'Administrator'],
            ['bank_name'=>'HFC Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'National Investment Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Prudential Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Société Générale Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Stanbic Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Standard Chartered Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'The Royal Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'UniBank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'United Bank for Africa Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Universal Merchant Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Zenith Bank Ghana','created_by'=>'Administrator'],
            ['bank_name'=>'Sovereign Bank Ghana','created_by'=>'Administrator'],
            ['bank_name'=>'Premium Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'OmniBank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'Heritage Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'The Construction Bank Ghana Limited','created_by'=>'Administrator'],
            ['bank_name'=>'The Beige Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>'GHL Bank Limited','created_by'=>'Administrator'],
            ['bank_name'=>' Citibank','created_by'=>'Administrator'],
            ['bank_name'=>'Ghana International Bank','created_by'=>'Administrator'],
            ['bank_name'=>'Export–Import Bank of Korea','created_by'=>'Administrator'],
            ['bank_name'=>'Bank of Beirut','created_by'=>'Administrator'],
            ['bank_name'=>'ARB Apex Bank Limited','created_by'=>'Administrator']
            
        ]);
 
    }

    
    
    
    


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
}
