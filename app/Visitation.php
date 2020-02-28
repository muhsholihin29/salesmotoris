<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitation extends Model
{
    protected $table = 'visitation';
    protected $fillable = ['days','id_store'];
}
