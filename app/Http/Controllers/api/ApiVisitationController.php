<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiVisitationController extends Controller
{
	function index(Request $request)
	{

		$day = ['Senin','Selasa','Rabu','Kamis','Jumat'];
		$data = (object)[];
		foreach ($day as $i=>$d) {
			$visitation = \App\Visitation::select('stores.name AS stores')
			->join('stores', 'stores.id', '=', 'visitation.id_store')
			->where('visitation.days','=', $d)
			->get()->toArray();

			$data->$d = array_column($visitation, 'stores');
		}
		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		
		return response()->json(['meta' => $meta, 'data' => $data]);
	}
}
