<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
        		
    protected $fillable = [
        'transaction_date',
        'customer_name',
        'account_number',
        'refund_amount',
        'payment_mode',
        'created_by',
        'transaction_code',
        'approval_status'
        ];

}
