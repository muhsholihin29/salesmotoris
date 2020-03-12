<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
	public $timestamps = true;
	protected $table = 'detail_transactions';
	protected $fillable = ['id_sales','id_transaction','id_product','quantity','sub_total'];
}
