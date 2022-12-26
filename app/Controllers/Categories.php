<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Categories extends BaseController
{
	public function index()
	{
	    $data['title'] = 'Categories';
	    //$session = session();
	   /* if(empty($session)){
	    if(empty($diamondtype)){
            $session->set('diamondtype', 'natural');
	    }else{
	        $session->set('diamondtype', $diamondtype);
	    }
	    }
        if($session->get('diamondtype')=="natural"){
            $diamondtype="natural";
            $diamond=2;
        }else if($session->get('diamondtype')=="lab-grown"){
            $diamondtype="lab-grown";
            $diamond=1;
        }*/
	    
	    $data['categories'] = $this->db->query("select * from categories where status='1'")->getResultArray();
	     $data['records'] = $this->db->query("select products.*,product_stock.id as pid,product_stock.price_default,product_stock.mrp_default from  products left join product_stock on products.id=product_stock.product_id where product_stock.country_code='231' and products.status='1' order by products.disp_order asc")->getResultArray();
	        //$data['records'] = $this->db->query("select * from categories")->getResultArray();
	    return view('frontend/pages/categories',$data);
	    //return view('frontend/pages/category_products',$data);
	}


	public function products($alias)
	{
	    
	    
		$category_details = $this->db->query("select * from categories WHERE alias='".$alias."' order by display_order asc")->getResultArray();
        $data['categories'] = $this->db->query("select * from categories where status='1' and parent_id='".$category_details[0]['id']."' order by display_order asc")->getResultArray();
		//$query = "select * from products WHERE status='1' and FIND_IN_SET('".$category_details[0]['id']."', category_ids)";
	    $query="select products.*,product_stock.id as pid,product_stock.price_default,product_stock.mrp_default from  products left join product_stock on products.id=product_stock.product_id where product_stock.country_code='231' and products.status='1' and FIND_IN_SET('".$category_details[0]['id']."', products.category_ids)";
		$data['products'] = $this->db->query($query)->getResultArray();
		
		$data['title'] = $category_details[0]['title'].' - Products';
		$data['meta_title'] = $category_details[0]['meta_title'];
		$data['meta_tag'] = $category_details[0]['meta_tags'];
		$data['meta_description'] = $category_details[0]['meta_description'];
		$data['category'] = $category_details[0];
		return view('frontend/pages/categories/product_list',$data);
		
	}
	
    public function ajax($alias){
        
        /*if($alias!='all'){
		$category_details = $this->db->query("select * from categories WHERE alias='".$alias."' order by display_order asc")->getResultArray();
        
		$query = "select * from products WHERE FIND_IN_SET('".$category_details[0]['id']."', category_ids) order by id desc";
	
		$data['products'] = $this->db->query($query)->getResultArray();
        }else{
            $query = "select * from products order by id desc";
	
	    	$data['products'] = $this->db->query($query)->getResultArray();
        }
		$html=view('frontend/pages/categories/product_filter',$data);
		
		echo $html;*/

        $alias = $this->request->getPost('alias'); 
		$order = 'id';        
        $ordering = $this->request->getPost('ordering'); 
        $start = $this->request->getPost('start'); 
        $limit = $this->request->getPost('limit'); 
        if($alias!="all"){
		$category_details = $this->db->query("select * from categories WHERE alias='".$alias."' order by display_order asc")->getResultArray();
        $query = "select products.*,product_stock.id as pid,product_stock.price_default,product_stock.mrp_default from  products left join product_stock on products.id=product_stock.product_id where product_stock.country_code='231' and products.status='1' and FIND_IN_SET('".$category_details[0]['id']."', products.category_ids) order by products.disp_order asc";
        }        
        else{
            $query = "select products.*,product_stock.id as pid,product_stock.price_default,product_stock.mrp_default from  products left join product_stock on products.id=product_stock.product_id where product_stock.country_code='231' and products.status='1'  order by products.disp_order asc";
        }
		//$query = "select * from products WHERE status='1' and FIND_IN_SET('".$category_details[0]['id']."', category_ids)  order by `".$order."` ".$ordering.' LIMIT '.$start.', '.$limit;
		$data['products'] = $this->db->query($query)->getResultArray();
		
		$html=view('frontend/pages/categories/product_filter',$data);
		
		$response = array();
        $response['html'] = $html;
        $response['start'] = $start + $limit;
        $response['limit'] = $limit;
        $response['ordering'] = $ordering;
        $response['record_counts'] = count($data['products']);
		echo json_encode($response);
        exit;
		
    }
    
    public function filterproduct($alias){
        
        /*$short_by=($this->request->getPost('short_by'))?"product_final_price ".$this->request->getPost('short_by'):"id desc";
        $search="";
        if($this->request->getPost('gender')){
        $search=" and gender in (".implode(',',$this->request->getPost('gender')).")";
        }
        
        if($this->request->getPost('price')){
            $min = 0;
            $max = 0;
            if($this->request->getPost('price') == 1){
                $min = 100;
                $max = 500;
            }
            if($this->request->getPost('price') == 2){
                $min = 501;
                $max = 1000;
            }
            if($this->request->getPost('price') == 3){
                $min = 1001;
                $max = 1500;
            }
            if($this->request->getPost('price') == 4){
                $min = 1501;
                $max = 2000;
            }
            if($this->request->getPost('price') == 5){
                $min = 2001;
                $max = 20000000;
            }
            
            $search.=" and product_final_price>=".$min;
             $search.=" and product_final_price<=".$max;
        }
        
        if($alias!='all'){
		$category_details = $this->db->query("select * from categories WHERE alias='".$alias."' order by display_order asc")->getResultArray();
        
		$query = "select * from products WHERE FIND_IN_SET('".$category_details[0]['id']."', category_ids) ".$search." order by ".$short_by;
	
		$products = $this->db->query($query)->getResultArray();
        }else{
            $query = "select * from products where 1=1 ".$search." order by ".$short_by;
	        
	    	$products = $this->db->query($query)->getResultArray();
        }
        $data['products']=$products;
		$html=view('frontend/pages/categories/product_filter',$data);
		
		echo $html;*/

        $alias = $this->request->getPost('alias'); 
		$filter_price = $this->request->getPost('filter_price'); 
		$filter_stock = $this->request->getPost('filter_stock'); 
		$filter_category = $this->request->getPost('filter_category'); 
		$filter_size = $this->request->getPost('filter_size'); 
		$filter_lenth = $this->request->getPost('filter_lenth'); 
		$filter_gender = $this->request->getPost('filter_gender'); 
		$filter_short_by = $this->request->getPost('filter_short_by'); 
		$start = $this->request->getPost('start'); 
        $limit = $this->request->getPost('limit'); 
        if($alias!='all'){
		$category_details = $this->db->query("select * from categories WHERE alias='".$alias."' order by display_order asc")->getResultArray();
        }
		//$query = "select * from products WHERE FIND_IN_SET('".$category_details[0]['id']."', category_ids)";	
		//$data['products'] = $this->db->query($query)->getResultArray();

		$db      = \Config\Database::connect();

		$builder = $db->table('products');
		$builder->select('products.*,product_stock.id as pid,product_stock.price_default,product_stock.mrp_default');
		$builder->join('product_stock', 'products.id = product_stock.product_id', 'left');
		$where = " product_stock.country_code='231' and products.status='1'";
		$builder->where($where);

		if($filter_price != '') {
			$filter_price_arr = explode('-', $filter_price);
			if($filter_price_arr[1] == '+') {
				$where = "product_stock.price_default > '".$filter_price_arr[0]."'";
			} else {				
				$where = "product_stock.price_default BETWEEN ".$filter_price_arr[0]." AND ".$filter_price_arr[1];
			}
			$builder->where($where);
		}
		if($filter_category == '') {
		    if($alias!='all'){
		    $where = "FIND_IN_SET('".$category_details[0]['id']."', products.category_ids)";
		    $builder->where($where);
		    }
		}else{
		    $where="(";
		    foreach($filter_category as $key=>$cat){
		        if(count($filter_category)==($key+1)){
		            $where .= " FIND_IN_SET('".$cat."', products.category_ids)";
		        }else{
		            $where .= " FIND_IN_SET('".$cat."', products.category_ids) or";
		        }
		    }
		    $where.=" )";
		    
		    $builder->where($where);
		}
		if(!empty($filter_gender)) {
			$builder->whereIn('products.gender', $filter_gender);
		}

		//$builder->limit($limit, $start);

		if($filter_short_by != '') {
			$builder->orderBy('product_stock.price_default', $filter_short_by);
		}

		$query = $builder->get();
		$data['products'] = $query->getResultArray();
		
		$html = view('frontend/pages/categories/product_filter',$data);
		
		$response = array();
        $response['html'] = $html;
        $response['start'] = $start + $limit;
        $response['limit'] = $limit;
        $response['record_counts'] = count($data['products']);
		echo json_encode($response);
        exit;
		
    }
    
   
             
	
	//--------------------------------------------------------------------

}
