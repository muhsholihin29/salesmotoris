<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
	function login(Request $request)
	{
		$user = \App\User::select('id', 'api_token', 'username', 'email', 'password', 'level')
		->where('username','=', $request->username)
		->where('level','=', $request->level)->first();   
		// echo($request->level)     ;
		if (password_verify($request->password, $user['password'])) {
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];

			return response()->json(['meta' => $meta, 'data' => $user]);
		}
		else{
			return response()->json([
				'code' => Response::HTTP_NOT_FOUND, 
				'message' => 'Wrong '
			]);
		}
	}

	function register(Request $request)
	{
		// return base64_encode(random_bytes(32));
		$user = \App\User::get();        
		foreach ($user as $usr) {
			if ($usr['username'] == $request->username) {
				return response()->json([
					'code' => Response::HTTP_NOT_ACCEPTABLE, 
					'message' => 'Username sudah terdaftar '
				]);
			}else if($usr['email'] == $request->email){
				return response()->json([
					'code' => Response::HTTP_NOT_ACCEPTABLE, 
					'message' => 'Email sudah terdaftar'
				]);
			}
		}		
		$data = $request->all();
		$data['password'] = password_hash($request->password, PASSWORD_DEFAULT);
		$data['api_token'] = base64_encode(random_bytes(32));
		if(\App\User::create($data)){
			return response()->json([
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			]);
		}else {
			return response()->json([
				'code' => Response::HTTP_METHOD_FAILURE, 
				'message' => 'Gagal'
			]);
		}
	}
}
