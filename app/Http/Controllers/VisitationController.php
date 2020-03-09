<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitationController extends Controller
{
    function index(Request $request)
    {
    	$data['request'] = $request;
    	$data['user'] = \App\User::where('level','sales')->get();
    	$data['visit'] = \App\Visitation::select('users.id', 'users.name','visitation.days')
		->join('users', 'users.id', '=', 'visitation.id_sales')
		->get();

		if ($data['visit']) {
			return \Template::display_gentelella('visitation', 'Target', $data);
		}else{
			return redirect('report_sales')->with('error', 'Data');
		}
    }
}
