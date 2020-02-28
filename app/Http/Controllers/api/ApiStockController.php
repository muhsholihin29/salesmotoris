<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiStockController extends Controller
{
    function index(Request $request)
    {

    	$stock = \App\Stock::select('products.name AS product', 'products.price', 'stock.quantity')->join('products', 'products.id', '=', 'stock.id_product')->get();
        $meta = [
            'code' => Response::HTTP_OK, 
            'message' => 'Success'
        ];
        return response()->json(['meta' => $meta, 'data' => $stock]);
    }

    function update(Request $request) 
    { 
        $currentStock = \App\Stock::where('id', $request->product_id)->first(); 
        $updatedStock = $currentStock['quantity'] - $request->number_of_fetches; 
        $stock = \App\Stock::where('id', $request->product_id)->update(['quantity' => $updatedStock]); 
        if ($stock) { 
            $meta = [ 
                'code' => Response::HTTP_OK, 
                'message' => 'Success' 
            ]; 
            return response()->json(['meta' => $meta]); 
        }else{ 
            return response()->json([ 
                'code' => Response::HTTP_METHOD_FAILURE, 
                'message' => 'Gagal disimpan' 
            ]); 
        } 
    }
}