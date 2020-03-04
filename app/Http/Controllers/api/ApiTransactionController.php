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
		$transaction = \App\Transaction::select('transactions.id', 'stores.name AS store', 'stores.address', 'transactions.total_income', 'transactions.total_items', 'transactions.visitation_status')
		->join('visitation', 'visitation.id', '=', 'transactions.id_visitation')
		->join('stores', 'stores.id', '=', 'visitation.id_store')
		->where('visitation.days','=', $todayName)
		->whereDate('transactions.created_at','=', date('Y-m-d'))
		->get();

		if (count($transaction) == 0) {
			$meta = [
				'code' => Response::HTTP_NOT_FOUND, 
				'message' => 'Data tidak ada'
			];
			// return response()->json(['meta' => $meta]);
			$transaction = 'Tidak ada transaksi';
		}else{
			$meta = [
				'code' => Response::HTTP_OK, 
				'message' => 'Success'
			];
		}
		$data = [
			'day' => $todayName,
			'transaction' => $transaction
		];
		return response()->json(['meta' => $meta, 'data' => $data]);
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
			$name = 'transaction-'.$request->transaction_id.".".$image->getClientOriginalExtension();
			$image->move($destination_path, $name);

			$transaction = [
				'total_income' => $request->total_income,
				'total_items' => $request->total_items,
				'visitation_status' => 'DONE',
				'image' => $name
			];

			$detail_transaction = (json_decode($request->detail_transaction, true));
			foreach ($detail_transaction as $i=>$value) {
				$detail_transaction[$i]['id_transaction'] = $request->transaction_id;
				$stock = \App\Stock::where('id_product', $value['id_product'])
				->where('id_sales', $request->id_sales)->first();
				$updateStock = \App\Stock::where('id_product', $value['id_product'])
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
