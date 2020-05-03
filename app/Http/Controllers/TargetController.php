<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class TargetController extends Controller
{
	function index(Request $request)
	{
		$data['request'] = $request;
		
		$data['product_focus'] = \App\ProductFocus::select('target_product_focus.id', 'target_product_focus.id_product', 'target_product_focus.target', 'products.name')
		->join('products', 'products.id', '=', 'target_product_focus.id_product')
		->get();

		$data['product'] = \App\Product::select('products.id', 'products.name', 'target_product_focus.id_product')
		->join('target_product_focus', 'target_product_focus.id_product', '=', 'products.id', 'left outer')
		->where('target_product_focus.id_product', '=', null)
		->get();	
		$data['target'] = \App\Target::first();
		// echo json_encode($data['product']);


		if ($data['product_focus']) {
			return \Template::display_gentelella('target_income', 'Target', $data);
		}else{
			return redirect('target_income')->with('error', 'Data');
		}
	}

	function getEdit()
	{
		$target = \App\Target::first();
		echo json_encode($target);
	}

	function update(Request $request)
	{
		$update = \App\Target::where('id','=', $request->id)->update($request->except(['_token']));
		if ($update) {
			return redirect('target')->with('update', 'Data');    
		}else{
			return redirect('target')->with('error', 'Data');
		} 
	}

	function prFocusGetEdit($id)
	{
		$target = \App\ProductFocus::where('id', $id)->first();
		$target->name = \App\Product::select('name')->where('id', $target->id_product)->first()->name;
		echo json_encode($target);
	}

	function prFocusAddUpdate(Request $request)
	{
		if ($request->id > 0) {
            $update = \App\ProductFocus::where('id','=', $request->id)->update($request->except(['_token']));
            if ($update) {
                return redirect('target')->with('update', 'Data');    
            }else{
                return redirect('target')->with('error', 'Data');
            } 
        }else{
            $add = \App\ProductFocus::create($request->except(['_token','id']));
            if ($add) {
                return redirect('target')->with('add', 'Data');    
            }else{
                return redirect('target')->with('error', 'Data');
            }

        }
	}

	function prFocusDel(Request $request)
	{
		$del = \App\ProductFocus::where('id','=', $request->id)->delete();
        if ($del) {
            return redirect('target')->with('delete', 'Data');   
        }else{
            return redirect('target')->with('error', 'Data');
        }
	}
}
