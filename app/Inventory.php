<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'supplier_number',
        'supplier_name',
        'truck_number',
        'driver_name',
        'driver_phone',
        'product_type',
        'litres_loaded',
        'transaction_date',
        'total_cost',
        'unit_price',
        'created_by',
        "supplier_rate",
        'modified_by'
        ];
}
