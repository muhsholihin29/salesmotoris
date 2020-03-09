<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFocus extends Model
{
    protected $table = 'target_product_focus';
    protected $fillable = ['id_sales','id_product','target'];
}
