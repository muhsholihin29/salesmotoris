<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(Request $request)
    {
    	$data['request'] = $request;           
		$data['product'] = \App\Product::get();
		// echo(Auth::user()->email);
		return \Template::display_gentelella('Produk', 'Produk', $data);
            // return view('layouts.dashboard');
    }

    function addProduct(Request $request)
    {
    	
    }
}
