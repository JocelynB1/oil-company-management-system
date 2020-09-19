<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [
        'id',
        'supplier_name_from_inventory',
        'account_number',
        'net_outstanding_balance',
        'payment_status',
        "total_outstanding_balance"

    ];
}
