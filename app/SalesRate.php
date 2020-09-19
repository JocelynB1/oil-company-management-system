<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesRate extends Model
{
        
		
     protected $fillable = [
        'selling_rate',
        'product_type',
        'created_by',
        'modified_by',
        'entry_date',
        'date_modified'
        ];

}
