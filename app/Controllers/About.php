<?php namespace App\Controllers;
use App\Controllers\BaseController;

class About extends BaseController
{

   
    public function index()
    {
        
	    $data['title'] = 'About Us';
	   
	    return view('frontend/pages/about',$data);
	    
        
    }
    

    
   
}