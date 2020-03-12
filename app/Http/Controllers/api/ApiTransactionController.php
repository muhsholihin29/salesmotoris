<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTransactionController extends Controller
{
	function index(Request $request)
	{

		$todayName = $this->getDayName(date('w', strtotime(date('Y-m-d'))));
		// $todayName = 'Rabu';


		$visitation = \App\Visitation::select('visitation.id', 'visitation.days', 'visitation.id_store', 'stores.name AS store', 'stores.address')
		// ->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
		->join('stores', 'stores.id', '=', 'visitation.id_store')
		->where('days','=', $todayName)
		->where('id_sales','=', $request->id_sales)
		->get();
		

		foreach ($visitation as $i=>$vis) {
			$idVisit = $vis->id;
			$transaction = \App\Transaction::where('id_visitation', $vis->id)
			->where('id_sales','=', $request->id_sales)
			->whereDate('created_at','=', date('Y-m-d'))
			->first();
			// return response()->json(['data' => $visitation]);
			if ($transaction['total_income'] > 0) {
				$vis->id = $transaction['id'];
				$vis->total_income = $transaction['total_income'];
				$vis->total_items = $transaction['total_items'];
				$vis->id_visitation = $idVisit;
				$vis->visitation_status = 'DONE';				
			}else{
				$vis->id = 0;
				$vis->total_income = 0;
				$vis->total_items = 0;
				$vis->id_visitation = $idVisit;
				$vis->visitation_status = 'NOT_YET';
			}

			// unset($vis['id_store']);
		}
		return response()->json(['data' => $visitation]);
		// return response()->json(['meta' => $meta, 'data' => $data]);

		$meta = [
			'code' => Response::HTTP_OK, 
			'message' => 'Success'
		];
		return response()->json(['meta' => $meta, 'data' => $visitation]);
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
		
		if ($request->hasFile('image')) {
			$image = $request->file('image');  
			$destination_path = public_path('/transaction_image');
			$nameImg = 'transaction-'.$request->transaction_id.".".$image->getClientOriginalExtension();

			$dataTransaction = [
				'id_sales' => $request->id_sales,
				'id_visitation' => $request->id_visitation,
				'total_income' => $request->total_income,
				'total_items' => $request->total_items,
				'visitation_status' => 'DONE',
				'image' => $nameImg
			];

			if ($request->transaction_id == 0) {
				$transaction = \App\Transaction::create($dataTransaction)->id;
				$transaction_id = $transaction;
				$nameImg = 'transaction-'.$transaction_id.".".$image->getClientOriginalExtension();
				$transaction = \App\Transaction::where('id', $transaction_id)->update(['image' => $nameImg]);
			}else{
				$transaction = \App\Transaction::where('id', $request->transaction_id)->update($dataTransaction);
				$transaction_id = $request->transaction_id;
				$del_transaction = \App\DetailTransaction::where('id_transaction', $transaction_id)->delete();
			}

			$image->move($destination_path, $nameImg);
			$detail_transaction = (json_decode($request->detail_transaction, true));
			foreach ($detail_transaction as $i=>$value) {
				$detail_transaction[$i]['id_transaction'] = $transaction_id;
				$detail_transaction[$i]['created_at'] = date('Y-m-d H:i:s');
				$stock = \App\StockSales::where('id_product', $value['id_product'])
				->where('id_sales', $request->id_sales)->first();
				$updateStock = \App\StockSales::where('id_product', $value['id_product'])
				->where('id_sales', $request->id_sales)
				->update(['quantity' => $stock->quantity-$value['quantity']]);
			// echo($stock->quantity);
				if (!$updateStock) {
					return response()->json([
						'code' => Response::HTTP_METHOD_FAILURE, 
						'message' => 'Gagal disimpan'
					]);
				}
			}
			
			$insert = \App\DetailTransaction::insert($detail_transaction);
			if (!$transaction || !$insert) {
				return response()->json([
					'code' => Response::HTTP_METHOD_FAILURE, 
					'message' => 'Gagal disimpan'
				]);
			}
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];
		}else{
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'gagal'
			];
			
		}
		return response()->json(['meta' => $meta]);
	}

	function create(Request $request)
	{
		
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
