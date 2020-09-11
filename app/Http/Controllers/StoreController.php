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

	function getEdit(Request $request, $id)
	{
		$product = \App\Store::where('id', $id)->first();
        echo json_encode($product);
	}

	function update(Request $request)
	{
		$update = \App\Store::where('id','=', $request->id)->update($request->except(['_token']));
            
            if ($update) {
                return redirect('store')->with('update', 'Data');    
            }else{
                return redirect('store')->with('error', 'Data');
            } 
	}

	function delete(Request $request)
	{
		
		$idVisitation = \App\Visitation::where('id_store', $request->id)->first();
		if (!empty($idVisitation)) {
			$idVisitation = $idVisitation->id;
		}
		$idTransaction = \App\Transaction::select('id')->where('id_visitation', $idVisitation)->get();

		foreach ($idTransaction as $i) {
			$delDetailTrans = \App\DetailTransaction::where('id_transaction', $i->id)->delete();			
			// if (!$delDetailTrans) {
			// 	return redirect('store')->with('error', 'Data');	
			// }
		}		
		$delTrans = \App\Transaction::where('id_visitation', $idVisitation)->delete();			
		$delVisit = \App\Visitation::where('id_store', $request->id)->delete();			
		$delStore = \App\Store::where('id','=', $request->id)->delete();
		// echo(json_encode($idTransaction));
		// return;
		
		if ($delStore) {
			return redirect('store')->with('del', 'Data');	
		}else{
			return redirect('store')->with('error', 'Data');
		}
	}
}
