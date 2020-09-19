<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalLitres extends Model
{
    protected $guarded = ['id'];
    public $table = 'total_litres';
}
