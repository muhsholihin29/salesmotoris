<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $fillable = ['id_product','quantity'];
}
