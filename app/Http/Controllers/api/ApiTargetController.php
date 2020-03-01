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
		$dataTarget = \App\TargetProduct::where('id_sales','=', $request->id_sales)
		->where('id_product','=', $request->id_product)
		->first();
		$trancaction = \App\DetailTransaction::select(DB::raw('CAST(SUM(quantity) AS UNSIGNED) AS trancaction'))
		->whereMonth('created_at','=', date('m'))
		->whereYear('created_at','=', date('Y'))
		->where('id_sales', '=', $request->id_sales)
		->where('id_product','=', $request->id_product)
		->first();


		$dayInMonth = date("t", strtotime(date('Y-m-d')));
		// $day = 6;
		// $target = 61;
		$target = $dataTarget->target;
		$remainingTarget = $dataTarget->target - $trancaction->trancaction;
		
		// return response()->json(['data' => $remainingTarget]);
		// echo(date('Y-m-'.$day));
		$targetDay = array_fill(0, $dayInMonth, 0);
		// return response()->json(['data' => array_slice($targetDay, 1, 3)]);
		while (true) {
			for ($i = 1; $i <= $dayInMonth; $i++) {
				$dayMonth = date('D', strtotime(date('Y-m-'.$i)));
				if ($dayMonth != 'Sat' && $dayMonth != 'Sun') {
					$targetDay[$i-1]++;
				}	
				// echo($dayMonth);
				if (array_sum($targetDay) >= $target) {
					break;
				}
			}
			if (array_sum($targetDay) >= $target) {
				break;
			}
			
		}
		$remainingTargetDay = (array_slice($targetDay, '03', $dayInMonth-(int)'03'));
		return response()->json(['data' => $remainingTargetDay]);
	}
	
}
