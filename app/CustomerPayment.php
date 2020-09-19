<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    protected $guarded = [
        'id',
        'total_outstanding_balance',
        'net_outstanding_balance',
        'bank_name',
        'cheque_number',
        'payment_status',
        'total_shortage'
    ];
}
