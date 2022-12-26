<?php 

namespace App\Controllers;
use App\Controllers\BaseController;

class Search extends BaseController
{
   
    public function index()
    {
        
	    $data['title'] = 'Search';
	    
        $data['brands'] = $this->db->query("select * from brands")->getResultArray();
	    $data['categories'] = $this->db->query("select * from categories")->getResultArray();
	    
        $data['categorylist'] = $this->db->query("select * from categories")->getResultArray();
        $data['brandlist'] = $this->db->query("select * from brands")->getResultArray();
        $data['category_id'] = '';
        $data['brand_id'] = '';
        $data['records'] = array();

        $search="";
	    $search = $this->request->getPost('search');

        $data['search_brands'] = '';
        $data['search_categories'] = '';
        $data['search_products'] = '';
        
        if(!empty($search)) {
            /*$searchdata = $this->db->query("select p.* from products p left join categories c on c.id=p.category_id left join brands b on b.id=p.brand_id where b.title like '%".$search."%' or c.title like '%".$search."%' or p.title like '%".$search."%'")->getResultArray();
            $data['records'] = $searchdata;*/
            
            $data['search_brands'] = $this->db->query("SELECT * FROM `brands` WHERE `title` LIKE '%".$search."%'")->getResultArray();
            $data['search_categories'] = $this->db->query("SELECT * FROM `categories` WHERE `title` LIKE '%".$search."%'")->getResultArray();
            $data['search_products'] = $this->db->query("SELECT * FROM `products` WHERE 1 and (`title` LIKE '%".$search."%' or `products_keys` LIKE '%".$search."%')")->getResultArray();

        }
        $data['search']=$search;
	    return view('frontend/pages/search',$data);
	    
    }


}