<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    function index(Request $request)
    {
    	$data['request'] = $request;
    	$data['stock'] = null;
    	return \Template::display_gentelella('stock', 'Target', $data);
    }

    function getId(Request $request, $id)
    {
    	$data['request'] = $request;
    	$data['stock'] = \App\StockSales::select('users.id', 'users.name', 'stock_sales.id_sales', 'stock_sales.id_product', 'stock_sales.quantity', 'products.unit', 'products.name AS product')
		->join('users', 'users.id', '=', 'stock_sales.id_sales')
		->join('products', 'products.id', '=', 'stock_sales.id_product')
		->where('stock_sales.id_sales',$id)
		->get();
    	return \Template::display_gentelella('stock', 'Target', $data);
    }
}
