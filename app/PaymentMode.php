<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    protected $fillable = [
        'payment_mode',
        'created_by',
        'modified_by'
        ];
}