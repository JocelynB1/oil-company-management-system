<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_number',
        'customer_name',
        'company_name',
        'phone_number',
        'created_by',
        'modified_by',
       'id'
        ];

}
