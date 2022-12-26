<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CartModel;

class Cart extends BaseController
{
	
	public function index()
	{
        
	    
		$records = vc_getcartitems();
		$carttotal = vc_carttotal();
		$cartcount = vc_cartcount();
        //$this->data['stockstatus'] = $check['status'];
		$this->data['records'] = $records;
		$this->data['carttotal'] = $carttotal;
		$this->data['cartcount'] = $cartcount;

		
		
		/*if($records){
		   
			$record = $this->db->query("select * from db_ems_coupons where is_default='1' and status='1' limit 1")->getRow();
			if(!empty($record)) {				
            
				if($record->condition_type == 'quantity' && $cartcount['total_productcount'] < $record->condition_value) {
				    $this->session->remove('coupon_details');
					return view('ems/cart/index', $this->data);
				}

				if($record->condition_type == 'amount' && $carttotal['total_price'] < $record->condition_value) {
				    $this->session->remove('coupon_details');
					return view('ems/cart/index', $this->data);
				}

				if($record->coupon_type == 'percentage') {
					$coupon_amount = round(($record->coupon_value * 100) / $carttotal['total_price'], 2);					
					$coupon_amount = round(($carttotal['total_price'] * ($record->coupon_value / 100)), 2);					
				} else {
					$coupon_amount = $record->coupon_value;
				}
				
				$coupon_details = array();
				$coupon_details['details'] = $record;
				$coupon_details['amount'] = $coupon_amount;
				$this->session->set('coupon_details', $coupon_details);

				//$data['response'] = 1;
				//$data['message'] = 'Coupon applied successfully.';

			}
		}*/

		return view('frontend/pages/cart/cart', $this->data);

	}

    public function addtocartAjax() {

		$id = $this->request->getPost('product_id');
		
		if($id != '') {

			$post_data = array();
			$post_data['qty'] = $this->request->getPost('quantity');
			$post_data['product_stock_id'] = $this->request->getPost('stock_id');
			
			$product_details=$this->db->query("SELECT * FROM `product_stock` WHERE `product_id` = '".$id."' and country_code ='231'")->getRow();
            $products = $this->db->query("select * from products where id='".$id."'")->getRow();
            
               $jsons1=json_decode($product_details->jsondata1);
               $jsons2=json_decode($product_details->jsondata2);
               $jsons3=json_decode($product_details->jsondata3);
               $jsons4=json_decode($product_details->jsondata4);
               $jsons5=json_decode($product_details->jsondata5);
               $jsons6=json_decode($product_details->jsondata6);
             $filterarr1=  $this->arrmerge($jsons1,$jsons2,$jsons3,$jsons4,$jsons5,$jsons6,$this->request->getPost('stock_id'));
           
             $post_data['price']=$filterarr1[$this->request->getPost('stock_id')]['price'];
             $post_data['mrp']=$filterarr1[$this->request->getPost('stock_id')]['mrp'];
             $post_data['color']=$filterarr1[$this->request->getPost('stock_id')]['color'];
             $post_data['size']=$filterarr1[$this->request->getPost('stock_id')]['size'];
             $post_data['purity']=$filterarr1[$this->request->getPost('stock_id')]['purity'];
             $post_data['sku']=$filterarr1[$this->request->getPost('stock_id')]['sku'];
             $post_data['product_stock_id']=$filterarr1[$this->request->getPost('stock_id')]['id'];
             $post_data['product_id']=$id;
             $post_data['name']=$products->title;
             $post_data['product_set_id']="";
             $post_data['set_product_json']="";
             if($post_data['color']=="White"){
             $post_data['image']=$products->intro_image;
             }else if($post_data['color']=="Yellow"){
             $post_data['image']=$products->yellow_image;
             }else if($post_data['color']=="Pink"){
             $post_data['image']=$products->pink_image;
             }
             $post_data['type']=$this->request->getPost('type');
			$response = vc_addtocart($post_data);
		
			
			$redirect_url = site_url('cart');

			$cart = vc_getcartitems();
			$cart_count = count($cart);
			if($response['status']=="1"){
			$data = [
				'cart' => $cart,
				'cart_count' => $cart_count,
				'message' => $response['message'],
				'status' => 1,
			];
			}else if($response['status']=="0"){
			  $data = [
				'cart' => '',
				'cart_count' => '',
				'message' => $response['message'],
				'status' => 0,
			];  
			}

		} else {

			$data = [
				'cart' => '',
				'cart_count' => '',
				'message' => 'error',
				'status' => 0,
			];

		}

		return $this->response->setJSON($data);

    }
    
    public function addtocartAjax1() {

		$id = $this->request->getPost('product_id');
		
		if($id != '') {

			$post_data = array();
			$post_data1 = [];
			$post_data['qty'] = $this->request->getPost('quantity');
			$product_stock_id = rtrim($this->request->getPost('product_stock_id'), ',');
			$post_data['product_stock_id'] =$product_stock_id ;
			
            $products = $this->db->query("select * from products_set where id='".$id."'")->getRowArray();
            
            //$product=explode(",",$products['product_id']);
            $product=$this->request->getPost('product_set');
            $price="0";
            $mrp="0";
            foreach($product as $l){ 
                $products_d = $this->db->query("select * from products where id='".$l."'")->getRow();
                $product_details=$this->db->query("SELECT * FROM `product_stock` WHERE `product_id` = '".$l."' and country_code ='231'")->getRow();
                
               $jsons1=json_decode($product_details->jsondata1);
               $jsons2=json_decode($product_details->jsondata2);
               $jsons3=json_decode($product_details->jsondata3);
               $jsons4=json_decode($product_details->jsondata4);
               $jsons5=json_decode($product_details->jsondata5);
               $jsons6=json_decode($product_details->jsondata6);
               
               $product_stock=explode(",",$product_stock_id);
               foreach($product_stock as $j){ 
               $filterarr1=  $this->arrmerge($jsons1,$jsons2,$jsons3,$jsons4,$jsons5,$jsons6,$j);
               if(!empty($filterarr1)){
                     if($filterarr1[$j]['color']=="White"){
                     $img=$products_d->intro_image;
                     }else if($filterarr1[$j]['color']=="Yellow"){
                     $img=$products_d->yellow_image;
                     }else if($filterarr1[$j]['color']=="Pink"){
                     $img=$products_d->pink_image;
                     }
                   $mrp=$filterarr1[$j]['mrp']+$mrp;
                   $price=$filterarr1[$j]['price']+$price;
                    $post_data1[] = array(
                        'price'=>$filterarr1[$j]['price'],
                        'mrp'=>$filterarr1[$j]['mrp'],
                        'color'=>$filterarr1[$j]['color'],
                        'size'=>$filterarr1[$j]['size'],
                        'purity'=>$filterarr1[$j]['purity'],
                        'sku'=>$filterarr1[$j]['sku'],
                        'product_stock_id'=>$filterarr1[$j]['id'],
                        'name'=>$products_d->title,
                        'image'=>$img,
                        );
                    
                }
            }
        }
            
            
              
             $post_data['price']=$price;
             $post_data['mrp']=$mrp;
             $post_data['color']="";
             $post_data['size']="";
             $post_data['purity']="";
             $post_data['sku']="";
             $post_data['product_id']=$products['product_id'];
             $post_data['product_set_id']=$id;
             $post_data['name']=$products['title'];
             $post_data['set_product_json']=json_encode($post_data1);
             $post_data['image']=$products['intro_image'];
             $post_data['type']=$this->request->getPost('type');
             
             
			$response = vc_addtocart($post_data);
		
			
			$redirect_url = site_url('cart');

			$cart = vc_getcartitems();
			$cart_count = count($cart);
			if($response['status']=="1"){
			$data = [
				'cart' => $cart,
				'cart_count' => $cart_count,
				'message' => $response['message'],
				'status' => 1,
			];
			}else if($response['status']=="0"){
			  $data = [
				'cart' => '',
				'cart_count' => '',
				'message' => $response['message'],
				'status' => 0,
			];  
			}

		} else {

			$data = [
				'cart' => '',
				'cart_count' => '',
				'message' => 'error',
				'status' => 0,
			];

		}

		return $this->response->setJSON($data);

    }
    
    function arrmerge($jsons1,$jsons2,$jsons3,$jsons4,$jsons5,$jsons6,$id){
    $this->id=$id;
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
              
               return $filterarr;
} 

    public function arrayFilter1($var){
		if($var['id']==$this->id){
		    
			return $var;
		}
	
		 
	 }
	 

    public function removecart($id) {
        
        $session_id = session_id();
        $ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        if(!empty($currentuser)) {
           $this->db->table('cart')->where(array('product_stock_id'=>$id,'user_id'=>$currentuser->id))->delete();
        }else{
		    $this->db->table('cart')->where(array('product_stock_id'=>$id,'session_id'=>$session_id))->delete();
        }
		$carttotal = vc_carttotal();
		$cartcount = vc_cartcount();
		
		/*if($this->session->has('coupon_details')) {

			$coupon_details = $this->session->get('coupon_details');
			
			if($coupon_details['details']->condition_type == 'quantity' && $cartcount['total_productcount'] < $coupon_details['details']->condition_value) {
				$this->session->remove('coupon_details');
			}

			if($coupon_details['details']->condition_type == 'amount' && $carttotal['total_price'] < $coupon_details['details']->condition_value) {
				$this->session->remove('coupon_details');
			}

		}*/

   		$this->session->setFlashdata('message', 'Record remoed from cart successfully.');
		return redirect()->to(site_url('cart'));
		
	}
	
	public function removecart1($id) {
        
        $session_id = session_id();
        $ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        if(!empty($currentuser)) {
           $this->db->table('cart')->where(array('product_set_id'=>$id,'user_id'=>$currentuser->id))->delete();
        }else{
		    $this->db->table('cart')->where(array('product_set_id'=>$id,'session_id'=>$session_id))->delete();
        }
		$carttotal = vc_carttotal();
		$cartcount = vc_cartcount();
		
		/*if($this->session->has('coupon_details')) {

			$coupon_details = $this->session->get('coupon_details');
			
			if($coupon_details['details']->condition_type == 'quantity' && $cartcount['total_productcount'] < $coupon_details['details']->condition_value) {
				$this->session->remove('coupon_details');
			}

			if($coupon_details['details']->condition_type == 'amount' && $carttotal['total_price'] < $coupon_details['details']->condition_value) {
				$this->session->remove('coupon_details');
			}

		}*/

   		$this->session->setFlashdata('message', 'Record remoed from cart successfully.');
		return redirect()->to(site_url('cart'));
		
	}

	public function clearcart(){
		
		$session_id = session_id();

		$ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        if(!empty($currentuser)) {
           $this->db->table('cart')->where('user_id',$currentuser->id)->delete();
        }else{
		    $this->db->table('cart')->where('session_id',$session_id)->delete();
        }

   		$this->session->setFlashdata('message', 'Cart cleared successfully.');
		return redirect()->to(site_url('cart'));

	}

	
   
	public function applyCouponcode() {

		$carttotal = vc_carttotal();
		$cartcount = vc_cartcount();
		$coupon_code = $this->request->getPost('coupon_code');
		
		$data = array();

		if($coupon_code != '') {
			
			$where = array();
			$where['coupon_code'] = $coupon_code;
			$where['status'] = '1';
			$record = $this->CouponsModel->asObject()->where($where)->first();
			if(!empty($record)) {				

				if($record->condition_type == 'quantity' && $cartcount['total_productcount'] < $record->condition_value) {
					$data['response'] = 0;
					$data['message'] = 'This coupon needs minimum '.$record->condition_value.' items in cart.';
					return $this->response->setJSON($data);	
				}

				if($record->condition_type == 'amount' && $carttotal['total_price'] < $record->condition_value) {
					$data['response'] = 0;
					$data['message'] = 'This coupon needs minimum ₹'.$record->condition_value.' amount in cart.';
					return $this->response->setJSON($data);	
				}

				if($record->coupon_type == 'percentage') {
					$coupon_amount = round(($record->coupon_value * 100) / $carttotal['total_price'], 2);					
					$coupon_amount = round(($carttotal['total_price'] * ($record->coupon_value / 100)), 2);					
				} else {
					$coupon_amount = $record->coupon_value;
				}
				
				$coupon_details = array();
				$coupon_details['details'] = $record;
				$coupon_details['amount'] = $coupon_amount;
				$this->session->set('coupon_details', $coupon_details);

				$data['response'] = 1;
				$data['message'] = 'Coupon applied successfully.';

			} else {

				$data['response'] = 0;
				$data['message'] = 'Invalid coupon code.';

			}

		} else {

			$data['response'] = 0;
			$data['message'] = 'Invalid coupon code.';

		}

		return $this->response->setJSON($data);

    }


	public function removeCouponcode() {
		
		$coupon_code = $this->request->getPost('coupon_code');
		
		$data = array();

		if($coupon_code != '') {
			
			$this->session->remove('coupon_details');
			$data['response'] = 1;
			$data['message'] = 'Coupon removed successfully.';

		} else {

			$data['response'] = 0;
			$data['message'] = 'Invalid coupon code.';

		}

		return $this->response->setJSON($data);

    }
    
    public function checkstock(){
        $checks = vc_checkstock();
	   
	    $status='1';
	    $msg='';
	    foreach($checks as $check){
	        if($check['status']=='0'){
	            $status='0';
	            $msg .= $check['title']."\n";
	        }else if($check['status']=='1'){
	            $status='1';
	            $msg .= '';
	        }
	    }
	    if($status=='0'){
	        $msg .="\n above product is out of stock please remove from cart to proceed";
	    }
	    $data['response'] = $status;
	    $data['message'] = $msg;
	    
	    return $this->response->setJSON($data);
    }

}