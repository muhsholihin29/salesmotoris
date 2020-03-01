<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetProduct extends Model
{
    protected $table = 'target_product';
    protected $fillable = ['id_sales','id_product','target'];
}
