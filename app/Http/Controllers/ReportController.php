<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
	function index(Request $request)
	{
		$data['request'] = $request;
  //   	$data['target_transaction'] = \App\Target::select('target.id', 'target.id_sales', 'target.target_omset', 'target.target_eff_call', DB::raw('COUNT(total_income) as eff_call'), 'users.name', DB::raw('SUM(total_income) AS income'))
		// ->join('users', 'users.id', '=', 'target.id_sales')
		// ->join('transactions', 'transactions.id_sales', '=', 'users.id')
		// ->whereYear('transactions.created_at','=', date('Y'))
		// ->whereMonth('transactions.created_at','=', date('m'))
		// ->get();

		$data['target'] = \App\Target::first();

		$data['report'] = \App\Transaction::select('users.id', 'users.name', DB::raw('COUNT(total_income) as eff_call'), DB::raw('SUM(total_income) AS income'))
		->join('users', 'users.id', '=', 'transactions.id_sales')
		->whereYear('transactions.created_at','=', date('Y'))
		->whereMonth('transactions.created_at','=', date('m'))
		->get();

		$data['pr_focus'] = \App\ProductFocus::select(DB::raw('SUM(target) AS pr_focus'))->first()->pr_focus;

		// foreach ($data['report'] as $forReport) {
		// 	foreach ($data['pr_focus'] as $forFocus) {
		// 		$prFocus = \App\DetailTransaction::select(DB::raw('SUM(quantity) AS quantity'))
		// 		->where('id_product', $forFocus->id_product)->first();
		// 	}
			
		// }

		// echo(json_encode($data['target']));

		if ($data['report']) {
			return \Template::display_gentelella('report_sales', 'Target', $data);
		}else{
			return redirect('report_sales')->with('error', 'Data');
		}
	}

	function store(Request $request)
	{
		$data['request'] = $request;
		$data['store'] = \App\Store::select('users.id', 'users.name', DB::raw('COUNT(total_income) as eff_call'), DB::raw('SUM(total_income) AS income'))
		->join('users', 'users.id', '=', 'transactions.id_sales')
		->whereYear('transactions.created_at','=', date('Y'))
		->whereMonth('transactions.created_at','=', date('m'))
		->get();
		$data['store'] = \App\Store::get();

		if ($data['store']) {
			return \Template::display_gentelella('report_store', 'Laporan Toko', $data);
		}else{
			return redirect('report_sales')->with('error', 'Data');
		}
	}

	function product(Request $request)
	{
		$data['request'] = $request;
		$data['product'] = \App\Product::get();
		if ($data['product']) {
			return \Template::display_gentelella('report_product', 'Laporan Produk', $data);
		}else{
			return redirect('report_sales')->with('error', 'Data');
		}	
	}
}
