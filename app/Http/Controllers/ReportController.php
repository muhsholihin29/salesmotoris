<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;

class ReportController extends Controller
{
	function index(Request $request) //sales
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
		->groupBy('users.id')
		->join('users', 'users.id', '=', 'transactions.id_sales')
		->whereYear('transactions.created_at','=', date('Y'))
		->whereMonth('transactions.created_at','=', date('m'))
		->get();

		$data['target']->pr_focus = \App\ProductFocus::select('target_product_focus.id_product', 'target_product_focus.target', 'products.name AS product')->join('products', 'products.id', '=', 'target_product_focus.id_product')->get();
		$pr_focus_total = \App\ProductFocus::select('id_product', 'target',DB::raw('SUM(target) AS pr_focus'))->first()->pr_focus;

		$i = 0;
		
		foreach ($data['report'] as $forReport) {
			$report = [];
			foreach ($data['target']->pr_focus as $forFocus) {				
				$pr_focus = \App\DetailTransaction::select('detail_transactions.id_product', 'transactions.id_sales', DB::raw('(SUM(detail_transactions.quantity)) AS quantity'))
				->groupBy('detail_transactions.id_product')
				->join('transactions', 'transactions.id', '=', 'detail_transactions.id_transaction')
				->where('transactions.id_sales', $forReport->id)
				->where('detail_transactions.id_product', $forFocus->id_product)
				->whereYear('detail_transactions.created_at','=', date('Y'))
				->whereMonth('detail_transactions.created_at','=', date('m'))
				->first();

				if ($pr_focus != null && $pr_focus->id_product != null) {
					$pr_focus->remain = $forFocus->target - $pr_focus->quantity;
					array_push($report, $pr_focus);						
				}else {
					$pr = (object)[
						"id_product" => $forFocus->id_product,
						"quantity" => "0",
						"remain" => $forFocus->target
					];
					array_push($report, $pr);
				}
				// echo(json_encode($pr_focus));
				// return;
			}
			$forReport->pr_focus_remain = $report;
		}

		
		echo(json_encode($data));
		return;
		
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

	function daily(Request $request)
	{
		$data['request'] = $request;
		$dateStart = $request->get('date_start', date('Y-m-d'));
		$dateEnd = $request->get('date_end', date('Y-m-d'));
		// $data['store'] = \App\Store::get();
		// echo(json_encode($store));
		$data['report_store'] = [];
		$data['date_picker'] = $this->tanggal_indo($dateStart).' - '. $this->tanggal_indo($dateEnd);
		$data['report'] = \App\Transaction::select('users.id', 'users.name', 'stores.name AS store', 'transactions.total_income', 'transactions.id AS id_transaction', 'transactions.image', 'transactions.created_at AS date')
		->join('users', 'users.id', '=', 'transactions.id_sales')
		->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
		->join('stores', 'stores.id', '=', 'visitation.id_store')
		// ->join('detail_transactions', 'detail_transactions.id', '=', 'transactions.id')
		->whereBetween('transactions.created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
		->get();

		foreach ($data['report'] as $forReport) {
			$forReport->date = $this->tanggal_indo($forReport->date);

			$forReport->product = \App\DetailTransaction::select('detail_transactions.id_product', 'detail_transactions.quantity', 'products.name AS product', 'detail_transactions.sub_total')
			->join('products', 'products.id', '=', 'detail_transactions.id_product')
			->where('id_transaction', $forReport->id_transaction)
			->get();
			// $data['report']->product = 
		}

		// echo(json_encode($data['report']));
		// return;


		//Export excel
		
		// $dateStart = $request->get('date_start', date('Y-m-d'));
		// $dateEnd = $request->get('date_end', date('Y-m-d'));
		// $dateStart = $request->get('date_start', date('2020-09-03'));
		// $dateEnd = $request->get('date_end', date('2020-09-03'));
		// $data['store'] = \App\Store::get();
		// echo(json_encode($store));
		$sales = \App\User::where('level', 'sales')->get();
		// echo(json_encode($sales));
		
			$dbReport = \App\Transaction::select('users.id AS sales_id', 'users.name', 'stores.id AS store_id', 'stores.name AS store', 'transactions.total_income', 'transactions.id AS id_transaction', 'transactions.image', 'transactions.created_at AS date')
			->join('users', 'users.id', '=', 'transactions.id_sales')
			->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
			->join('stores', 'stores.id', '=', 'visitation.id_store')
		
			->whereBetween('transactions.created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
			->get();
		
		
		$dataExcel = [];
		$idSalesInDaily = 0;
		foreach ($sales as $sal) {
			$detailTrx = [];
			$dataStore = [];
			foreach ($dbReport as $dbRep) {			
				if ($dbRep->sales_id == $sal->id){
					$idSalesInDaily = $dbRep->sales_id;
					$dbReportDetail = \App\DetailTransaction::where('id_transaction', $dbRep->id_transaction)
					->get();
					foreach ($dbReportDetail as $ProductDetail) {
						$ProductDetail->product = \App\Product::select('name', 'unit')
						->where('id', $ProductDetail->id_product)
						->first();
					}					
					$detailTrx = $dbReportDetail;
				
				array_push($dataStore, [
					'id_store' => $dbRep->store_id,
					'store' => $dbRep->store,
					'income' => $dbRep->total_income,
					'products' => $detailTrx
				]);
				}
			}
			if ($idSalesInDaily == $sal->id){
				array_push($dataExcel, [
					'id_sales' => $sal->id,
					'name' => $sal->name,
					'transactions' => $dataStore
				]);
			}
		}
		$data['expExcel'] = json_decode(json_encode($dataExcel, true));
		//\Export excel

		$mDateStart = new DateTime($dateStart);
		$mDateEnd = new DateTime($dateEnd);
		if ($data['report'] == '[]') {
			$data['error'] = 'empty';
		}else if ($mDateStart->diff($mDateEnd)->format("%a") > 0){
			$data['error'] = 'date_invalid';
		}else{
			$data['error'] = '';
		}
		// echo(json_encode($data));
		
		// return;

		if ($data['report']) {
			return \Template::display_gentelella('report_daily', 'Laporan Harian', $data);
		}else{
			return redirect('report_sales')->with('error', 'Data');
		}	
	}

	function print(Request $request)
	{
		$data['request'] = $request;
		// $dateStart = $request->get('date_start', date('Y-m-d'));
		// $dateEnd = $request->get('date_end', date('Y-m-d'));
		$dateStart = $request->get('date_start', date('2020-09-03'));
		$dateEnd = $request->get('date_end', date('2020-09-03'));
		// $data['store'] = \App\Store::get();
		// echo(json_encode($store));
		$sales = \App\User::where('level', 'sales')->get();
		$data['report_store'] = [];
		$data['date_picker'] = $this->tanggal_indo($dateStart).' - '. $this->tanggal_indo($dateEnd);
		// echo(json_encode($sales));
		
			$dbReport = \App\Transaction::select('users.id AS sales_id', 'users.name', 'stores.id AS store_id', 'transactions.total_income', 'transactions.id AS id_transaction', 'transactions.image', 'transactions.created_at AS date')
			->join('users', 'users.id', '=', 'transactions.id_sales')
			->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
			->join('stores', 'stores.id', '=', 'visitation.id_store')
			// ->join('products', 'products.id', '=', 'visitation.products')
			// ->join('detail_transactions', 'detail_transactions.id', '=', 'transactions.id')
			->whereBetween('transactions.created_at', [$dateStart." 00:00:00", $dateEnd." 23:59:59"])
			->get();
		// echo(json_encode($dbReport));	
		// return;
		$dataExcel = [];
		$idSalesInDaily = 0;
		foreach ($sales as $sal) {
			$detailTrx = [];
			$dataStore = [];
			foreach ($dbReport as $dbRep) {			
				if ($dbRep->sales_id == $sal->id){
					$idSalesInDaily = $dbRep->sales_id;
					$dbReportDetail = \App\DetailTransaction::where('id_transaction', $dbRep->id_transaction)
					->get();
					foreach ($dbReportDetail as $ProductDetail) {
						$ProductDetail->product = \App\Product::select('id', 'name AS product')
						->where('id', $ProductDetail->id_product)
						->first()->product;
					}					
					$detailTrx = $dbReportDetail;
				
				array_push($dataStore, [
					'id_store' => $dbRep->store_id,
					'products' => $detailTrx
				]);
				}
			}
			if ($idSalesInDaily == $sal->id){
				array_push($dataExcel, [
					'id_sales' => $sal->id,
					'transactions' => $dataStore
				]);
			}
		}

		// echo(json_encode($dataExcel));
		
		// return;

		// foreach ($data['report'] as $forReport) {
		// 	$forReport->date = $this->tanggal_indo($forReport->date);

		// 	$forReport->product = \App\DetailTransaction::select('detail_transactions.id_product', 'detail_transactions.quantity', 'products.name AS product', 'detail_transactions.sub_total')
		// 	->join('products', 'products.id', '=', 'detail_transactions.id_product')
		// 	->where('id_transaction', $forReport->id_transaction)
		// 	->get();
		// 	// $data['report']->product = 
		// }

		// echo(json_encode($data['report']));
		// return;
		if ($data['report']) {
			return \Template::display_gentelella('report_daily', 'Laporan Produk', $data);
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
			$tanggal = substr($tanggal,0,10);
			$split = explode('-', $tanggal);
			return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		}
	}
}
