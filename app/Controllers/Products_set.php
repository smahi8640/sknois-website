<?php 
 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CartModel;

class Products_set extends BaseController
{
   
    public function index()
    {
     
	   
	    $data['title'] = 'Products Set';
	    
	    $data['products'] = $this->db->query("SELECT * FROM `products_set` where status='1' order by id desc")->getResultArray();
	    $data['parents'] = $this->db->query("SELECT * FROM categories where status='1' and parent_id='0'")->getResultArray();
	    $data['category'] = $this->db->query("select distinct(category_ids) from products_set where category_ids IS NOT NULL order by category_ids asc")->getResultArray();
	    return view('frontend/pages/products_set/product_list',$data);
	    
    }
    
    public function ajax(){
        
		$order = 'id';
        $ordering = $this->request->getPost('ordering'); 
        $start = $this->request->getPost('start'); 
        $limit = $this->request->getPost('limit'); 

		//$query = "select * from products_set order by `".$order."` ".$ordering.' LIMIT '.$start.', '.$limit;	
		$query = "select * from products_set where status='1' order by id ".$ordering;	
		$data['products'] = $this->db->query($query)->getResultArray();

		$html = view('frontend/pages/products_set/product_filter',$data);
		
        $response = array();
        $response['html'] = $html;
        $response['start'] = $start + $limit;
        $response['limit'] = $limit;
        $response['ordering'] = $ordering;
        $response['record_counts'] = count($data['products']);
		echo json_encode($response);
        exit;
		
    }
    
    public function filterproduct(){
        
        $short_by=($this->request->getPost('short_by'))?$this->request->getPost('short_by'):"desc";
        $filter_category = $this->request->getPost('categories'); 
        
        
        $builder = $this->db->table('products_set');
		$builder->select('*');
		$where = " status='1'";
		$builder->where($where);
		
		if($filter_category == '') {
		    
		}else{
		    $where='';
		    foreach($filter_category as $key=>$cat){
		        if(count($filter_category)==($key+1)){
		            $where .= " category_ids='".$cat."' ";
		        }else{
		            $where .= " category_ids='".$cat."' or";
		        }
		    }
		    
		    $builder->where($where);
		}
		
		 $filter_types = $this->request->getPost('types'); 
        
        if($filter_types[0] == 'all' || $filter_types == '') {
           
		   // $builder->where($where);
		}else{
		    $where="(";
		    foreach($filter_types as $key=>$type){
		        if($type!="all"){
    		        if(count($filter_types)==($key+1)){
    		            $where .= " FIND_IN_SET('".$type."', attribute_values)";
    		        }else{
    		            $where .= " FIND_IN_SET('".$type."', attribute_values) or";
    		        }
		        }
		    }
		    $where.=" )";
		    
		    $builder->where($where);
		}
        
        if($short_by != '') {
			$builder->orderBy('id', $short_by);
		}
        
        
		$query = $builder->get();
        
            //$query = "select * from products_set where status='1' order by id ".$short_by;
	        
	    $products = $query->getResultArray();
       
        $data['products']=$products;
		$html=view('frontend/pages/products_set/product_filter',$data);
		
		echo $html;
		
    }
    
    public function filterproductbytype(){
       
            
    }
    
    public function productdetail($alias) {
       
	    $data['categories'] = $this->db->query("select * from categories")->getResultArray(); 
        
        
        $product_details = $this->db->query("SELECT * FROM `products_set` WHERE concat_ws('-',products_set.alias,products_set.style_no) LIKE '%".$alias."%'")->getResultArray();
        $data['size']=$this->db->query("select * from ring_size")->getResult();
        /*$product_stock = $this->db->query("SELECT * FROM product_stock where product_id = '".$product_details[0]['id']."'")->getResultArray();
        
        $catid=explode(',',$product_details[0]['category_id']);
        
        $data['catname']=$this->db->query("SELECT * FROM `categories` WHERE `id` = '".$catid[0]."'")->getRowArray();*/
        
        $data['title'] = $product_details[0]['title'];
       /* $data['meta_title'] = $product_details[0]['meta_title'];
        $data['meta_tag'] = $product_details[0]['meta_tag'];
        $data['meta_description'] = $product_details[0]['meta_description'];*/
        $data['record'] = $product_details[0]; 
        //$data['product_stocks'] = $product_stock; 
        
        //$data['related_products'] = $this->db->query("SELECT * FROM `products` WHERE `category_id` = '".$product_details[0]['category_id']."' and id !='".$product_details[0]['id']."'")->getResultArray();
        $data['alias']=$alias;
        return view('frontend/pages/products_set/product_single',$data);

    }
    
    public function stockajax(){
       $id = $this->request->getPost('id'); 
       $pid=$this->db->query("SELECT * FROM `product_stock` WHERE `product_id` = '".$id."' and country_code ='231'")->getRowArray();
       
       $jsons1=json_decode($pid['jsondata1']);
       $jsons2=json_decode($pid['jsondata2']);
       $jsons3=json_decode($pid['jsondata3']);
       $jsons4=json_decode($pid['jsondata4']);
       $jsons5=json_decode($pid['jsondata5']);
       $jsons6=json_decode($pid['jsondata6']);
       
       $arr1=[];
        foreach($jsons1 as $key=>$json1){   
           $arr1[$key]['id']=$key;  
           $arr1[$key]['mrp']=$json1->mrp;
           $arr1[$key]['price']=$json1->price;
           $arr1[$key]['sku']=$json1->sku;
           $arr1[$key]['color']=$json1->color;
           $arr1[$key]['size']=$json1->size;
           //$arr1[$key]['center_diamond']=$json1->center_diamond;
           $arr1[$key]['purity']=$json1->purity;
           $arr1[$key]['stock']=$json1->stock;
       }
       $arr2=[];
        foreach($jsons2 as $key=>$json2){   
           $arr2[$key]['id']=$key;   
           $arr2[$key]['mrp']=$json2->mrp;
           $arr2[$key]['price']=$json2->price;
           $arr2[$key]['sku']=$json2->sku;
           $arr2[$key]['color']=$json2->color;
           $arr2[$key]['size']=$json2->size;
           //$arr2[$key]['center_diamond']=$json2->center_diamond;
           $arr2[$key]['purity']=$json2->purity;
           $arr2[$key]['stock']=$json2->stock;
       }
       $arr3=[];
        foreach($jsons3 as $key=>$json3){   
           $arr3[$key]['id']=$key;  
           $arr3[$key]['mrp']=$json3->mrp;
           $arr3[$key]['price']=$json3->price;
           $arr3[$key]['sku']=$json3->sku;
           $arr3[$key]['color']=$json3->color;
           $arr3[$key]['size']=$json3->size;
           //$arr3[$key]['center_diamond']=$json3->center_diamond;
           $arr3[$key]['purity']=$json3->purity;
           $arr3[$key]['stock']=$json3->stock;
       }
       $arr4=[];
        foreach($jsons4 as $key=>$json4){   
           $arr4[$key]['id']=$key;   
           $arr4[$key]['mrp']=$json4->mrp;
           $arr4[$key]['price']=$json4->price;
           $arr4[$key]['sku']=$json4->sku;
           $arr4[$key]['color']=$json4->color;
           $arr4[$key]['size']=$json4->size;
           //$arr4[$key]['center_diamond']=$json4->center_diamond;
           $arr4[$key]['purity']=$json4->purity;
           $arr4[$key]['stock']=$json4->stock;
       }
       $arr5=[];
        foreach($jsons5 as $key=>$json5){   
           $arr5[$key]['id']=$key;   
           $arr5[$key]['mrp']=$json5->mrp;
           $arr5[$key]['price']=$json5->price;
           $arr5[$key]['sku']=$json5->sku;
           $arr5[$key]['color']=$json5->color;
           $arr5[$key]['size']=$json5->size;
           //$arr5[$key]['center_diamond']=$json5->center_diamond;
           $arr5[$key]['purity']=$json5->purity;
           $arr5[$key]['stock']=$json5->stock;
       }
       $arr6=[];
        foreach($jsons6 as $key=>$json6){   
           $arr6[$key]['id']=$key;  
           $arr6[$key]['mrp']=$json6->mrp;
           $arr6[$key]['price']=$json6->price;
           $arr6[$key]['sku']=$json6->sku;
           $arr6[$key]['color']=$json6->color;
           $arr6[$key]['size']=$json6->size;
           //$arr6[$key]['center_diamond']=$json6->center_diamond;
           $arr6[$key]['purity']=$json6->purity;
           $arr6[$key]['stock']=$json6->stock;
       }
       
      $arrmerge= array_merge($arr1,$arr2,$arr3,$arr4,$arr5,$arr6);
      
      $filterarr=array_filter($arrmerge,array($this,'arrayFilter'));
      if(empty($filterarr)){
          $final_array=$arrmerge;
      }else{
      $final_array=$filterarr;
      }
      $price = array_column($final_array, 'price');
      array_multisort($price, SORT_ASC, $final_array);
      echo json_encode(array('status'=>1,'message'=>'Success','data'=>reset($final_array)));
       
    } 
    
    public function stockfilterajax(){
       $id = $this->request->getPost('id'); 
       $this->purity = $this->request->getPost('purity');
       $this->color = $this->request->getPost('color');
       //$this->center_diamond = $this->request->getPost('center_diamond');
       $this->size = $this->request->getPost('size');
       
       $pid=$this->db->query("SELECT * FROM `product_stock` WHERE `product_id` = '".$id."' and country_code ='231'")->getRowArray();
       
       $jsons1=json_decode($pid['jsondata1']);
       $jsons2=json_decode($pid['jsondata2']);
       $jsons3=json_decode($pid['jsondata3']);
       $jsons4=json_decode($pid['jsondata4']);
       $jsons5=json_decode($pid['jsondata5']);
       $jsons6=json_decode($pid['jsondata6']);
       
       $arr1=[];
        foreach($jsons1 as $key=>$json1){   
           $arr1[$key]['id']=$key;  
           $arr1[$key]['mrp']=$json1->mrp;
           $arr1[$key]['price']=$json1->price;
           $arr1[$key]['sku']=$json1->sku;
           $arr1[$key]['color']=$json1->color;
           $arr1[$key]['size']=$json1->size;
           //$arr1[$key]['center_diamond']=$json1->center_diamond;
           $arr1[$key]['purity']=$json1->purity;
           $arr1[$key]['stock']=$json1->stock;
       }
       $arr2=[];
        foreach($jsons2 as $key=>$json2){   
           $arr2[$key]['id']=$key;   
           $arr2[$key]['mrp']=$json2->mrp;
           $arr2[$key]['price']=$json2->price;
           $arr2[$key]['sku']=$json2->sku;
           $arr2[$key]['color']=$json2->color;
           $arr2[$key]['size']=$json2->size;
           //$arr2[$key]['center_diamond']=$json2->center_diamond;
           $arr2[$key]['purity']=$json2->purity;
           $arr2[$key]['stock']=$json2->stock;
       }
       $arr3=[];
        foreach($jsons3 as $key=>$json3){   
           $arr3[$key]['id']=$key;  
           $arr3[$key]['mrp']=$json3->mrp;
           $arr3[$key]['price']=$json3->price;
           $arr3[$key]['sku']=$json3->sku;
           $arr3[$key]['color']=$json3->color;
           $arr3[$key]['size']=$json3->size;
           //$arr3[$key]['center_diamond']=$json3->center_diamond;
           $arr3[$key]['purity']=$json3->purity;
           $arr3[$key]['stock']=$json3->stock;
       }
       $arr4=[];
        foreach($jsons4 as $key=>$json4){   
           $arr4[$key]['id']=$key;   
           $arr4[$key]['mrp']=$json4->mrp;
           $arr4[$key]['price']=$json4->price;
           $arr4[$key]['sku']=$json4->sku;
           $arr4[$key]['color']=$json4->color;
           $arr4[$key]['size']=$json4->size;
           //$arr4[$key]['center_diamond']=$json4->center_diamond;
           $arr4[$key]['purity']=$json4->purity;
           $arr4[$key]['stock']=$json4->stock;
       }
       $arr5=[];
        foreach($jsons5 as $key=>$json5){   
           $arr5[$key]['id']=$key;   
           $arr5[$key]['mrp']=$json5->mrp;
           $arr5[$key]['price']=$json5->price;
           $arr5[$key]['sku']=$json5->sku;
           $arr5[$key]['color']=$json5->color;
           $arr5[$key]['size']=$json5->size;
           //$arr5[$key]['center_diamond']=$json5->center_diamond;
           $arr5[$key]['purity']=$json5->purity;
           $arr5[$key]['stock']=$json5->stock;
       }
       $arr6=[];
        foreach($jsons6 as $key=>$json6){   
           $arr6[$key]['id']=$key;  
           $arr6[$key]['mrp']=$json6->mrp;
           $arr6[$key]['price']=$json6->price;
           $arr6[$key]['sku']=$json6->sku;
           $arr6[$key]['color']=$json6->color;
           $arr6[$key]['size']=$json6->size;
           //$arr6[$key]['center_diamond']=$json6->center_diamond;
           $arr6[$key]['purity']=$json6->purity;
           $arr6[$key]['stock']=$json6->stock;
       }
       
      $arrmerge= array_merge($arr1,$arr2,$arr3,$arr4,$arr5,$arr6);
      
      $filterarr=array_filter($arrmerge,array($this,'arrayFilter1'));
      if(!empty($filterarr)){
          $final_array=$filterarr;
          $price = array_column($final_array, 'price');
          array_multisort($price, SORT_ASC, $final_array);
          echo json_encode(array('status'=>1,'message'=>'Success','data'=>reset($final_array)));
      }else{
          echo json_encode(array('status'=>0,'message'=>'No Data'));
      }
      
       
    }
    
    public function arrayFilter1($var){
		if($var['purity']==$this->purity && $var['color']==$this->color && $var['size']==$this->size){
		    
			return $var;
		}
	
		 
	 }
	 
    public function arrayFilter($var){
		if($var['stock']>=1){
			return $var;
		}
	
		 
	 }
                        
    public function imageajax() {
        $id = $this->request->getPost('id');
        $alias = $this->request->getPost('alias');
        $product_details = $this->db->query("SELECT * FROM `products` WHERE `alias` = '".$alias."'")->getResultArray();
        if(!empty($id)){
            $data['id']=$id;
            $data['product_details'] = $product_details[0]; 
        }
        $html = view('frontend/pages/imageajax',$data);            
        echo json_encode(array('status'=>1,'message'=>'','html'=>$html));
    }

    public function addcollection() {
        $id = $this->request->getPost('id');
        $title = $this->request->getPost('title');
        $color = $this->request->getPost('color');
        $images = $this->request->getPost('images');
        $description = $this->request->getPost('description');
        $pids=explode('-', $id);
        $price=0;
        if($pids){
            foreach($pids as $pid){
                $stock=$this->db->query("SELECT * FROM product_stock where product_id='".$pid."' and color='".$color."'")->getRowArray();
                $price=$price+$stock['price'];
                $size = $stock['size'];
            }
        }else{
            $stock=$this->db->query("SELECT * FROM product_stock where product_id='".$id."' and color='".$color."'")->getRowArray();
            $size = $stock['size'];
            $price = $stock['price'];
        }
        /*$pids=explode(',', $id);
        if($pids){
            foreach($pids as $pid){*/
                if($id){
                    //$product_details = $this->db->query("select * from products WHERE id=".$pid)->getResultArray();
                    //if(!empty($product_details)) {
                        $cart = cart();
                        $cart->insert(array(
                            'id'      => $id.'_'.$color,         
                            'qty'     => 1,         
                            //'style_no'   => $product_details[0]['style_no'],
                            'price'   => $price,     
                            'size'   => $size,     
                            'name'    => $title,        
                            'color'    => $color,
                            'images'    => $images,
                            'description'    => $description,
                            //'options' => array('Size' => 'L', 'Color' => 'Red')         
                        ));
                   // }
                }
            /*}
        }*/

       echo json_encode(array('status'=>1,'message'=>'Product added successfully.'));

    }

    public function deletecollection() {
        $row_id = $this->request->getPost('id');
        $cart = cart();
        $cart->remove($row_id);
    
        echo json_encode(array('status'=>1,'message'=>'Product removed successfully.')); 

    }
    
    public function sendcollection() {

        $cart = cart();
        $cartlist = $cart->contents();

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $mobile = $this->request->getPost('mobile');

        $data = [
                'name' => $name,
                'email'  => $email,
                'mobile'  => $mobile,
                'products'  => json_encode($cartlist),
                'created_at'  => date('Y-m-d H:i:s')
        ];
        $this->db->table('productselections')->insert($data);

        $msg='<!DOCTYPE html>
				<html lang="en">
				    <head>
				        <style>
				            h3 { font-size: 32px; text-align: center; margin: 0 0 20px; }
				            h6 {
                                font-size: 16px;
                                color: #3d5170;
                                margin: 0;
                                font-weight: 400;
                            }
                            .table th { font-weight: bold; }
                            b { font-weight: 500; }
                            .table td, .table th {
                                padding: .75rem;
                                font-size: 15px;
                                color: #5a6169;
                            }
                            .table {
                                width: 100%;
                                margin-bottom: 16px;
                                
                                text-align: left;
                            }
				            .table-bordered td, .table-bordered th {
                                border: 1px solid #dee2e6;
                            }
                        </style>
				    </head>
					<body>
                        
                        <h3 class="text-center mb-4">'.$name.' - Collations</h3>
                        <div class="form-row">
                            
                            <div class="col-md-12">
                                <h6><i>Customer Details</i></h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Name : '.$name.'</td>
                                        </tr>
                                        <tr>
                                            <td>Email : '.$email.'</td>
                                        </tr>
                                        <tr>
                                            <td>Mobile : '.$mobile.'</td>
                                        </tr>
                                    </table>
                                </div>';
                                $msg .='<table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Article</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                        if(!empty($cartlist)) {
                                            foreach($cartlist AS $cartl) {
                                            $msg .='<tr>
                                                <td>'.$cartl['name'].'</td>
                                                <td>'.$cartl['style_no'].'</td>
                                            </tr>';
                                            }
                                        } else {
                                            $msg .='<tr>
                                                <td colspan="3" class="text-danger">No records</td>
                                            </tr>';
                                        }
                                    $msg .='</tbody>
                                </table>
                            </div>
                        </div>
                        </body></html>';
                $this->email->setMailType('html');
                $this->email->setFrom('info@bebabybridal.com', 'Bebaby');
                $this->email->setTo('sp@treasta.com');
                $this->email->setSubject('Bebaby : Product Enquiry');
                $this->email->setMessage($msg);
                $this->email->send();

                echo json_encode(array('status'=>1,'message'=>'Mail sent successfully.'));

    }
    
    public function sendenquiry()
    {   
        $session = session();
        	helper('form');
			if($this->validate(['name'  => 'required']))
			{
            $name = $this->request->getPost('name');
            $email=$this->request->getPost('email');
            $phone=$this->request->getPost('phone');
            $subject=$this->request->getPost('subject');
            $message=$this->request->getPost('message');
            $color=$this->request->getPost('color');
            $title=$this->request->getPost('title');
            $product_id=$this->request->getPost('id');
            $description=$this->request->getPost('description');
            $images=$this->request->getPost('images');
            
            $pids=explode('-', $product_id);
            $price=0;
            if($pids){
                foreach($pids as $pid){
                    $stock=$this->db->query("SELECT * FROM product_stock where product_id='".$pid."' and color='".$color."'")->getRowArray();
                    $price=$price+$stock['price'];
                    $size = $stock['size'];
                }
            }else{
                $stock=$this->db->query("SELECT * FROM product_stock where product_id='".$product_id."' and color='".$color."'")->getRowArray();
                $size = $stock['size'];
                $price = $stock['price'];
            }
            
            $cart=[
                    'id'=>$product_id,
                    'name'=>$title,
                    'color'=>$color,
                    'images'    => $images,
                    'description'=>$description,
                    'price'   => $price,     
                    'size'   => $size,  
                ];
                
            $data = [
                'product_details' => json_encode($cart),
                'name'  => $name,
                'email'  => $email,
                'phone'  => $phone,
                'subject'  => $subject,
                'message'  => $message,
                'is_type' =>'4',
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $this->db->table('contact')->insert($data);
            
            $msg='<!DOCTYPE html>
				<html lang="en">
				    <head>
				        <style>
				            .col-md-6{
				                width: 50%;
				                float: left;
				            }
				            h3 { font-size: 32px; text-align: center; margin: 0 0 20px; }
				            h6 {
                                font-size: 16px;
                                color: #3d5170;
                                margin: 0;
                                font-weight: 400;
                            }
                            .table th { font-weight: bold; }
                            b { font-weight: 500; }
                            .table td, .table th {
                                padding: .75rem;
                                font-size: 15px;
                                color: #5a6169;
                            }
                            .table {
                                width: 100%;
                                margin-bottom: 16px;
                                
                                text-align: left;
                            }
				            .table-bordered td, .table-bordered th {
                                border: 1px solid #dee2e6;
                            }
                        </style>
				    </head>
					<body>
                        
                        <h3 class="text-center mb-4">Contact</h3>
                    <div class="form-row">
                        
                        <div class="col-md-6">
                            <h6><i>Customer Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                    <td><img src="'.base_url().'/media/source/'.$images.'"></td>
                                    </tr>
                                    <tr>
                                        <th>Product Name : '.$title.' </th>
                                    </tr>
                                    <tr>
                                        <th>Description: '.$description.' </th>
                                    </tr>
                                    <tr>
                                        <th>Color: '.$color.' </th>
                                    </tr>
                                    <tr>
                                        <th>Price: '.$price.' </th>
                                    </tr>
                                    <tr>
                                        <th>'.$name.' </th>
                                    </tr>
                                    <tr>
                                        <td>'.$email.'</td>
                                    </tr>
                                    <tr>
                                        <td>'.$phone.'</td>
                                    </tr>
                                    <tr>
                                        <td>'.$subject.'</td>
                                    </tr>
                                    <tr>
                                        <td>'.$message.'</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                        </body></html>';
                $this->email->setMailType('html');
    			$this->email->setFrom('info@bebabybridal.com', 'Bebaby');
                $this->email->setTo('sp@treasta.com');
                $this->email->setSubject('Bebaby : Product Enquiry');
                $this->email->setMessage($msg);
                $this->email->send();
                
                echo json_encode(array('status'=>1,'message'=>'Messsage sent successfully.'));
            
        }
        else
        {
          echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
        }
    }


    public function enquirylist(){
        $cart = cart();       
        $items = $cart->contents();
        $data['title'] = 'Enquiry List';
        $data['cart_items'] = $items;
        return view('frontend/pages/cart',$data);
    }

    public function sendcartenquiry()
    {   
        $session = session();
        helper('form');
        if($this->validate(['name'  => 'required']))
        {
        $name = $this->request->getPost('name');
        $email=$this->request->getPost('email');
        $phone=$this->request->getPost('phone');
        $subject=$this->request->getPost('subject');
        $message=$this->request->getPost('message');
        $cart = cart();       
        $items = $cart->contents();
        
        
        $msg='<!DOCTYPE html>
            <html lang="en">
                <head>
                    <style>
                        .col-md-6{
                            width: 50%;
                            float: left;
                        }
                        h3 { font-size: 32px; text-align: center; margin: 0 0 20px; }
                        h6 {
                            font-size: 16px;
                            color: #3d5170;
                            margin: 0;
                            font-weight: 400;
                        }
                        .table th { font-weight: bold; }
                        b { font-weight: 500; }
                        .table td, .table th {
                            padding: .75rem;
                            font-size: 15px;
                            color: #5a6169;
                        }
                        .table {
                            width: 100%;
                            margin-bottom: 16px;
                            
                            text-align: left;
                        }
                        .table-bordered td, .table-bordered th {
                            border: 1px solid #dee2e6;
                        }
                    </style>
                </head>
                <body>
                    
                    <h3 class="text-center mb-4">Contact</h3>
                <div class="form-row">
                    <div class="col-md-6">
                        <h6><i>Product Enquiry List</i></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Color</th>
                                    <th>Price</th>
                                </tr>';
                                foreach($items AS $cart_item) {
                                    $msg .= '<tr>
                                        <td><img src="'.base_url().'/media/source/'.$cart_item["images"].'"></td>
                                        <td>'. $cart_item["name"].'</td>
                                        <td>'. $cart_item["description"].'</td>
                                        <td>'. $cart_item["color"].'</td>
                                        <td>'. $cart_item["price"].'</td>
                                    </tr>';
                                    //$cart->remove($cart_item["rowid"]);
                                }
                            $msg .= '</table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6><i>Customer Details</i></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>'.$name.' </th>
                                </tr>
                                <tr>
                                    <td>'.$email.'</td>
                                </tr>
                                <tr>
                                    <td>'.$phone.'</td>
                                </tr>
                                <tr>
                                    <td>'.$subject.'</td>
                                </tr>
                                <tr>
                                    <td>'.$message.'</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                    </body></html>';
            $this->email->setMailType('html');
            $this->email->setFrom('info@bebabybridal.com', 'Bebaby');
            $this->email->setTo('sp@treasta.com');
            $this->email->setSubject('Bebaby : Product Enquiry');
            $this->email->setMessage($msg);
            $this->email->send();
            
            $data = [
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'message' => $message,
                        'subject' => $subject,
                        'product_details'  => json_encode($items),
                        'is_type'  => '3',
                        'created_at'  => date('Y-m-d H:i:s')
                ];
                
                //print_r($data);exit;
                $this->db->table('contact')->insert($data);
            $cart->destroy();
            echo json_encode(array('status'=>1,'message'=>'Messsage sent successfully.'));
            
        }
        else
        {
            echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
        }
    }
}