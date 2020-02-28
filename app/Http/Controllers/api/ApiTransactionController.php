<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTransactionController extends Controller
{
	function index(Request $request)
	{
		if ($request->has('day')){
			$transaction = \App\Transaction::select('transactions.id', 'visitation.days', 'stores.name AS store', 'stores.address', 'transactions.total_income', 'transactions.total_items', 'transactions.visitation_status')
			->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
			->join('stores', 'stores.id', '=', 'visitation.id_store')
			->where('visitation.days','=', $request->day)
			->get();

			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];
			$data = [
				'day' => $request->day,
				'transaction' => $transaction
			];
			return response()->json(['meta' => $meta, 'data' => $data]);
		}
	}

	function getDetail(Request $request, $id)
	{
		$transaction = \App\Transaction::select('total_income', 'image')->where('id', $id)->first();
		$detail = \App\DetailTransaction::select('products.name AS product', 'products.price', 'products.unit', 'detail_transactions.quantity', 'detail_transactions.sub_total')
		->join('products', 'products.id', '=', 'detail_transactions.id_product')
		->where('id_transaction', $id)->get();
		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		$data = [
			'detail_transaction' => $detail,
			'total_income' => $transaction['total_income'],
			'image' => $transaction['image'],
		];

		return response()->json(['meta' => $meta, 'data' => $data]);
	}

	function update(Request $request)
	{
		$transaction = [
			'total_income' => $request->total_income,
			'total_items' => $request->total_items,
			'visitation_status' => 'DONE'
		];
		
		$detail_transaction = $request->detail_transaction;
		foreach ($detail_transaction as $i=>$value) {
			$detail_transaction[$i]['id_transaction'] = $request->transaction_id;
		}
		$insert = \App\DetailTransaction::insert($detail_transaction);
		$update = \App\Transaction::where('id', $request->transaction_id)->update($transaction);
		if (!$update || !$insert) {
			return response()->json([
				'code' => Response::HTTP_METHOD_FAILURE, 
				'message' => 'Gagal disimpan'
			]);
		}
		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		return response()->json(['meta' => $meta]);
	}
}
