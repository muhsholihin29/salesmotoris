<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'target';
    protected $fillable = ['id_sales','target_omset','target_eff_call'];
}
