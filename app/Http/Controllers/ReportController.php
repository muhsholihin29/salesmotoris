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

		$data['tgl_start'] = $request->get('tgl_start', 0);
		$data['tgl_end'] = $request->get('tgl_end', 0);
		if ($data['report']) {
			return \Template::display_gentelella('report_sales', 'Target', $data);
		}else{
			return redirect('report_sales')->with('error', 'Data');
		}
	}

	function store(Request $request)
	{
		$data['request'] = $request;
		$store = \App\Store::where('status', '1') //approved store
		->get();
		$dateStart = $request->get('date_start', date('Y-m-1'));
		$dateEnd = $request->get('date_end', date('Y-m-d'));
		// $data['store'] = \App\Store::get();
		// echo(json_encode($store));
		$data['report_store'] = [];
		$data['date_picker'] = $this->tanggal_indo($dateStart).' - '. $this->tanggal_indo($dateEnd);
		
		foreach ($store as $st) {
			$report = \App\Transaction::select('stores.id as id_store', 'stores.name as store', DB::raw('COUNT(total_income) as transactions'))
			->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
			->join('stores', 'stores.id', '=', 'visitation.id_store')
			->where('id_store', $st->id)
			->where('transactions.total_items', '>', 0)
			->whereBetween('transactions.created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
			->first();
			if ($report->id_store == null) {
				$report = [
					"id_store" => $st->id,
					"store" => $st->name,
					"transactions" => 0
				];
			}
			array_push($data['report_store'], $report);
		}
		
		
		
		// echo(json_encode($data['report_store']));
		// return;
		$data['report'] = json_encode($data['report_store']);
		if ($store) {
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

	function tanggal_indo($tanggal)
	{
		if ($tanggal != 0) {
			
			$bulan = array (1 =>   
				'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
			$split = explode('-', $tanggal);
			return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		}
	}
}
