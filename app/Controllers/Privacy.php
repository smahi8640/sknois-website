<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\MailChimp;

class Privacy extends BaseController
{

   
    public function index()
    {
        
	    $data['title'] = 'Privacy Policy';
	    $data['settings'] = $this->db->query("select * from settings")->getRowArray();
	    $data['brands'] = $this->db->query("select * from brands")->getResultArray();
	    $data['categories'] = $this->db->query("select * from categories")->getResultArray();
	    
	    return view('frontend/pages/privacy',$data);
	    
        
    }
    
   

}