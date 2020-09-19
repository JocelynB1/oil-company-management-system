<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'account_number',
        'created_by',
       'current_balance',
       'date_of_last_transaction'
       

        ];
}
