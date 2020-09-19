<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Supplier extends Model
{
  
    protected $fillable = [
        'supplier_number',
        'supplier_name',
        'company_name',
        'phone_number',
        'created_by',
        'modified_by'
    
        ];
}
