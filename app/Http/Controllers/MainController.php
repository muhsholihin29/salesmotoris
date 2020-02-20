<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    function index(Request $request)
    {
    	// if ($request->session()->get('user')['level'] == 'admin'){
    	if(true){
            $data['request'] = $request;           
            return \Template::display_gentelella('dashboard', 'Dashboard', $data);
            // return view('layouts.dashboard');
        } else {
            return redirect('/admin/login');     
        }
    }

    function loginPage()
    {
        return view('login');
    }
}
