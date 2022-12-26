<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Error extends BaseController
{

    public function index()
    {
        $data['title'] = '404';
        $data['settings'] = $this->db->query("select * from settings_siteconfiguration")->getRowArray();
	    /*$data['banners'] = $this->db->query("select * from banners")->getResultArray();
	    $data['products'] = $this->db->query("select * from products where is_home='1'")->getResultArray();
	    $data['brands'] = $this->db->query("select * from brands order by display_order asc")->getResultArray();*/
	    $data['products'] = $this->db->query("select * from products where status='1'")->getResultArray();
	    $data['labels']=$this->db->query("select * from product_labels where type='1' limit 1")->getRowArray();
        $data['collections']=$this->db->query("select * from product_labels where type='2' order by id asc")->getResultArray();
	    $data['categories'] = $this->db->query("select * from categories where status='1' and parent_id=0 order by display_order asc")->getResultArray();
	    $data['homeslides'] = $this->db->query("select * from settings_homeslider order by display_order asc")->getResultArray();
        return view('frontend/pages/404',$data);
    }
    
  
}