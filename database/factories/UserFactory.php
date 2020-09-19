<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\BankAccount::class, function (Faker $faker) {
    return [
        'bank_name' => $faker->colorName(),
        'account_number' => mt_rand(0,1000),
        'created_by' => $faker->name,
        'current_balance' => mt_rand(0,1000),
        'date_of_last_transaction'=>$faker->dateTime(),
        'updated_at'=>$faker->dateTime(),
        'created_at'=>$faker->dateTime(),
    ];
});

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'customer_number' => mt_rand(0,1000),
        'customer_name' => $faker->name,
        'company_name' => $faker->colorName(),
        'phone_number' => mt_rand(0,1000),
        'created_by' => $faker->name,    
        'modified_by' => $faker->name,            
        'updated_at'=>$faker->dateTime(),
        'created_at'=>$faker->dateTime(),
    ];
});

$factory->define(App\Deposit::class, function (Faker $faker) {
    return [
        'transaction_date' => $faker->dateTime(),
        'bank_name' => $faker->colorName(),
        'account_number' => mt_rand(0,1000),
        'transaction_code' => $faker->colorName(),
        'amount' => $faker->name,    
        'narration' => $faker->sentence,            
        'created_by' => $faker->name,                 
        'updated_at'=>$faker->dateTime(),
        'created_at'=>$faker->dateTime(),
    ];
});

$factory->define(App\ExpensePayment::class, function (Faker $faker) {
    return [
        'expense_category' =>  $faker->colorName(),
        'transaction_date' => $faker->dateTime(),
        'invoice_number' => mt_rand(0,1000),
        'amount' => mt_rand(0,1000),
        'narration' => $faker->sentence,    
        'payment_to' => $faker->name,            
        'payment_mode' => $faker->name,                 
        'bank_name' => $faker->name,                 
        'created_by' => $faker->name,                 
        'updated_at'=>$faker->dateTime(),
        'created_at'=>$faker->dateTime(),
    ];
});


$factory->define(App\Inventory::class, function (Faker $faker) {
    return [
        'supplier_name' =>  $faker->name,
        'truck_number' => mt_rand(0,1000),
        'driver_name' => $faker->name,
        'driver_phone' => mt_rand(0,1000),
        'product_type' => $faker->ColorName(),
        'litres_loaded' =>  mt_rand(0,1000),    
        'modified_by' => $faker->name,            
        'created_by' => $faker->name,                 
        'updated_at'=>$faker->dateTime(),
        'created_at'=>$faker->dateTime(),
    ];
});

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
        'supplier_name' =>  $faker->name,
        'product_type' => mt_rand(0,1000),
        'truck_number' => $faker->name,
        'driver_name' => $faker->name,
        'litres_loaded' => mt_rand(0,1000),
        'shortages_in_litres' =>  mt_rand(0,1000),    
        'net_loading_in_litres' =>  mt_rand(0,1000),    
        'price_per_litre' => mt_rand(0,1000),            
        'total_cost' => mt_rand(0,1000),            
        'amount_paid' => mt_rand(0,1000),                 
        'balance'=>mt_rand(0,1000),
        'payment_mode'=>$faker->name,
        'bank_name'=>$faker->ColorName(),
        'cheque_number'=>mt_rand(0,1000),
        "narration"=>$faker->sentence,
        "transaction_code"=>$faker->name,
        "transaction_date"=>$faker->dateTime(),
        "supplier_number"=>$faker->name,
        "created_at"=>$faker->dateTime(),
        "updated_at"=>$faker->dateTime(),
        
    ];
});


$factory->define(App\Sale::class, function (Faker $faker) {
    return [
        'sales_date' =>  $faker->dateTime(),
        'customer_name' => $faker->name,
        'customer_number' => mt_rand(0,1000),
        'litres_pumped' => mt_rand(0,1000),
        'product_type' => $faker->name,
        'shortages' =>  mt_rand(0,1000),    
        'unit_price' =>  mt_rand(0,1000),    
        'payment_mode' => $faker->name,            
        'bank_name' => $faker->name,            
        'supplier_name' => $faker->name,                 
        'description'=>$faker->name,
        'discount_rate'=>mt_rand(0,1000),
        'cash_discount_allowed'=>$faker->ColorName(),
        'total_cost'=>mt_rand(0,1000),
        "amount_paid"=>mt_rand(0,1000),
        "balance"=>mt_rand(0,1000),
        "transaction_code"=>$faker->ColorName(),
        "stage_reached"=>$faker->ColorName(),
        "created_at"=>$faker->dateTime(),
        "updated_at"=>$faker->dateTime(),
        
    ];
});


$factory->define(App\Refund::class, function (Faker $faker) {
    return [
        'transaction_date' =>  $faker->dateTime(),
        'customer_name' => $faker->name,
        'account_number' => mt_rand(0,1000),
        'refund_amount' => mt_rand(0,1000),
        'payment_mode' => $faker->name,
        'created_by' =>  $faker->name,    
        'transaction_code' =>  mt_rand(0,1000),    
        'approval_status' => $faker->name,            
        "created_at"=>$faker->dateTime(),
        "updated_at"=>$faker->dateTime(),
        
    ];
});


$factory->define(App\SalesRate::class, function (Faker $faker) {
    return [
        'selling_rate' => mt_rand(0,1000),
        'product_type' => $faker->ColorName(),
        'created_by' => $faker->name,
        'modified_by' => $faker->name,
        "created_at"=>$faker->dateTime(),
        "updated_at"=>$faker->dateTime(),
        
    ];
});


$factory->define(App\Supplier::class, function (Faker $faker) {
    return [
        'supplier_number' => mt_rand(0,1000),
        'supplier_name' => $faker->name,
        'company_name' => $faker->name,
        'phone_number' => mt_rand(0,1000),
        "created_by"=>$faker->name,
        'modified_by' => $faker->name,
        "created_at"=>$faker->dateTime(),
        "updated_at"=>$faker->dateTime(),
        
    ];
});

$factory->define(App\Withdrawal::class, function (Faker $faker) {
    return [
        'transaction_date' => $faker->dateTime(),
        'bank_name' => $faker->name,
        'account_number' => mt_rand(0,1000),
        'transaction_code' =>$faker->name,
        "amount"=>mt_rand(0,1000),
        'narration' => $faker->sentence,
        'created_by' => $faker->name,
        "created_at"=>$faker->dateTime(),
        "updated_at"=>$faker->dateTime(),
        
    ];
});
