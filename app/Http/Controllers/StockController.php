<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    function index(Request $request)
    {
    	$data['request'] = $request;
    	$data['stock'] = null;
    	$data['sales'] = \App\User::where('level','sales')->get();

		$data['product'] = [];
    	return \Template::display_gentelella('stock', 'Target', $data);
    }

    function getId(Request $request, $id)
    {
    	$data['request'] = $request;
    	$data['sales'] = \App\User::where('level','sales')->get();
    	$data['stock'] = \App\StockSales::select('users.id', 'users.name', 'stock_sales.id', 'stock_sales.id_sales', 'stock_sales.id_product', 'stock_sales.quantity', 'products.unit', 'products.name AS product')
		->join('users', 'users.id', '=', 'stock_sales.id_sales')
		->join('products', 'products.id', '=', 'stock_sales.id_product')
		->where('stock_sales.id_sales',$id)
		->get();
		$product = \App\Product::select('products.id', 'products.name', 'stock_sales.id_product', 'stock_sales.id_sales')
		->join('stock_sales', 'stock_sales.id_product', '=', 'products.id')
		->where('stock_sales.id_sales', '=', $id)
		->get();
		$notStock = []; 
		foreach ($product as $pr) {
			array_push($notStock, $pr->id);
		}
		$data['product'] = \App\product::whereNotIn('id', $notStock)->get();
    	return \Template::display_gentelella('stock', 'Target', $data);
    }

    function addUpdate(Request $request)
    {	
    	if ($request->id > 0) {
            $update = \App\StockSales::where('id','=', $request->id)->update($request->except(['_token']));
            if ($update) {
                return redirect('stock/'.$request->id_sales)->with('update', 'Data');    
            }else{
                return redirect('stock/'.$request->id_sales)->with('error', 'Data');
            } 
        }else{
            $add = \App\StockSales::create($request->except(['_token','id']));
            if ($add) {
                return redirect('stock/'.$request->id_sales)->with('add', 'Data');    
            }else{
                return redirect('stock/'.$request->id_sales)->with('error', 'Data');
            }

        }
    }

    function getEdit($id)
    {
    	$stock = \App\StockSales::select('stock_sales.id_sales', 'stock_sales.id_product', 'stock_sales.quantity', 'products.name AS product', 'products.unit')
		->join('products', 'products.id', '=', 'stock_sales.id_product')
		->where('stock_sales.id',$id)
		->first();
    	echo(json_encode($stock));
    }

    function delete(Request $request)
    {
    	$del = \App\StockSales::where('id',$request->id)->delete();
    	if ($del) {
            return redirect('stock/'.$request->id_sales)->with('delete', 'Data');   
        }else{
            return redirect('stock/'.$request->id_sales)->with('error', 'Data');
        }
    }
}
