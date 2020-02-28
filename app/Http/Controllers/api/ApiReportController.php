<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiReportController extends Controller
{
	function index(Request $request)
	{
		$days = array(
			$request->yesterday,
			$request->today
		);
		for ($i = 0; $i < count($days); $i++) {		
			$report = \App\Transaction::select('visitation.days','transactions.total_income')
			->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
			->join('stores', 'stores.id', '=', 'visitation.id_store')
			->where('visitation.days','=', $days[$i])
			// ->orWhere('visitation.days','=', $request->today)
			->where('transactions.visitation_status', '=', 'DONE')
			->get();

			$total_income = 0;
			$completed_visitation = 0;
			foreach ($report as $rep) {
				$total_income += $rep->total_income;
				$completed_visitation++;
			}
			$data[$i] = [
				'days' => $days[$i],
				'total_income' => $total_income,
				'completed_visitation' => $completed_visitation					
			];
		}
		// $today = \App\Transaction::select('transactions.total_income')
		// ->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
		// ->join('stores', 'stores.id', '=', 'visitation.id_store')
		// ->where('visitation.days','=', $request->today)
		// ->where('transactions.visitation_status', '=', 'DONE')
		// ->get();

		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		
		return response()->json(['meta' => $meta, 'data' => $data]);
	}
}
