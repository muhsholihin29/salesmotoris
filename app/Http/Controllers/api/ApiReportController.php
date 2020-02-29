<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ApiReportController extends Controller
{
	function index(Request $request)
	{
		// $today = '2020-02-25';
		$today = date('Y-m-d');
		$data = [];
		$yesterday = date_add(date_create($today),date_interval_create_from_date_string("-1 days"))->format('Y-m-d');

		if (date('D', strtotime($today)) == 'Sat' || date('D', strtotime($today)) == 'Sun') {
			$today = date("Y-m-d", strtotime('thursday this week')); 
			$yesterday = date("Y-m-d", strtotime('wednesday this week')); 
		}
		else if (date('D', strtotime($yesterday)) == ('Sun')) {
			$yesterday = date_add(date_create($today),date_interval_create_from_date_string("-3 days"))->format('Y-m-d');
		}
        // return response()->json(['data' => $yesterday]);
		$days = array(
			$yesterday,
			$today
		);

		for ($i = 0; $i < count($days); $i++) {		
			$report = \App\Transaction::select('visitation.days','transactions.total_income')
			->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
			->join('stores', 'stores.id', '=', 'visitation.id_store')
			->whereDate('transactions.created_at','=', $days[$i])
			->where('transactions.id_sales', '=', $request->id_sales)
			->where('transactions.total_items', '>', 0)
			->get();

			$total_income = 0;
			$completed_visitation = 0;
			foreach ($report as $rep) {
				$total_income += $rep->total_income;
				$completed_visitation++;
			}
			$data[$i] = [
				'days' =>  $this->getDayName(date('w', strtotime($days[$i]))),
				'total_income' => $total_income,
				'completed_visitation' => $completed_visitation					
			];
		}

		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		return response()->json(['meta' => $meta, 'data' => $data]);
	}

	function monthly(Request $request)
	{
		$from = explode('-',$request->from);
		$to = explode('-',$request->to);
		// return $from[0];
		// return response()->json(['data' => date_create('1-'.$request->from)]);
		// return date_create($request->from);

		$mo = date_diff(date_create('1-'.$request->from), date_create('1-'.$request->to))->format('%m');
		
		$fromMonth = $request->from;
		$month = $from[0];
		$year = $from[1];
		// $request->to;
		for ($i = 0; $i < $mo+1; $i++) {			
			$report[$i] = \App\Transaction::select(DB::raw('SUM(total_income) AS income'), DB::raw('CAST(SUM(total_items) AS UNSIGNED) AS total_product'))
			->whereMonth('created_at','=', $month)
			->whereYear('created_at','=', $year)
			->where('id_sales', '=', $request->id_sales)
			->first();

			$report[$i]->month = $this->getMonthName($month);
			$report[$i]->year = (int)$year;
			if ($month >= 12) {
				$month = 1;
				$year++;
			}else {
				$month++;	
			}
		}
		

		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		return response()->json(['meta' => $meta, 'data' => $report]);
	}

	function getDayName($dayOfWeek) {

		switch ($dayOfWeek){
			case 0:
			return 'Minggu';
			case 1:
			return 'Senin';
			case 2:
			return 'Selasa';
			case 3:
			return 'Rabu';
			case 4:
			return 'Kamis';
			case 5:
			return 'Jumat';
			case 6:
			return 'Sabtu';
			default:
			return '';
		}
	}

	function getMonthName($month) {

		switch ($month){
			case 1:
			return 'Januari';
			case 2:
			return 'Februari';
			case 3:
			return 'Maret';
			case 4:
			return 'April';
			case 5:
			return 'Mei';
			case 6:
			return 'Juni';
			case 7:
			return 'Juli';
			case 8:
			return 'Agustus';
			case 9:
			return 'September';
			case 10:
			return 'Oktober';
			case 11:
			return 'November';
			case 12:
			return 'Desember';
			default:
			return '';
		}
	}
}
