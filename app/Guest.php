<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
 protected $fillable = [
        'guest_number',
        'guest_name',
        'phone_number',
        'created_by',
        'modified_by'
        ];
}
