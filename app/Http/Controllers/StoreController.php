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
}
