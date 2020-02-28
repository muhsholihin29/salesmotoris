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
		\App\Store::where('id','=', $request->id)->update(['status' => 1]);
		return redirect('store')->with('approve', 'Data');
	}

	function addStore(Request $request, $id)
	{
		$user = \App\User::find(1);

		// return $user->toJson();
		echo($id);
	}
	function zzz(Request $request)
	{
		// echo csrf_field();
	}
}
