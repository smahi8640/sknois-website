<?php


if (!function_exists("vc_addtocart")) {

    function vc_addtocart($post_data)
    {
        $session_id = session_id();
        $ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        $db      = \Config\Database::connect();
        
        $response = array();

        if(!empty($post_data['product_id'])) {
            
            $where = "session_id='".$session_id."' and product_stock_id='".$post_data['product_stock_id']."'";
            if(!empty($currentuser)) {
                $where = "(session_id='".$session_id."' or user_id='".$currentuser->id."') and product_stock_id='".$post_data['product_stock_id']."'";
            }
            $recordExist = $db->query("select * from cart where ".$where)->getResult();
            if(empty($recordExist)) {
            $record = array();
            if(!empty($currentuser)) {
                $record['user_id'] = $currentuser->id;
            }
            $record['session_id'] = $session_id;
            $record['product_set_id'] = $post_data['product_set_id'];
            $record['product_id'] = $post_data['product_id'];
            $record['title'] = $post_data['name'];
            $record['image'] = $post_data['image'];
            $record['qty'] = $post_data['qty'];
            $record['price'] = $post_data['price'];
            $record['total_amount'] = $post_data['qty']*$post_data['price'];
            $record['mrp'] = $post_data['mrp'];
            $record['color'] = $post_data['color'];
            $record['size'] = $post_data['size'];
            $record['purity'] = $post_data['purity'];
            $record['sku'] = $post_data['sku'];
            $record['product_stock_id']= $post_data['product_stock_id'];
            $record['types']= $post_data['type'];
            $record['set_product_json'] = $post_data['set_product_json'];
            $record['created_date'] = date('Y-m-d H:i:s');      
            
            $db->table('cart')->insert($record);
            $response['status'] = 1;
            $response['message'] = 'Product added in cart successfully.';
            }else{
                $response['status'] = 0;
            $response['message'] = 'Product already in cart.';
            }
        
        } else {

            $response['status'] = 0;
            $response['message'] = 'Product not found.';

        }

        return $response;
        
    }

}

if (!function_exists("vc_updatecartuser")) {

    function vc_updatecartuser($session_id=NULL)
    {
        //$session_id = session_id();
        $ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        $db      = \Config\Database::connect();
        
        
        $response = array();
        $where = "session_id='".$session_id."'";
        $records = $db->query("select * from cart where ".$where)->getResult();
            $data = array(
				'user_id' => $currentuser->id,
			);
           $db->table('cart')->where('session_id',$session_id)->update($data);
        
      
        return $response;
        
    }

}



if (!function_exists("vc_checkstock")) {

    function vc_checkstock()
    {
        $session_id = session_id();
        $ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        $db      = \Config\Database::connect();
        $response = array();
        
        $where = array();
		if(!empty($currentuser)) {
			$where['user_id'] = $currentuser->id;
		} else {
			$where['session_id'] = $session_id;
		}
		$carts = $CartModel->where($where)->findAll();
		
        if(!empty($carts)) {
        foreach($carts as $key=>$cart){
        $product_details = $ProductsModel->asObject()->find($cart['product_id']);

        if($product_details->stock >= $cart['qty']) {  
            $record['id'] = $product_details->id;
            $record['price'] = $product_details->price;
            $record['mrp'] = $product_details->mrp;
            $CartModel->save($record);
            $response[$key]['status'] = 1;
            $response[$key]['title'] = $product_details->title;
            $response[$key]['message'] = 'Proceed';
           
        }else{
            $response[$key]['status'] = 0;
            $response[$key]['title'] = $product_details->title;
            $response[$key]['message'] = 'Stock not available';
        }
        }
        } else {

            $response['status'] = 0;
            $response['title'] = $product_details->title;
            $response['message'] = 'Cart is empty';

        }


        return $response;
        
    }

}


if (!function_exists("vc_getcartitems")) {

    function vc_getcartitems()
    {
        $session_id = session_id();
        $ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        $db      = \Config\Database::connect();
        $response = array();

        $where = "session_id='".$session_id."'";
        if(!empty($currentuser)) {
            $where = "session_id='".$session_id."' or user_id='".$currentuser->id."'";
        }
        $records = $db->query("select * from cart where ".$where)->getResult();
        
        return $records;
        
    }

}

if (!function_exists("vc_carttotal")) {

    function vc_carttotal()
    {
        $session_id = session_id();
        $ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        $db      = \Config\Database::connect();
        $response = array();

        $where = "session_id='".$session_id."'";
        if(!empty($currentuser)) {
            $where = "session_id='".$session_id."' or user_id='".$currentuser->id."'";
        }
        $records = $db->query("select * from cart where ".$where)->getResult();

        $total_price = 0;
        $total_mrp = 0;
        if(!empty($records)) {
            foreach($records AS $record) {
                $total_price = $total_price + $record->price * $record->qty;
                $total_mrp = $total_mrp + $record->mrp * $record->qty;
            }
        }
        
        $response = array();
        $response['total_price'] = $total_price;
        $response['total_mrp'] = $total_mrp;
        return $response;
        
    }

}



if (!function_exists("vc_cartcount")) {

    function vc_cartcount()
    {
        $session_id = session_id();
        $ionAuth = new \IonAuth\Libraries\IonAuth();
        $currentuser = $ionAuth->user()->row();
        $db      = \Config\Database::connect();
        $response = array();

        $where = "session_id='".$session_id."'";
        if(!empty($currentuser)) {
            $where = "session_id='".$session_id."' or user_id='".$currentuser->id."'";
        }
        $records = $db->query("select * from cart where ".$where)->getResult();

        $total_productcount = count($records);
        $total_productitemscount = 0;
        if(!empty($records)) {
            foreach($records AS $record) {
                $total_productitemscount = $total_productitemscount + $record->qty;
            }
        }
        
        $response = array();
        $response['total_productcount'] = $total_productcount;
        $response['total_productitemscount'] = $total_productitemscount;
        return $response;
        
    }

}
