<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransCode extends Model
{
    protected $fillable = [
        'transaction_code',
        'transaction_description',
        'created_by'
        ];




}
