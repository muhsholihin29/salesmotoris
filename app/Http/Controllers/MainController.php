<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    function index(Request $request)
    {
        echo password_hash('adminadmin', PASSWORD_DEFAULT);
        $week = date_create(date("Y-m-d", strtotime('monday this week'))); 
        // $week = date_create("2013-03-15");

        $today = date_create('2020-02-26');
        $yesterday = $today;
        date_add($today,date_interval_create_from_date_string("-1 days"));

        // $week = date_create(date('Y-m-d'));
        // date_add($week,date_interval_create_from_date_string("-1 days"));
        // $week->add(new DateInterval('P10D'));
        // $week = strtotime($week.'+ 1 days');
        // return response()->json(['meta' => $week]);

        // echo date('Y-m-d H:i:s');
        echo $week->format('Y-m-d');
        // echo($week);
    	// if ($request->session()->get('user')['level'] == 'admin'){
    	
    }

    function loginPage()
    {
        return view('login');
    }

    function sitt(Request $request)
    {
        \App\test::insert(['request'=> $request]);
        echo($request);
        return view('tes');
    }
}
