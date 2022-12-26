<?php namespace App\Controllers;
use App\Controllers\BaseController;

class News extends BaseController
{

   
    public function index($id=Null)
    {
        
	    $data['title'] = 'News';
	    if($id){
    	    $data['record'] = $this->db->query("select * from news where id='".$id."'")->getRow();
    	    return view('frontend/pages/news_details',$data);
	    }else{
	        $data['records'] = $this->db->query("select * from news")->getResultArray();
	        return view('frontend/pages/news',$data);
	    }
        
    }

}