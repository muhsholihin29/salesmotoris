<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiStoreController extends Controller
{
	function index(Request $request)
	{
		$store = \App\Store::get();
		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		return response()->json(['meta' => $meta, 'data' => $store]);
	}

	function getById(Request $request, $id)
	{
		$store = \App\Store::where('id', $id)->get();
		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		return response()->json(['meta' => $meta, 'data' => $store]);
	}

	function create(Request $request)
	{		
		if (($request->lonCurrent && $request->lonStore && $request->latCurrent && $request->latStore) != '') {
			$lonCurrent = ($request->lonCurrent);
			$lonStore = ($request->lonStore);
			$latCurrent = ($request->latCurrent);
			$latStore = ($request->latStore);

			$theta = $lonCurrent - $lonStore;
			$dist = sin(deg2rad($latCurrent)) * sin(deg2rad($latStore)) +  cos(deg2rad($latCurrent)) * cos(deg2rad($latStore)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$meter = round($dist * 60 * 1.1515 * 1609.344);
			// return response()->json(['meta' => $request->lonCurrent]);
			if ($meter <= 100) {
				$store['name'] = $request->name;
				$store['address'] = $request->address;
				$store['coordinate'] = strval($request->latStore) . ', ' . strval($request->lonStore);			
				if(\App\Store::create($store)){
					return response()->json([
						'code' => Response::HTTP_OK, 
						'message' => 'Success'
					]);
				}
				return response()->json([
					'code' => Response::HTTP_METHOD_FAILURE, 
					'message' => 'Gagal disimpan'
				]);
			}
			return response()->json([
				'code' => Response::HTTP_NOT_ACCEPTABLE, 
				'message' => 'Jarak melebihi'
			]);
		}else{
			return response()->json([
				'code' => Response::HTTP_NO_CONTENT, 
				'message' => 'Koordinat belum dipilih'
			]);
		}
	}
}
