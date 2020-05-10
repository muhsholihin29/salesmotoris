<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    function index(Request $request)
    {
    	$data['request'] = $request;
    	return \Template::display_gentelella('register_sales', 'Daftar Sales', $data);
    }

    function register(Request $request)
    {
        $request->level = 'sales';
        $request->api_token = base64_encode(random_bytes(32));
        $request->password = password_hash($request->password, PASSWORD_DEFAULT);
    	$add = \App\User::create($request->except(['_token']));
        if ($add) {
            return redirect('sales/register')->with('add', 'Data');    
        }else{
            return redirect('sales/register')->with('error', 'Data');
        }
    }

    function registerCekUsername(Request $request)
    {
        $data = \App\User::select('username')        
        ->where('username', $request->username)
        ->get();
        // echo(json_encode($data));
        // echo $request->username;    
        if (count($data) > 0) {
            echo 'false';    
        }else {
            echo 'true';
        }        
    }

    function registerCekEmail(Request $request)
    {
        $data = \App\User::select('email')        
        ->where('email', $request->email)
        ->get();
        if (count($data) > 0) {
            echo 'false';    
        }else {
            echo 'true';
        }           
    }
}
