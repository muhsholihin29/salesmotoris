<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitationController extends Controller
{
	function index(Request $request)
	{
		$data['request'] = $request;
		$data['sales'] = \App\User::where('level','sales')->get();
		$data['visit'] = [];
		$data['store'] = [];
		return \Template::display_gentelella('visitation', 'Target', $data);
	}

	function getId(Request $request, $idSales)
	{
		$data['request'] = $request;
		$data['sales'] = \App\User::where('level','sales')->get();
		$data['visit'] = \App\Visitation::select('visitation.id','visitation.id_sales','visitation.days','visitation.id_store', 'stores.name as store')
		->join('stores', 'stores.id', '=', 'visitation.id_store')
		->where('visitation.id_sales', $idSales)
		->where('stores.status', '1') //approved store
		->get();
		$store = \App\Store::select('stores.id', 'stores.name', 'visitation.id_store', 'visitation.id_sales')
		->join('visitation', 'visitation.id_store', '=', 'stores.id')
		->get();
		$notStore = []; 
		foreach ($store as $st) {
			array_push($notStore, $st->id);
		}
		$data['store'] = \App\Store::whereNotIn('id', $notStore)->get();

		// echo(json_encode($data['visit']));

		return \Template::display_gentelella('visitation', 'Target', $data);
	}

	function getEdit(Request $request, $id)
	{
		$data = \App\Visitation::select('visitation.id','visitation.id_sales','visitation.days','visitation.id_store', 'stores.name as store')
		->join('stores', 'stores.id', '=', 'visitation.id_store')
		->where('visitation.id', $id)
		->where('stores.status', '1') //approved store
		->first();
		echo(json_encode($data));
	}

	function addUpdate(Request $request)
    {
    	// echo($request->rbDay);
    	// return;
    	if ($request->id > 0) {
            $update = \App\Visitation::where('id','=', $request->id)->update($request->except(['_token']));
            if ($update) {
                return redirect('visitation/'.$request->id_sales)->with('update', 'Data');
            }else{
                return redirect('visitation/'.$request->id_sales)->with('error', 'Data');
            } 
        }else{
            $add = \App\Visitation::create($request->except(['_token','id']));
            if ($add) {
                return redirect('visitation/'.$request->id_sales)->with('add', 'Data');    
            }else{
                return redirect('visitation/'.$request->id_sales)->with('error', 'Data');
            }

        }
    }

    function delete(Request $request)
    {
    	$del = \App\Visitation::where('id',$request->id)->delete();
    	if ($del) {
            return redirect('visitation/'.$request->id_sales)->with('delete', 'Data');   
        }else{
            return redirect('visitation/'.$request->id_sales)->with('error', 'Data');
        }
    }
}
