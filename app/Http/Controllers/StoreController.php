<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;


class StoreController extends Controller
{
	function index(Request $request)
	{
		$data['request'] = $request;           
		$data['store'] = \App\Store::get();
		// echo(Auth::user()->email);
		return \Template::display_gentelella('store', 'Toko', $data);
            // return view('layouts.dashboard');
	}

	function approve(Request $request)
	{
		$approve = \App\Store::where('id','=', $request->id)->update(['status' => 1]);
		if ($approve) {
			return redirect('store')->with('approve', 'Data');	
		}else{
			return redirect('store')->with('error', 'Data');
		}
		
	}

	function update(Request $request)
	{
		
	}

	function delete(Request $request)
	{
		// $delete = \App\Store::where('id','=', $request->id)->delete();
		// if ($delete) {
		// 	return redirect('store')->with('del', 'Data');	
		// }else{
		// 	return redirect('store')->with('error', 'Data');
		// }
	}
}
