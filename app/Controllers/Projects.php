<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Projects extends BaseController
{

   
    public function index($id=Null)
    {
        
	    $data['title'] = 'Our Projects';
	    $data['records'] = $this->db->query("select * from projects")->getResultArray();
	    return view('frontend/pages/projects',$data);
    }

}