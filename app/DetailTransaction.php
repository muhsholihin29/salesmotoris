<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $table = 'detail_transactions';
    protected $fillable = ['id_transaction','id_product','quantity','sub_total'];
}
