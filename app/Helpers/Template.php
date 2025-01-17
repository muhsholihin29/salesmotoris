<?php 
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Template {

	public static function get_username($user_id) {
        
        echo $user_id;
    }

    public static function display_gentelella($template, $title, $dataContent) {
        if (!empty($dataContent['request']->user()->username)) {
            $data['username'] = $dataContent['request']->user()->username;
            $data['name'] = $dataContent['request']->user()->name;    
        }else{
            $data['username'] = "Anon";
            $data['name'] = "Anon";
        }       
        
        $data['content'] = view($template, ['data' => $dataContent]);
        // $this->_ci->load->view($template,$data,true);
			$data['title']=$title;
			// $this->_ci->load->view('template/template_admin.php',$data);
		return view('gentelella_theme', ['data' => $data]);   
    }
}