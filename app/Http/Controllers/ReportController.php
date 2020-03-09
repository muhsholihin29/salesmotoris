<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    function index(Request $request)
    {
    	$data['target_transaction'] = \App\Target::select('target.id', 'target.id_sales', 'target.target_omset', 'target.target_eff_call', DB::raw('COUNT(total_income) as eff_call'), 'users.name', DB::raw('SUM(total_income) AS income'))
		->join('users', 'users.id', '=', 'target.id_sales')
		->join('transactions', 'transactions.id_sales', '=', 'users.id')
		->whereYear('transactions.created_at','=', date('Y'))
		->whereMonth('transactions.created_at','=', date('m'))
		->get();

		if ($data['target_transaction']) {
			return \Template::display_gentelella('report_sales', 'Target', $data);
		}else{
			return redirect('report_sales')->with('error', 'Data');
		}
    }
}
