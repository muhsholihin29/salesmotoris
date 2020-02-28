<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiProductController extends Controller
{
    function index(Request $request)
    {
    	$product = \App\Product::get();
		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		return response()->json(['meta' => $meta, 'data' => $product]);
    }
}
