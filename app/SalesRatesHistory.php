<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesRatesHistory extends Model
{
    protected $fillable = [
        "id",
        'selling_rate',
        'product_type',
        'created_by',
        'modified_by',
        'entry_date',
        'date_modified'
        ];

}
