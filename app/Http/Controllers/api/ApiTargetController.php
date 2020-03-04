<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ApiTargetController extends Controller
{
	function index(Request $request)
	{
		$today = date('d');
		// $today = '1';
		$dataTarget = \App\TargetProduct::where('id_sales','=', $request->id_sales)
		// ->where('id_product','=', $request->id_product)
		->first();
		$trancaction = \App\DetailTransaction::select(DB::raw('CAST(SUM(quantity) AS UNSIGNED) AS trancaction'))
		->whereMonth('created_at','=', date('m'))
		->whereYear('created_at','=', date('Y'))
		->where('id_sales', '=', $request->id_sales)
		// ->where('id_product','=', $request->id_product)
		->first();

		$dayInMonth = date("t", strtotime(date('Y-m-d')));
		$target = $dataTarget->target;
		$remainingTarget = $dataTarget->target - $trancaction->trancaction;
		$targetDay = array_fill(0, $dayInMonth, 0);
		// return response()->json(['data' => array_slice($targetDay, 1, 3)]);
		while (true) {
			for ($i = 1; $i <= $dayInMonth; $i++) {
				$dayMonth = date('D', strtotime(date('Y-m-'.$i)));
				if ($dayMonth != 'Sat' && $dayMonth != 'Sun') {
					$targetDay[$i-1]++;
				}	
				if (array_sum($targetDay) >= $target) {
					break;
				}
			}
			if (array_sum($targetDay) >= $target) {
				break;
			}			
		}
		$remainingDayTrg = array_sum(array_slice($targetDay, (int)$today-1, $dayInMonth-((int)$today-1)));
		$data = [
				// 'days' =>  $this->getDayName(date('w', strtotime($days[$i]))),
			'today_target' => max($targetDay[(int)$today-1] + ($remainingTarget-$remainingDayTrg), 0),
			'remaining_target' => $remainingTarget
				// 'total_income' => $total_income,
				// 'completed_visitation' => $completed_visitation					
		];
		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		return response()->json(['meta' => $meta, 'data' => $data]);
	}
	
}
