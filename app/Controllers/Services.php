<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Services extends BaseController
{

   
    public function index()
    {
        
	    $data['title'] = 'Services';
	    
	    return view('frontend/pages/services',$data);
	    
        
    }
    
}