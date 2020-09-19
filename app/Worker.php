<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = [
        'employee_number',
        'employee_name',
        'phone_number',
        'type',
        'created_by',
        'modified_by'
        ];
}
