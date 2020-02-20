<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Maps extends Controller
{
    function index()
    {
    	return view('map');
    }
}
