<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiReportController extends Controller
{
	function index(Request $request)
	{
		$today = '2020-02-26';
		// $yesterday = '2020-02-26';
		// $today = date('Y-m-d');
		// $yesterday = date('Y-m-d');
		$data = [];
		$yesterday = date_add(date_create($today),date_interval_create_from_date_string("-1 days"))->format('Y-m-d');

		// return 0;
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

		$report = \App\Transaction::select('visitation.days','transactions.total_income')
		->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
		->join('stores', 'stores.id', '=', 'visitation.id_store')
			// ->where('visitation.days','=', $days[$i])
		->where('visitation.id_sales', $request->id_sales)
		->where('transactions.id_sales', $request->id_sales)
		->whereBetween('transactions.created_at', [$yesterday, $today])
		->where('transactions.total_items', '>', '0')
		->get();

		// return response()->json(['data' => $today]);
		$i = 0;
		foreach ($report as $value) {
			$day = '';
			$total_income = 0;
			$completed_visitation = 0;
			if ($value->days != null) {			
				$oneday = $report->where('days',$value->days);	
				foreach ($oneday as $d) {
					$day = $value->days;
					$total_income += $d->total_income;
					$completed_visitation++;

				}
				foreach ($oneday as $del) {
					$del->days = null;	
				}

			}
			if ($day != '') {
				$data[$i] = [
					'days' => $day,
					'total_income' => $total_income,
					'completed_visitation' => $completed_visitation					
				];
				$i++;
			}
		}
		if (!empty($data)) {
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];

			return response()->json(['meta' => $meta, 'data' => $data]);
		}else{
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];

			for ($i = 0; $i < 2; $i++) {
				$data[$i] = [
					'days' => $this->getDayName(date('w', strtotime($days[$i]))),
					'total_income' => 0,
					'completed_visitation' => 0					
				];
			}
			
			return response()->json(['meta' => $meta, 'data' => $data]);
		}
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
}
