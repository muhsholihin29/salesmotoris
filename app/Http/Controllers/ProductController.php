<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    function index(Request $request)
    {
    	$data['request'] = $request;
        $data['product'] = \App\Product::get();
        return \Template::display_gentelella('product', 'Produk', $data);
            // return view('layouts.dashboard');
    }

    function addUpdate(Request $request)
    {
        echo json_encode($request);
        if ($request->id > 0) {
            $update = \App\Product::where('id','=', $request->id)->update($request->except(['_token']));
            
            if ($update) {
                return redirect('product')->with('update', 'Data');    
            }else{
                return redirect('product')->with('error', 'Data');
            } 
        }else{
            $add = \App\Product::create($request->except(['_token','id']));
            if ($add) {
                return redirect('product')->with('add', 'Data');    
            }else{
                return redirect('product')->with('error', 'Data');
            }

        }
    }

    function getEdit(Request $request, $id)
    {
        $product = \App\Product::where('id', $id)->first();
        echo json_encode($product);
    }

    function delete(Request $request)
    {
        $delDetail = \App\DetailTransaction::where('id_product','=', $request->id)->delete();
        $delStock = \App\StockSales::where('id_product','=', $request->id)->delete();
        $delTrgFocus = \App\ProductFocus::where('id_product','=', $request->id)->delete();
        $del = \App\Product::where('id','=', $request->id)->delete();
        if ($delDetail && $delStock && $delTrgFocus && $del) {
            return redirect('product')->with('delete', 'Data');   
        }else{
            return redirect('product')->with('error', 'Data');
        }
    }
}
