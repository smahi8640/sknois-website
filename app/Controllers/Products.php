<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CategoriesModel;

class Products extends BaseController
{
   
    public function index($id=null)
    {
        $CategoriesModel = new CategoriesModel();
        $data['categoriestree'] = $CategoriesModel->fetchCategoryTreeAdmin();
      
	    
        $data['type'] = $id;
	    $data['title'] = 'Products '.$id;
	    
	    //$data['products'] = $this->db->query("SELECT * FROM `products` where status='1'")->getResultArray();
	    $data['products'] = $this->db->query("select products.*,product_stock.id as pid,product_stock.price_default,product_stock.mrp_default from  products left join product_stock on products.id=product_stock.product_id where product_stock.country_code='231' and products.status='1' order by products.disp_order asc")->getResultArray();
	    return view('frontend/pages/categories/product_list',$data);
	    
    }

    public function productdetail($alias) {
        
	    $data['categories'] = $this->db->query("select * from categories")->getResultArray(); 
        
        
        $product_details = $this->db->query("SELECT products.*,product_stock.price_default,product_stock.mrp_default,product_stock.color_default,product_stock.size_default,product_stock.purity_default,product_stock.stock_default,product_stock.sku_default,product_stock.stock_id_default FROM `products` left join product_stock on products.id= product_stock.product_id WHERE product_stock.country_code='231' and concat_ws('-',products.alias,products.style_no) LIKE '%".$alias."%'")->getResultArray();
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
        
        
        return view('frontend/pages/products/product_single',$data);

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
       if($this->size){
		if($var['purity']==$this->purity && $var['color']==$this->color && $var['size']==$this->size){
		    
			return $var;
		}
       }else{
           if($var['purity']==$this->purity && $var['color']==$this->color){
		    
			return $var;
		}
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
    
   public function getsearchedproducts() {

		$search = $this->request->getPost('search');
		$query = "SELECT products.*,product_stock.id as pid,product_stock.price_default,product_stock.mrp_default FROM products left join product_stock on products.id=product_stock.product_id where product_stock.country_code='231' and products.status='1' and products.title LIKE '%".$search."%' union all SELECT *,'pid','price_default','mrp_default' FROM products_set where status='1' and title LIKE '%".$search."%'";
    
		$allProduct=$this->db->query($query)->getResultArray();
	
		$data['records'] = $allProduct;
		$data['search'] =$search;
		return view('frontend/pages/search/product_list',$data);
	


	}
	
	public function searchajax($search){
        
        
		//$query = "SELECT id,title,product_short_description,intro_image,style_no,alias,is_size as size,'pid' as pid,product_price,product_final_price FROM products where title LIKE '%".$search."%' union all SELECT id,title,product_short_description,intro_image,style_no,alias,'size' as size, product_id as pid,product_price,product_final_price FROM products_set where title LIKE '%".$search."%'";
    	$query = "SELECT products.*,product_stock.id as pid,product_stock.price_default,product_stock.mrp_default FROM products left join product_stock on products.id=product_stock.product_id where product_stock.country_code='231' and products.status='1' and products.title LIKE '%".$search."%' union all SELECT *,'pid','price_default','mrp_default' FROM products_set where status='1' and title LIKE '%".$search."%'";
    	
		$allProduct=$this->db->query($query)->getResultArray();
	
		$data['products'] = $allProduct;
		
		$html=view('frontend/pages/categories/product_filter',$data);
		
		echo $html;
		
    }

}