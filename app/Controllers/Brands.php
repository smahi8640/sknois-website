<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Brands extends BaseController
{
	public function index()
	{
	    $data['title'] = 'Brands';
	    $data['brands'] = $this->db->query("select * from brands")->getResultArray();
	    $data['categories'] = $this->db->query("select * from categories")->getResultArray();
	   
	        $data['records'] = $this->db->query("select * from brands")->getResultArray();
	    
	    return view('frontend/pages/brands',$data);
	}
	


	public function products($alias)
	{
        $data['brands'] = $this->db->query("select * from brands order by display_order asc")->getResultArray();
        $data['metadata'] = $this->db->query("select * from categories order by display_order asc")->getResultArray();
	    $data['categories'] = $this->db->query("select * from categories order by display_order asc")->getResultArray();
		$brand_details = $this->db->query("select * from brands WHERE alias='".$alias."' order by display_order asc")->getResultArray();
		
		$data['title'] = $brand_details[0]['title'].' - Products';
		$data['meta_title'] = $brand_details[0]['meta_title'];
		$data['meta_tag'] = $brand_details[0]['meta_tag'];
		$data['meta_description'] = $brand_details[0]['meta_description'];
		$data['brand'] = $brand_details[0];
	    $data['products'] = $this->db->query("select * from products WHERE brand_id = ".$brand_details[0]['id'])->getResultArray();

		return view('frontend/pages/brand_products',$data);
		
	}

	//--------------------------------------------------------------------

}
