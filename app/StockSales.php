<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSales extends Model
{
    protected $table = 'stock_sales';
    protected $fillable = ['id_sales', 'id_product','quantity'];
}
