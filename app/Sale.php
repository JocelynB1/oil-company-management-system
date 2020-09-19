<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [
        'id',
    'supplier_name_from_inventory',
'supplier_name_and_number'
];
}
