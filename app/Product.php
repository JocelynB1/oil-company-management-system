<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_type',
        'created_by',
        'modified_by'
        ];
}
