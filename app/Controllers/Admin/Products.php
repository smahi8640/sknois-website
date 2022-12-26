<?php 

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\Slug;   // use the Slug Library
use App\Models\CategoriesModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Products extends BaseController
{
    
    public function __construct()
	{		
		
		$this->db      = \Config\Database::connect();
		$this->session = \Config\Services::session();

	}
   
    public function index()
    {
        
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('admin');
        }
        
	    $data['title'] = 'Products';
	    
	    //$data['rel_products'] = $this->db->query("select * from products")->getResultArray();
       
        $task = $this->request->getPost('task');

        if($task == 'delete') {
            $record_ids = $this->request->getPost('record_id');
            $this->deleteRecords($record_ids);
        }
        $data['records'] = $this->db->query("select * from products")->getResultArray();
	    return view('admin/pages/products/index',$data);
	    
        
    }

    public function product_list()
    {
        $session = session();
        if(empty($session->has('email'))){
            return redirect()->to('admin');
        }
        $CategoriesModel = new CategoriesModel();
        $data['title'] = 'Products';
        $data['records'] = $this->db->query("select * from products")->getResultArray();
        return view('admin/pages/products/product_list',$data);   
    }

    public function getProductList(){
        $draw = $this->request->getPost('draw');
        $res = $this->db->query("select * from products")->getResultArray();
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => count($res),
            "recordsFiltered" => count($res),
            "data" => $res
        );
        echo json_encode($response);
    }

    public function edit($id=NULL)
    {
        $data['title'] = 'Products';
        $CategoriesModel = new CategoriesModel();
        $data['categoriestree'] = $CategoriesModel->fetchCategoryTreeAdmin();
        $data['rel_products'] = $this->db->query("select * from products")->getResultArray();
         $data['labels'] = $this->db->query("select * from product_labels where type='1'")->getResult();
        $data['manufacturers'] = $this->db->query("select * from manufacturer")->getResult();
        //$data['rel_products'] = $this->db->query("select * from products")->getResult();
        if($id)
        {
            $data['record'] = $this->db->query("select * from products where id='".$id."'")->getRow();
        }
        
        return view('admin/pages/products/add', $data);
        
        
    }

    public function add()
    {   
        $this->currentuser = $this->ionAuth->user()->row();

        $config = array(
            'field' => 'alias',
            'title' => 'title',
            'table' => 'products',
            'id' => 'id',
        );
        $Slug = new Slug($config);

        $id = $this->request->getPost('id');
          // print_r($this->request->getPost('description'));exit;    
        /*helper('form');
        if($this->validate(['title'  => 'required']))
        {*/
                $title = $this->request->getPost('title');
                $aliasTemp = $this->request->getPost('alias');
                if($aliasTemp == '') {
                    $data = array(
                        'title' => $title,
                    );
                } else {
                    $data = array(
                        'title' => $aliasTemp,
                    );
                }
                $record['title'] = $title;
                $record['alias'] = $Slug->create_uri($data, $id);
                $record['description'] = $this->request->getPost('description');
                $record['intro_image'] = $this->request->getPost('intro_image');
                $record['yellow_image'] = $this->request->getPost('yellow_image');
                $record['pink_image'] = $this->request->getPost('pink_image');
                $record['intro_zoom'] = $this->request->getPost('intro_zoom');
                $record['yellow_zoom'] = $this->request->getPost('yellow_zoom');
                $record['pink_zoom'] = $this->request->getPost('pink_zoom');
                $record['status'] = $this->request->getPost('status');
                $record['product_short_description'] = $this->request->getPost('product_short_description');
                $record['product_price'] = $this->request->getPost('product_price');
                $record['product_final_price'] = $this->request->getPost('product_final_price');
                $record['product_old_price'] = "0";
                $record['style_no'] = $this->request->getPost('style_no');
                $record['gender'] = $this->request->getPost('gender');
                $record['video'] = $this->request->getPost('video');
                $record['types'] = $this->request->getPost('product_diamond');
                $record['product_sku'] = $this->request->getPost('product_sku');
                $record['item_no'] = $this->request->getPost('item_no');
                $record['lab_name'] = $this->request->getPost('lab_name');
                $record['height'] = $this->request->getPost('height');
                $record['width'] = $this->request->getPost('width');
                $record['lenght'] = $this->request->getPost('lenght');
                $record['weight'] = $this->request->getPost('weight');
                $record['purity'] = $this->request->getPost('purity');
            
                $record['category_ids'] = @implode(',', $this->request->getPost('category_ids[]'));
                
                if($this->request->getPost('label_ids[]') != '') {
                    $record['label_ids'] = @implode(',', $this->request->getPost('label_ids[]'));
                } else {
                    $record['label_ids'] = '';
                }
                if($this->request->getPost('related_product_ids[]') != '') {
                  $record['related_product_ids'] = @implode(',', $this->request->getPost('related_product_ids[]'));
                } else {
                    $record['related_product_ids'] = '';
                }

                $record['meta_title'] = $this->request->getPost('meta_title');
                $record['meta_description'] = $this->request->getPost('meta_description');
                $record['meta_tags'] = $this->request->getPost('meta_tags');
                
                
                $white_multi_image = $this->request->getPost('white_multi_image');
                $white_multi_zoom = $this->request->getPost('white_multi_zoom');
                $white_disp_order = $this->request->getPost('white_disp_order');
                $white_images = [];
                if($white_multi_image){
                foreach ($white_multi_image as $key => $row) {
                    if($row){
                        $white_images[] = array('image'=>$row,'zoom'=>$white_multi_zoom[$key],'disp_order'=>$white_disp_order[$key]);
                    }
                }
                }
                
                $yellow_multi_image = $this->request->getPost('yellow_multi_image');
                $yellow_multi_zoom = $this->request->getPost('yellow_multi_zoom');
                $yellow_disp_order = $this->request->getPost('yellow_disp_order');
                $yellow_images = [];
                if($yellow_multi_image){
                foreach ($yellow_multi_image as $key => $row) {
                    if($row){
                        $yellow_images[] = array('image'=>$row,'zoom'=>$yellow_multi_zoom[$key],'disp_order'=>$yellow_disp_order[$key]);
                    }
                }
                }
                
                $pink_multi_image = $this->request->getPost('pink_multi_image');
                $pink_multi_zoom = $this->request->getPost('pink_multi_zoom');
                $pink_disp_order = $this->request->getPost('pink_disp_order');
                $pink_images = [];
                if($pink_multi_image){
                foreach ($pink_multi_image as $key => $row) {
                    if($row){
                        $pink_images[] = array('image'=>$row,'zoom'=>$pink_multi_zoom[$key],'disp_order'=>$pink_disp_order[$key]);
                    }
                }
                }
                
                $white_images_json = json_encode($white_images);
                $yellow_images_json = json_encode($yellow_images);
                $pink_images_json = json_encode($pink_images);
                
                $record['white_multi_image'] = $white_images_json;
                $record['yellow_multi_image'] = $yellow_images_json;
                $record['pink_multi_image'] = $pink_images_json;
                
                $video=[];
                if($this->request->getPost('video_white')){
                    $video[] = array('video'=>$this->request->getPost('video_white'),'disp_order'=>$this->request->getPost('video_white_disp_order'),'type'=>'white');
                }
                if($this->request->getPost('video_yellow')){
                    $video[] = array('video'=>$this->request->getPost('video_yellow'),'disp_order'=>$this->request->getPost('video_yellow_disp_order'),'type'=>'yellow');
                }
                if($this->request->getPost('video_pink')){
                    $video[] = array('video'=>$this->request->getPost('video_pink'),'disp_order'=>$this->request->getPost('video_pink_disp_order'),'type'=>'pink');
                }
                 

                $record['video'] = json_encode($video);
                
                $diamond[] = array(
                    'color'=>$this->request->getPost('diamond_color'),
                    'clarity'=>$this->request->getPost('clarity'),
                    'setting_type'=>$this->request->getPost('setting_type'),
                    'unit'=>$this->request->getPost('diamond_unit'),
                    'diameter'=>$this->request->getPost('diameter'),
                    'count'=>$this->request->getPost('count'),
                    'weight'=>$this->request->getPost('diamond_weight'),
                    'diamond_type'=>$this->request->getPost('diamond_type'),
                    'center_weight'=>$this->request->getPost('center_weight'),
                    'center_color'=>$this->request->getPost('center_color'),
                    'center_clarity'=>$this->request->getPost('center_clarity'),
                    'side_weight'=>$this->request->getPost('side_weight'),
                    'side_color'=>$this->request->getPost('side_color'),
                    'side_clarity'=>$this->request->getPost('side_clarity')
                    );
                $chain[] = array(
                    'metal'=>$this->request->getPost('metal'),
                    'color'=>$this->request->getPost('chain_color'),
                    'purity'=>$this->request->getPost('chain_purity'),
                    'unit'=>$this->request->getPost('chain_unit'),
                    'types'=>$this->request->getPost('types'),
                    'adjustable'=>$this->request->getPost('adjustable'),
                    'weight'=>$this->request->getPost('chain_weight')
                    );
                $record['diamond_data'] =json_encode($diamond);
                $record['chain_data'] =json_encode($chain);
                $record['disp_order'] = $this->request->getPost('disp_order');
                $record['products_keys'] = ($this->request->getPost('products_keys'))?implode(',', $this->request->getPost('products_keys')):'';
                
            if($id) {
                    
                $record['updated_by'] = $this->currentuser->id;
                $record['updated_date'] = date('Y-m-d H:i:s');
               
                $this->db->table('products')->where('id',$id)->update($record);
                
                echo json_encode(array('status'=>1,'message'=>'Record has been updated successfully.','product_id'=>$id));
            
            } else {
            
                $record['created_by'] = $this->currentuser->id;
                $record['created_date'] = date('Y-m-d H:i:s');
                
                $this->db->table('products')->insert($record);
                $id=$this->db->insertID();

                echo json_encode(array('status'=>2,'message'=>'Record has been added successfully.','product_id'=>$id));

            }
                        
        /*}
        else
        {
          echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
        }*/
    }


    public function delete()
    {
        $id = $this->request->getPost('id');

        if(is_null($id) || empty($id)) {
            
            echo json_encode(array('status'=>0,'message'=>'There is no data to delete'));

        } else {

            if(!is_array($id)) {
                $id = array($id);
            }

            foreach ($id AS $i) {
                $this->db->table('products')->where('id',$id)->delete();
                $this->db->table('product_stock')->where('product_id',$id)->delete();
            }

            echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
            
        }

        
    }
    
    public function addstock()
    {
        $id=$this->request->getPost('id');
        $pid=$this->request->getPost('pid');
        $pstock=$this->db->query("select * from product_stock where product_id='".$this->request->getPost('pid')."'")->getResult();
        
        $record['is_size'] = $id;
        $this->db->table('products')->where('id',$pid)->update($record);
        
        if(empty($pstock)){
            $size=$this->db->query("select * from ring_size")->getResult();
            $record=array();
            
            $m="0";
            if($id=='1'){
                for ($k = 1; $k <= 2; $k++){
                if($k=='1'){
                    $stock1 = array();
                    $stock2 = array();
                    $stock3 = array();
                    $stock4 = array();
                    $stock5 = array();
                    $stock6 = array();
                    //ID COMBINATION 1=product_id,2=country_code,3=purity,4=color,5=diamond,6=size
                    for ($j = 1; $j <= 3; $j++){
                        for ($l = 1; $l <= 2; $l++){
                            if($l=="1" && $j=="1"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock1[$pid.'_231_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock1[$pid.'_231_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');
                                    $stock1[$pid.'_231_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');
                                    $stock1[$pid.'_231_'.$l.$j.$m.$i->size]['purity'] = "14K";
                                    $stock1[$pid.'_231_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock1[$pid.'_231_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock1[$pid.'_231_'.$l.$j.$m.$i->size]['color'] = "White";
                                    $stock1[$pid.'_231_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="2" && $j=="1"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock2[$pid.'_231_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock2[$pid.'_231_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock2[$pid.'_231_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock2[$pid.'_231_'.$l.$j.$m.$i->size]['purity'] = "18K";
                                    $stock2[$pid.'_231_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock2[$pid.'_231_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock2[$pid.'_231_'.$l.$j.$m.$i->size]['color'] = "White";
                                    $stock2[$pid.'_231_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="1" && $j=="2"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock3[$pid.'_231_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock3[$pid.'_231_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock3[$pid.'_231_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock3[$pid.'_231_'.$l.$j.$m.$i->size]['purity'] = "14K";
                                    $stock3[$pid.'_231_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock3[$pid.'_231_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock3[$pid.'_231_'.$l.$j.$m.$i->size]['color'] = "Yellow";
                                    $stock3[$pid.'_231_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="2" && $j=="2"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock4[$pid.'_231_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock4[$pid.'_231_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock4[$pid.'_231_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock4[$pid.'_231_'.$l.$j.$m.$i->size]['purity'] = "18K";
                                    $stock4[$pid.'_231_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock4[$pid.'_231_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock4[$pid.'_231_'.$l.$j.$m.$i->size]['color'] = "Yellow";
                                    $stock4[$pid.'_231_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="1" && $j=="3"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock5[$pid.'_231_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock5[$pid.'_231_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock5[$pid.'_231_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock5[$pid.'_231_'.$l.$j.$m.$i->size]['purity'] = "14K";
                                    $stock5[$pid.'_231_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock5[$pid.'_231_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock5[$pid.'_231_'.$l.$j.$m.$i->size]['color'] = "Pink";
                                    $stock5[$pid.'_231_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="2" && $j=="3"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock6[$pid.'_231_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock6[$pid.'_231_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock6[$pid.'_231_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock6[$pid.'_231_'.$l.$j.$m.$i->size]['purity'] = "18K";
                                    $stock6[$pid.'_231_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock6[$pid.'_231_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock6[$pid.'_231_'.$l.$j.$m.$i->size]['color'] = "Pink";
                                    $stock6[$pid.'_231_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                               // }
                            }          
                            
                        }    
                    }    
                    $record['product_id'] =$this->request->getPost('pid');
                    $record['country_code'] ='231';
                    $record['jsondata1'] =json_encode($stock1);
                    $record['jsondata2'] =json_encode($stock2);
                    $record['jsondata3'] =json_encode($stock3);
                    $record['jsondata4'] =json_encode($stock4);
                    $record['jsondata5'] =json_encode($stock5);
                    $record['jsondata6'] =json_encode($stock6);
                    $this->db->table('product_stock')->insert($record);
                }else if($k=='2'){
                    $stock1 = array();
                    $stock2 = array();
                    $stock3 = array();
                    $stock4 = array();
                    $stock5 = array();
                    $stock6 = array();
                    for ($j = 1; $j <= 3; $j++){
                        for ($l = 1; $l <= 2; $l++){
                            if($l=="1" && $j=="1"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock1[$pid.'_101_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock1[$pid.'_101_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock1[$pid.'_101_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock1[$pid.'_101_'.$l.$j.$m.$i->size]['purity'] = "14K";
                                    $stock1[$pid.'_101_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock1[$pid.'_101_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock1[$pid.'_101_'.$l.$j.$m.$i->size]['color'] = "White";
                                    $stock1[$pid.'_101_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="2" && $j=="1"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock2[$pid.'_101_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock2[$pid.'_101_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock2[$pid.'_101_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock2[$pid.'_101_'.$l.$j.$m.$i->size]['purity'] = "18K";
                                    $stock2[$pid.'_101_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock2[$pid.'_101_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock2[$pid.'_101_'.$l.$j.$m.$i->size]['color'] = "White";
                                    $stock2[$pid.'_101_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="1" && $j=="2"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock3[$pid.'_101_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock3[$pid.'_101_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock3[$pid.'_101_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock3[$pid.'_101_'.$l.$j.$m.$i->size]['purity'] = "14K";
                                    $stock3[$pid.'_101_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock3[$pid.'_101_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock3[$pid.'_101_'.$l.$j.$m.$i->size]['color'] = "Yellow";
                                    $stock3[$pid.'_101_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="2" && $j=="2"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock4[$pid.'_101_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock4[$pid.'_101_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock4[$pid.'_101_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock4[$pid.'_101_'.$l.$j.$m.$i->size]['purity'] = "18K";
                                    $stock4[$pid.'_101_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock4[$pid.'_101_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock4[$pid.'_101_'.$l.$j.$m.$i->size]['color'] = "Yellow";
                                    $stock4[$pid.'_101_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="1" && $j=="3"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock5[$pid.'_101_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock5[$pid.'_101_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock5[$pid.'_101_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock5[$pid.'_101_'.$l.$j.$m.$i->size]['purity'] = "14K";
                                    $stock5[$pid.'_101_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock5[$pid.'_101_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock5[$pid.'_101_'.$l.$j.$m.$i->size]['color'] = "Pink";
                                    $stock5[$pid.'_101_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                                //}
                            }else if($l=="2" && $j=="3"){
                                //for ($m = 1; $m <= 5; $m++){    
                                    foreach($size as $i){
                                    $stock6[$pid.'_101_'.$l.$j.$m.$i->size]['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock6[$pid.'_101_'.$l.$j.$m.$i->size]['mrp'] = $this->request->getPost('product_price');;
                                    $stock6[$pid.'_101_'.$l.$j.$m.$i->size]['price'] = $this->request->getPost('product_final_price');;
                                    $stock6[$pid.'_101_'.$l.$j.$m.$i->size]['purity'] = "18K";
                                    $stock6[$pid.'_101_'.$l.$j.$m.$i->size]['center_diamond'] = "";
                                    $stock6[$pid.'_101_'.$l.$j.$m.$i->size]['stock'] = "0";
                                    $stock6[$pid.'_101_'.$l.$j.$m.$i->size]['color'] = "Pink";
                                    $stock6[$pid.'_101_'.$l.$j.$m.$i->size]['size'] = $i->size;
                                    }
                               // }
                            }          
                            
                        }    
                    }      
                    $record['product_id'] =$this->request->getPost('pid');
                    $record['country_code'] ='101';
                    $record['jsondata1'] =json_encode($stock1);
                    $record['jsondata2'] =json_encode($stock2);
                    $record['jsondata3'] =json_encode($stock3);
                    $record['jsondata4'] =json_encode($stock4);
                    $record['jsondata5'] =json_encode($stock5);
                    $record['jsondata6'] =json_encode($stock6);
                    $this->db->table('product_stock')->insert($record);
                }
            }
            }else if($id=="2"){
                for ($k = 1; $k <= 2; $k++){
                if($k=='1'){
                    $stock1 = array();
                    $stock2 = array();
                    $stock3 = array();
                    $stock4 = array();
                    $stock5 = array();
                    $stock6 = array();
                    for ($j = 1; $j <= 3; $j++){
                        for ($l = 1; $l <= 2; $l++){
                            if($l=="1" && $j=="1"){
                                //for ($m = 1; $m <= 5; $m++){
                                    $stock1[$pid.'_231_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock1[$pid.'_231_'.$l.$j.$m.'0']['mrp'] = $this->request->getPost('product_price');;
                                    $stock1[$pid.'_231_'.$l.$j.$m.'0']['price'] = $this->request->getPost('product_final_price');;
                                    $stock1[$pid.'_231_'.$l.$j.$m.'0']['purity'] = "14K";
                                    $stock1[$pid.'_231_'.$l.$j.$m.'0']['center_diamond'] = "";
                                    $stock1[$pid.'_231_'.$l.$j.$m.'0']['stock'] = "0";
                                    $stock1[$pid.'_231_'.$l.$j.$m.'0']['color'] = "White";
                                    $stock1[$pid.'_231_'.$l.$j.$m.'0']['size'] = '0';
                               //}
                            }else if($l=="2" && $j=="1"){
                                //for ($m = 1; $m <= 5; $m++){ 
                                    $stock2[$pid.'_231_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock2[$pid.'_231_'.$l.$j.$m.'0']['mrp'] = $this->request->getPost('product_price');;
                                    $stock2[$pid.'_231_'.$l.$j.$m.'0']['price'] = $this->request->getPost('product_final_price');;
                                    $stock2[$pid.'_231_'.$l.$j.$m.'0']['purity'] = "18K";
                                    $stock2[$pid.'_231_'.$l.$j.$m.'0']['center_diamond'] = "";
                                    $stock2[$pid.'_231_'.$l.$j.$m.'0']['stock'] = "0";
                                    $stock2[$pid.'_231_'.$l.$j.$m.'0']['color'] = "White";
                                    $stock2[$pid.'_231_'.$l.$j.$m.'0']['size'] = '0';
                                //}
                            }else if($l=="1" && $j=="2"){
                                //for ($m = 1; $m <= 5; $m++){ 
                                    $stock3[$pid.'_231_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock3[$pid.'_231_'.$l.$j.$m.'0']['mrp'] = $this->request->getPost('product_price');;
                                    $stock3[$pid.'_231_'.$l.$j.$m.'0']['price'] = $this->request->getPost('product_final_price');;
                                    $stock3[$pid.'_231_'.$l.$j.$m.'0']['purity'] = "14K";
                                    $stock3[$pid.'_231_'.$l.$j.$m.'0']['center_diamond'] = "";
                                    $stock3[$pid.'_231_'.$l.$j.$m.'0']['stock'] = "0";
                                    $stock3[$pid.'_231_'.$l.$j.$m.'0']['color'] = "Yellow";
                                    $stock3[$pid.'_231_'.$l.$j.$m.'0']['size'] = '0';
                                //}
                            }else if($l=="2" && $j=="2"){
                                //for ($m = 1; $m <= 5; $m++){ 
                                    $stock4[$pid.'_231_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock4[$pid.'_231_'.$l.$j.$m.'0']['mrp'] = $this->request->getPost('product_price');;
                                    $stock4[$pid.'_231_'.$l.$j.$m.'0']['price'] = $this->request->getPost('product_final_price');;
                                    $stock4[$pid.'_231_'.$l.$j.$m.'0']['purity'] = "18K";
                                    $stock4[$pid.'_231_'.$l.$j.$m.'0']['center_diamond'] = "";
                                    $stock4[$pid.'_231_'.$l.$j.$m.'0']['stock'] = "0";
                                    $stock4[$pid.'_231_'.$l.$j.$m.'0']['color'] = "Yellow";
                                    $stock4[$pid.'_231_'.$l.$j.$m.'0']['size'] = '0';
                                //}
                            }else if($l=="1" && $j=="3"){
                                //for ($m = 1; $m <= 5; $m++){ 
                                    $stock5[$pid.'_231_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock5[$pid.'_231_'.$l.$j.$m.'0']['mrp'] = $this->request->getPost('product_price');;
                                    $stock5[$pid.'_231_'.$l.$j.$m.'0']['price'] = $this->request->getPost('product_final_price');;
                                    $stock5[$pid.'_231_'.$l.$j.$m.'0']['purity'] = "14K";
                                    $stock5[$pid.'_231_'.$l.$j.$m.'0']['center_diamond'] = "";
                                    $stock5[$pid.'_231_'.$l.$j.$m.'0']['stock'] = "0";
                                    $stock5[$pid.'_231_'.$l.$j.$m.'0']['color'] = "Pink";
                                    $stock5[$pid.'_231_'.$l.$j.$m.'0']['size'] = '0';
                                //}
                            }else if($l=="2" && $j=="3"){
                                //for ($m = 1; $m <= 5; $m++){ 
                                    $stock6[$pid.'_231_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                    $stock6[$pid.'_231_'.$l.$j.$m.'0']['mrp'] = $this->request->getPost('product_price');;
                                    $stock6[$pid.'_231_'.$l.$j.$m.'0']['price'] = $this->request->getPost('product_final_price');;
                                    $stock6[$pid.'_231_'.$l.$j.$m.'0']['purity'] = "18K";
                                    $stock6[$pid.'_231_'.$l.$j.$m.'0']['center_diamond'] = "";
                                    $stock6[$pid.'_231_'.$l.$j.$m.'0']['stock'] = "0";
                                    $stock6[$pid.'_231_'.$l.$j.$m.'0']['color'] = "Pink";
                                    $stock6[$pid.'_231_'.$l.$j.$m.'0']['size'] = '0';
                                //}
                            }
                        }    
                    }    
                    $record['product_id'] =$this->request->getPost('pid');
                    $record['country_code'] ='231';
                    $record['jsondata1'] =json_encode($stock1);
                    $record['jsondata2'] =json_encode($stock2);
                    $record['jsondata3'] =json_encode($stock3);
                    $record['jsondata4'] =json_encode($stock4);
                    $record['jsondata5'] =json_encode($stock5);
                    $record['jsondata6'] =json_encode($stock6);
                    $this->db->table('product_stock')->insert($record);
                }else if($k=='2'){
                    $stock1 = array();
                    $stock2 = array();
                    $stock3 = array();
                    $stock4 = array();
                    $stock5 = array();
                    $stock6 = array();
                    for ($j = 1; $j <= 3; $j++){
                        for ($l = 1; $l <= 2; $l++){
                            //for ($m = 1; $m <= 5; $m++){    
                                if($l=="1" && $j=="1"){
                                    //for ($m = 1; $m <= 5; $m++){
                                        $stock1[$pid.'_101_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                        $stock1[$pid.'_101_'.$l.$j.$m.'0']['mrp'] = 0;
                                        $stock1[$pid.'_101_'.$l.$j.$m.'0']['price'] = 0;
                                        $stock1[$pid.'_101_'.$l.$j.$m.'0']['purity'] = "14K";
                                        $stock1[$pid.'_101_'.$l.$j.$m.'0']['center_diamond'] = "";
                                        $stock1[$pid.'_101_'.$l.$j.$m.'0']['stock'] = "0";
                                        $stock1[$pid.'_101_'.$l.$j.$m.'0']['color'] = "White";
                                        $stock1[$pid.'_101_'.$l.$j.$m.'0']['size'] = '0';
                                    //}
                                }else if($l=="2" && $j=="1"){
                                    //for ($m = 1; $m <= 5; $m++){ 
                                        $stock2[$pid.'_101_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                        $stock2[$pid.'_101_'.$l.$j.$m.'0']['mrp'] = 0;
                                        $stock2[$pid.'_101_'.$l.$j.$m.'0']['price'] = 0;
                                        $stock2[$pid.'_101_'.$l.$j.$m.'0']['purity'] = "18K";
                                        $stock2[$pid.'_101_'.$l.$j.$m.'0']['center_diamond'] = "";
                                        $stock2[$pid.'_101_'.$l.$j.$m.'0']['stock'] = "0";
                                        $stock2[$pid.'_101_'.$l.$j.$m.'0']['color'] = "White";
                                        $stock2[$pid.'_101_'.$l.$j.$m.'0']['size'] = '0';
                                    //}
                                }else if($l=="1" && $j=="2"){
                                    //for ($m = 1; $m <= 5; $m++){ 
                                        $stock3[$pid.'_101_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                        $stock3[$pid.'_101_'.$l.$j.$m.'0']['mrp'] = 0;
                                        $stock3[$pid.'_101_'.$l.$j.$m.'0']['price'] = 0;
                                        $stock3[$pid.'_101_'.$l.$j.$m.'0']['purity'] = "14K";
                                        $stock3[$pid.'_101_'.$l.$j.$m.'0']['center_diamond'] = "";
                                        $stock3[$pid.'_101_'.$l.$j.$m.'0']['stock'] = "0";
                                        $stock3[$pid.'_101_'.$l.$j.$m.'0']['color'] = "Yellow";
                                        $stock3[$pid.'_101_'.$l.$j.$m.'0']['size'] = '0';
                                    //}
                                }else if($l=="2" && $j=="2"){
                                    //for ($m = 1; $m <= 5; $m++){ 
                                        $stock4[$pid.'_101_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                        $stock4[$pid.'_101_'.$l.$j.$m.'0']['mrp'] = 0;
                                        $stock4[$pid.'_101_'.$l.$j.$m.'0']['price'] = 0;
                                        $stock4[$pid.'_101_'.$l.$j.$m.'0']['purity'] = "18K";
                                        $stock4[$pid.'_101_'.$l.$j.$m.'0']['center_diamond'] = "";
                                        $stock4[$pid.'_101_'.$l.$j.$m.'0']['stock'] = "0";
                                        $stock4[$pid.'_101_'.$l.$j.$m.'0']['color'] = "Yellow";
                                        $stock4[$pid.'_101_'.$l.$j.$m.'0']['size'] = '0';
                                    //}
                                }else if($l=="1" && $j=="3"){
                                    //for ($m = 1; $m <= 5; $m++){ 
                                        $stock5[$pid.'_101_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                        $stock5[$pid.'_101_'.$l.$j.$m.'0']['mrp'] = 0;
                                        $stock5[$pid.'_101_'.$l.$j.$m.'0']['price'] = 0;
                                        $stock5[$pid.'_101_'.$l.$j.$m.'0']['purity'] = "14K";
                                        $stock5[$pid.'_101_'.$l.$j.$m.'0']['center_diamond'] = "";
                                        $stock5[$pid.'_101_'.$l.$j.$m.'0']['stock'] = "0";
                                        $stock5[$pid.'_101_'.$l.$j.$m.'0']['color'] = "Pink";
                                        $stock5[$pid.'_101_'.$l.$j.$m.'0']['size'] = '0';
                                    //}
                                }else if($l=="2" && $j=="3"){
                                    //for ($m = 1; $m <= 5; $m++){ 
                                        $stock6[$pid.'_101_'.$l.$j.$m.'0']['sku'] = ($this->request->getPost('sku'))?$this->request->getPost('sku'):"";
                                        $stock6[$pid.'_101_'.$l.$j.$m.'0']['mrp'] = 0;
                                        $stock6[$pid.'_101_'.$l.$j.$m.'0']['price'] = 0;
                                        $stock6[$pid.'_101_'.$l.$j.$m.'0']['purity'] = "18K";
                                        $stock6[$pid.'_101_'.$l.$j.$m.'0']['center_diamond'] = "";
                                        $stock6[$pid.'_101_'.$l.$j.$m.'0']['stock'] = "0";
                                        $stock6[$pid.'_101_'.$l.$j.$m.'0']['color'] = "Pink";
                                        $stock6[$pid.'_101_'.$l.$j.$m.'0']['size'] = '0';
                                    //}
                                }
                            //}
                        }    
                    }    
                    $record['product_id'] =$this->request->getPost('pid');
                    $record['country_code'] ='101';
                    $record['jsondata1'] =json_encode($stock1);
                    $record['jsondata2'] =json_encode($stock2);
                    $record['jsondata3'] =json_encode($stock3);
                    $record['jsondata4'] =json_encode($stock4);
                    $record['jsondata5'] =json_encode($stock5);
                    $record['jsondata6'] =json_encode($stock6);
                    $this->db->table('product_stock')->insert($record);
                }
            }
            }
            echo json_encode(array('status'=>1,'message'=>'Stock has been added successfully.','product_id'=>$this->request->getPost('pid')));
            
        }else{
            echo json_encode(array('status'=>0,'message'=>'Stock already exist.','product_id'=>$this->request->getPost('pid')));
        }
            
       
    }
    
 
    public function updatestock()
    {
       $type=$this->request->getPost('type');
        $product_id=$this->request->getPost('pid');
        $country_code=$this->request->getPost('country_code');
        $stock_ids=$this->request->getPost('stock_id');
        $mrp=$this->request->getPost('stock_mrp');
        $price=$this->request->getPost('stock_price');
        $sku=$this->request->getPost('stock_sku');
        $color=$this->request->getPost('stock_color');
        $size=$this->request->getPost('stock_size');
        $purity=$this->request->getPost('stock_purity');
        $center_diamond=$this->request->getPost('stock_center_diamond');
        $stock=$this->request->getPost('stock_stock');
        
            $update=array();
            if($stock_ids){
                $record = array();
                foreach ($stock_ids as $key => $row) {
                $record[$row]['mrp'] = $mrp[$key];
                $record[$row]['price'] = $price[$key];
                $record[$row]['sku'] = $sku[$key];
                $record[$row]['color'] = $color[$key];
                $record[$row]['size'] = $size[$key];
                $record[$row]['purity'] = $purity[$key];
                $record[$row]['center_diamond'] = $center_diamond[$key];
                $record[$row]['stock'] = $stock[$key];
               // $update_id = $this->db->set($record)->where('id',$row)->update('product_stock');
                }
                //print_r($stock_ids);exit;
                if($type=="1"){
                $update['jsondata1'] =json_encode($record);
                }else if($type=="2"){
                $update['jsondata2'] =json_encode($record);
                }else if($type=="3"){
                $update['jsondata3'] =json_encode($record);
                }else if($type=="4"){
                $update['jsondata4'] =json_encode($record);
                }else if($type=="5"){
                $update['jsondata5'] =json_encode($record);
                }else if($type=="6"){
                $update['jsondata6'] =json_encode($record);
                }
                $this->db->table('product_stock')->where(array('product_id'=>$product_id,'country_code'=>$country_code))->update($update);
                echo json_encode(array('status'=>1,'message'=>'Stock has been updated successfully.','product_id'=>$product_id));
            }

            
       
    }
    
    public function deletestock()
    {
        $pid=$this->request->getPost('pid');
        
            if($pid){
                $this->db->table('product_stock')->where('product_id',$pid)->delete();
                
                echo json_encode(array('status'=>1,'message'=>'Stock has been deleted successfully.','product_id'=>$this->request->getPost('pid')));
            }

            
       
    }
    
    
    public function bulkstock()
    {
        $pstocks=$this->db->query("select * from products")->getResult();
        foreach($pstocks as $pstock){
            for ($j = 1; $j <= 3; $j++){
                    
                $stock = array();
                $stock['product_id'] = $pstock->id;
                $stock['sku'] = $this->request->getPost('sku');
                $stock['mrp'] = 0;
                $stock['price'] = 0;
                $stock['purity'] = $this->request->getPost('purity');
                $stock['stock'] = "0";
                if($j=="1"){
                $stock['color'] = "White";
                }else if($j=="2"){
                   $stock['color'] = "Yellow"; 
                }else if($j=="3"){
                   $stock['color'] = "Pink"; 
                }
                $stock['size'] = "-";
                $this->db->table('product_stock')->insert($stock);
                //$stock_id = $this->db->insert('product_stock', $stock);
            }
        }
            
       
    }

  	// File upload and Insert records
	 public function import1(){
            
            
            $this->data['title'] = 'Import : Products';

    		if (! $this->ionAuth->loggedIn() || ! $this->ionAuth->isAdmin()) {
    
    			return redirect()->to('login');
    
    		}
    
           $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            
    		$this->validation->setRule('file1', 'File', 'uploaded[file]|max_size[file,1024]|ext_in[file,xlsx]');
    	
    		//if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
                $id=$this->request->getPost('id');
    			if($file = $this->request->getFile('file1')) {
                    
    				if ($file->isValid() && ! $file->hasMoved()) {
    
    					// Get random file name
    					$newName = $file->getRandomName();
    					
    					// Store file in public/csvfile/ folder
    					$file->move('../public/csvfile', $newName);
    					
    					
    					
                        $arr_file = explode('.', $newName);
                        $extension = end($arr_file);
                        if('csv' == $extension){
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        } else {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }
                        $spreadsheet = $reader->load(FCPATH.'csvfile/'.$newName);
                        $sheetData = $spreadsheet->getActiveSheet()->toArray();
                        $i=0;
                        $importData_arr = array();
                        
                        $stock1 = array();
                        $stock2 = array();
                        $stock3 = array();
                        $stock4 = array();
                        $stock5 = array();
                        $stock6 = array();
                        
                        $stock1_i = array();
                        $stock2_i = array();
                        $stock3_i = array();
                        $stock4_i = array();
                        $stock5_i = array();
                        $stock6_i = array();
                        $m='0';
                        
                        foreach($sheetData as $key=>$data1){
                            
                            $records = array();
                            if($i>0 && $i<count($sheetData)){
                                
                                if($data1[1]=='White'){
                                    $j="1";
                                }else if($data1[1]=='Yellow'){
                                    $j="2";
                                }else if($data1[1]=='Pink'){
                                    $j="3";
                                }
                                if($data1[3]=='14K'){
                                    $l="1";
                                }else if($data1[3]=='18K'){
                                    $l="2";
                                }
                                
                                if($data1[2]=="0"){
                                    $record1['is_size'] = '2';
                                    $this->db->table('products')->where('id',$id)->update($record1);
                                }else{
                                    $record1['is_size'] = '1';
                                    $this->db->table('products')->where('id',$id)->update($record1);
                                    
                                }
                                
                                if($l=="1" && $j=="1"){
    								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="2" && $j=="1"){
    								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="1" && $j=="2"){
    								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="2" && $j=="2"){
    								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="1" && $j=="3"){
    								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="2" && $j=="3"){
    								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }
                                
                                
                                
                                if($l=="1" && $j=="1"){
    								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="2" && $j=="1"){
    								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="1" && $j=="2"){
    								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="2" && $j=="2"){
    								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="1" && $j=="3"){
    								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }else if($l=="2" && $j=="3"){
    								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
    								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
    								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
    								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
    								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
    								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
    								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                }
                        }
                        $i++;
    				}
    				$record['product_id'] =$id;
                    $record['country_code'] ='231';
                    $record['jsondata1'] =json_encode($stock1);
                    $record['jsondata2'] =json_encode($stock2);
                    $record['jsondata3'] =json_encode($stock3);
                    $record['jsondata4'] =json_encode($stock4);
                    $record['jsondata5'] =json_encode($stock5);
                    $record['jsondata6'] =json_encode($stock6);
                    $this->db->table('product_stock')->insert($record);
                    
                    $record['product_id'] =$id;
                    $record['country_code'] ='101';
                    $record['jsondata1'] =json_encode($stock1_i);
                    $record['jsondata2'] =json_encode($stock2_i);
                    $record['jsondata3'] =json_encode($stock3_i);
                    $record['jsondata4'] =json_encode($stock4_i);
                    $record['jsondata5'] =json_encode($stock5_i);
                    $record['jsondata6'] =json_encode($stock6_i);
                    $this->db->table('product_stock')->insert($record);
					
    				echo json_encode(array('status'=>1,'message'=>'Record Stock has been added successfully','product_id'=>$id));
    				}
    			}
    				
    	/*	}
            else {
			
			echo json_encode(array('status'=>0,'message'=>'Some error occured'));

		}*/
            
            
           
        }
        
      

    // File upload and Insert records
	 public function import(){
            
            $this->currentuser = $this->ionAuth->user()->row();
            $this->data['title'] = 'Import : Products';
            
             $config = array(
                        'field' => 'alias',
                        'title' => 'title',
                        'table' => 'products',
                        'id' => 'id',
                    );
                    $Slug = new Slug($config);

    		if (! $this->ionAuth->loggedIn() || ! $this->ionAuth->isAdmin()) {
    
    			return redirect()->to('login');
    
    		}
    
           $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            
    		$this->validation->setRule('file1', 'File', 'uploaded[file]|max_size[file,1024]|ext_in[file,xlsx]');
    	
    		//if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
               // $id=$this->request->getPost('id');
    			if($file = $this->request->getFile('file1')) {
                    
    				if ($file->isValid() && ! $file->hasMoved()) {
    
    					// Get random file name
    					$newName = $file->getRandomName();
    					
    					// Store file in public/csvfile/ folder
    					$file->move('../public/csvfile', $newName);
    					
    					
    					
                        $arr_file = explode('.', $newName);
                        $extension = end($arr_file);
                        if('csv' == $extension){
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        } else {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }
                        $spreadsheet = $reader->load(FCPATH.'csvfile/'.$newName);
                        //$sheetData = $spreadsheet->getActiveSheet()->toArray();
                        foreach ($spreadsheet->getWorksheetIterator() as $key => $worksheet) {
                        if($worksheet->getTitle()=="Regular"){
                            $sheetDatas=$worksheet->toArray();
                           
                            $i=0;
                                $importData_arr = array();
                             foreach($sheetDatas as $key=>$datas){
                                 $records = array();
                                    if($i>0 && $i<count($sheetDatas) ){
                                        //if($i>0 && $i<count($sheetDatas) && $datas[3]!=""){
                                        $title = $datas[1];
                                        $aliasTemp = $datas[2];
                                        if($aliasTemp == '') {
                                            $data = array(
                                                'title' => $title,
                                            );
                                        } else {
                                            $data = array(
                                                'title' => $aliasTemp,
                                            );
                                        }
                                        $types=$datas[0];
                                        if($types=='L'){
                                            $types='1';
                                        }else if($types=='N'){
                                            $types='2';
                                        }
                                        $record['types'] = $types;
                                        $record['title'] = $title;
                                        $record['alias'] = $Slug->create_uri($data);
                                        $record['style_no'] = $datas[3];
                                        $record['product_short_description'] = $datas[4];
                                        $record['description'] = $datas[5];
                                        $record['product_price'] = $datas[6];
                                        $record['product_final_price'] = $datas[7];
                                        $record['product_old_price'] = "0";
                                        $gender=$datas[8];
                                        if($gender=='M'){
                                            $gender='1';
                                        }else if($gender=='F'){
                                            $gender='2';
                                        }else if($gender=='K'){
                                            $gender='3';
                                        }else if($gender=='U'){
                                            $gender='4';
                                        }
                                        
                                        $record['gender'] = $gender;
                                        $record['product_sku'] = "";
                                        if($datas[9]){
                                        $categories=explode(',',$datas[9]);
                                        $cat=[];
                                        foreach ($categories as $key => $row) {
                                            $cats=$this->db->query("select * from categories where title='".$row."'")->getRow();
                                            if($cats){
                                            $cat[]=$cats->id;
                                            }
                                        }
                                         $record['category_ids'] = implode(',',$cat);
                                        }
                                       
                                        
                                        if($datas[10]){
                                        $labels=explode(',',$datas[10]);
                                        $lab=[];
                                        foreach ($labels as $key => $row) {
                                            $labs=$this->db->query("select * from product_labels where title='".$row."'")->getRow();
                                            if($labs){
                                            $lab[]=$labs->id;
                                            }
                                        }
                                        $record['label_ids'] = implode(',',$lab);
                                        }
                                        
                                        
                                        $record['item_no'] = $datas[11];
                                        $record['lab_name'] = $datas[12];
                                        $record['height'] = $datas[13];
                                        $record['width'] = $datas[14];
                                        $record['lenght'] = $datas[15];
                                        $record['weight'] = $datas[16];
                                        $record['purity'] = "";
                                        $record['disp_order'] = ($datas[17])?$datas[17]:"1";
                                        $record['products_keys'] = $datas[18];
                                        $record['status'] = $datas[19];
                                        $record['meta_title'] = $datas[20];
                                        $record['meta_description'] = $datas[21];
                                        $record['meta_tags'] = $datas[22];
                                        $video=[];
                                        if($datas[23]){
                                            $video[] = array('video'=>$datas[23],'disp_order'=>'0','type'=>'white');
                                        }
                                        if($datas[24]){
                                            $video[] = array('video'=>$datas[24],'disp_order'=>'0','type'=>'yellow');
                                        }
                                        if($datas[25]){
                                            $video[] = array('video'=>$datas[25],'disp_order'=>'0','type'=>'pink');
                                        }
                                        $record['video'] = json_encode($video);
                                        $record['intro_image'] = $datas[26];
                                        $record['yellow_image'] = $datas[27];
                                        $record['pink_image'] = $datas[28];
                                        
                                        $record['intro_zoom'] = $datas[50];
                                        $record['yellow_zoom'] = $datas[51];
                                        $record['pink_zoom'] = $datas[52];
                                        
                                        $white_multi_image = explode(',',$datas[29]);
                                        $white_images = [];
                                        if($white_multi_image){
                                        foreach ($white_multi_image as $key => $row) {
                                            if($row){
                                                $white_images[] = array('image'=>$row,'zoom'=>$row,'disp_order'=>$key+1);
                                            }
                                        }
                                        }
                                        
                                        $yellow_multi_image = explode(',',$datas[30]);
                                        $yellow_images = [];
                                        if($yellow_multi_image){
                                        foreach ($yellow_multi_image as $key => $row) {
                                            if($row){
                                                $yellow_images[] = array('image'=>$row,'disp_order'=>$key+1);
                                            }
                                        }
                                        }
                                        
                                        $pink_multi_image = explode(',',$datas[31]);
                                        $pink_images = [];
                                        if($pink_multi_image){
                                        foreach ($pink_multi_image as $key => $row) {
                                            if($row){
                                                
                                                $pink_images[] = array('image'=>$row,'disp_order'=>$key+1);
                                            }
                                        }
                                        }
                                        
                                        $white_images_json = json_encode($white_images);
                                        $yellow_images_json = json_encode($yellow_images);
                                        $pink_images_json = json_encode($pink_images);
                                        
                                        $record['white_multi_image'] = $white_images_json;
                                        $record['yellow_multi_image'] = $yellow_images_json;
                                        $record['pink_multi_image'] = $pink_images_json;
                
                                        $diamond=[];
                                        $diamond[] = array(
                                            'color'=>$datas[32],
                                            'clarity'=>$datas[33],
                                            'setting_type'=>$datas[34],
                                            'unit'=>$datas[35],
                                            'diameter'=>"",
                                            'count'=>$datas[36],
                                            'weight'=>$datas[37],
                                            'diamond_type'=>$datas[38],
                                            'center_weight'=>$datas[39],
                                            'center_color'=>$datas[40],
                                            'center_clarity'=>$datas[41],
                                            'side_color'=>$datas[42],
                                            'side_clarity'=>$datas[43],
                                            'side_weight'=>$datas[44]
                                        );
                                        
                                        $chain=[];
                                        $chain[] = array(
                                            'metal'=>$datas[28],
                                            'color'=>$datas[28],
                                            'purity'=>$datas[28],
                                            'unit'=>$datas[28],
                                            'types'=>$datas[45],
                                            'adjustable'=>$datas[46],
                                            'weight'=>$datas[47]
                                        );
                                        $record['diamond_data'] =json_encode($diamond);
                                        $record['chain_data'] =json_encode($chain);
                                        $record['is_size'] = $datas[48];
                                        
                                        if($datas[49]){
                                        $related=explode(',',$datas[49]);
                                        $rel=[];
                                        foreach ($related as $key => $row) {
                                            $rels=$this->db->query("select * from products where style_no='".$row."'")->getRow();
                                            if($rels){
                                            $rel[]=$rels->id;
                                            }
                                        }
                                        $record['related_product_ids'] = implode(',',$rel);
                                        }
                                        
                                        $record['created_by'] = $this->currentuser->id;
                                        $record['created_date'] = date('Y-m-d H:i:s');
                                        
                                        $this->db->table('products')->insert($record);
                                    }
                                $i++;
                             }
                        }    
                        if($worksheet->getTitle()=="Sheet1"){
                            $sheetData=$worksheet->toArray();
                                 $i=0;
                                $importData_arr = array();
                                
                                $stock1 = array();
                                $stock2 = array();
                                $stock3 = array();
                                $stock4 = array();
                                $stock5 = array();
                                $stock6 = array();
                                
                                $stock1_i = array();
                                $stock2_i = array();
                                $stock3_i = array();
                                $stock4_i = array();
                                $stock5_i = array();
                                $stock6_i = array();
                                $m='0';
                                $ids=[];
                                
                                foreach($sheetData as $key=>$data1){
                                   
                                    $records = array();
                                    if($i>0 && $i<count($sheetData)){
                                       // if($i>0 && $i<count($sheetDatas) && $datas[7]!=""){
                                        $product="";
                                        if($data1[7]!=""){
                                         $product=$this->db->query("select * from products where style_no='".$data1[7]."'")->getRow();
                                        }
                                        
                                        if($product){
                                        $ids[]=$product->id;
                                        $id=$product->id;
                                        if($data1[1]=='White'){
                                            $j="1";
                                        }else if($data1[1]=='Yellow'){
                                            $j="2";
                                        }else if($data1[1]=='Pink'){
                                            $j="3";
                                        }
                                        if($data1[3]=='14K'){
                                            $l="1";
                                        }else if($data1[3]=='18K'){
                                            $l="2";
                                        }
                                        if($l=="1" && $j=="1"){
                                            $stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock1[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="2" && $j=="1"){
                                            $stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock2[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="1" && $j=="2"){
                                            $stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock3[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="2" && $j=="2"){
                                            $stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock4[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="1" && $j=="3"){
                                            $stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock5[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="2" && $j=="3"){
                                            $stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock6[$id.'_231_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }
                                        
                                        
                                        
                                        if($l=="1" && $j=="1"){
                                            $stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock1_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="2" && $j=="1"){
                                            $stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock2_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="1" && $j=="2"){
                                            $stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock3_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="2" && $j=="2"){
                                            $stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock4_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="1" && $j=="3"){
                                            $stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock5_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }else if($l=="2" && $j=="3"){
                                            $stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['id'] = $id;
            								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['sku'] = $data1[0];
            								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['color'] = $data1[1];
            								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['size'] = $data1[2];
            								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['purity'] = $data1[3];
            								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['price'] = $data1[4];
            								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['mrp'] = $data1[5];
            								$stock6_i[$id.'_101_'.$l.$j.$m.$data1[2]]['stock'] = $data1[6];
                                        }
                                        
                                        
                                        
                                        }
                                }
                                $i++;
            				}
            				
            				$result = array_unique($ids);
            				foreach($result as $key=>$row){
                            $this->id=$row;
                            
                            $stocks1=array();
                            $stocks2=array();
                            $stocks3=array();
                            $stocks4=array();
                            $stocks5=array();
                            $stocks6=array();
                            
                            if($stock1){
                            $stocks1=array_filter($stock1,array($this,'arrayFilter'));
                            }
                            if($stock2){
                            $stocks2=array_filter($stock2,array($this,'arrayFilter'));
                            }
                            if($stock3){
                            $stocks3=array_filter($stock3,array($this,'arrayFilter'));
                            }
                            if($stock4){
                            $stocks4=array_filter($stock4,array($this,'arrayFilter'));
                            }
                            if($stock5){
                            $stocks5=array_filter($stock5,array($this,'arrayFilter'));
                            }
                            if($stock6){
                            $stocks6=array_filter($stock6,array($this,'arrayFilter'));
                            }
                            $record2['product_id'] =$row;
                            $record2['country_code'] ='231';
                            $record2['jsondata1'] =json_encode($stocks1);
                            $record2['jsondata2'] =json_encode($stocks2);
                            $record2['jsondata3'] =json_encode($stocks3);
                            $record2['jsondata4'] =json_encode($stocks4);
                            $record2['jsondata5'] =json_encode($stocks5);
                            $record2['jsondata6'] =json_encode($stocks6);
                            $this->db->table('product_stock')->insert($record2);
                            
                            $stocks1_i=array();
                            $stocks2_i=array();
                            $stocks3_i=array();
                            $stocks4_i=array();
                            $stocks5_i=array();
                            $stocks6_i=array();
                            
                            
                            if($stock1_i){
                            $stocks1_i=array_filter($stock1_i,array($this,'arrayFilter'));
                            }
                            if($stock2_i){
                            $stocks2_i=array_filter($stock2_i,array($this,'arrayFilter'));
                            }
                            if($stock3_i){
                            $stocks3_i=array_filter($stock3_i,array($this,'arrayFilter'));
                            }
                            if($stock4_i){
                            $stocks4_i=array_filter($stock4_i,array($this,'arrayFilter'));
                            }
                            if($stock5_i){
                            $stocks5_i=array_filter($stock5_i,array($this,'arrayFilter'));
                            }
                            if($stock6_i){
                            $stocks6_i=array_filter($stock6_i,array($this,'arrayFilter'));
                            }
                            $record3['product_id'] =$row;
                            $record3['country_code'] ='101';
                            $record3['jsondata1'] =json_encode($stocks1_i);
                            $record3['jsondata2'] =json_encode($stocks2_i);
                            $record3['jsondata3'] =json_encode($stocks3_i);
                            $record3['jsondata4'] =json_encode($stocks4_i);
                            $record3['jsondata5'] =json_encode($stocks5_i);
                            $record3['jsondata6'] =json_encode($stocks6_i);
                            $this->db->table('product_stock')->insert($record3);
                            
            				}
                        }
                        }
                     
    				echo json_encode(array('status'=>1,'message'=>'Record Stock has been added successfully'));
    				}
    			}
    				
    	/*	}
            else {
			
			echo json_encode(array('status'=>0,'message'=>'Some error occured'));

		}*/
            
            
           
        }
        
    public function arrayFilter($var){
		if($var['id']==$this->id){
			return $var;
		}
	
		 
	 }

    public function publish($ids) {

        $id = $ids;
        $record = array();
        $record['status'] = '1';
        $record['updated_by'] = $this->currentuser->id;
        $record['updated_date'] = date('Y-m-d H:i:s');
        
        $this->db->table('products')->where('id',$id)->update($record);

        $notifications = array();
        $notifications['type'] = 'success';
        $notifications['message'] = 'Record publish successfully.';
        $this->session->setFlashdata('notifications', $notifications);

        return redirect()->to(site_url('admin/products'));

    }

    public function unpublish($ids) {

        $id = $ids;
        $record = array();
        $record['status'] = '0';
        $record['updated_by'] = $this->currentuser->id;
        $record['updated_date'] = date('Y-m-d H:i:s');

        $this->db->table('products')->where('id',$id)->update($record);

        $notifications = array();
        $notifications['type'] = 'success';
        $notifications['message'] = 'Record unpublish successfully.';
        $this->session->setFlashdata('notifications', $notifications);

        return redirect()->to(site_url('admin/products'));

    }


    public function deleteRecords($ids)
	{		
		
		if(!is_array($ids)) {
			$ids = array($ids);
		}

        
		foreach($ids AS $id) {
			$this->db->table('products')->where('id',$id)->delete();
            $this->db->table('product_stock')->where('product_id',$id)->delete();
		}

        $notifications = array();
        $notifications['type'] = 'success';
        $notifications['message'] = 'Record(s) deleted successfully.';
        $this->session->setFlashdata('notifications', $notifications);

		return redirect()->to(site_url('admin/products'));
	}

    public function check(){
        $this->purity = "White";
        $this->color = "14K";
        $id=$this->request->getPost('id');
        if($id){
            $res = $this->db->query("select * from product_stock where product_id='".$id."'")->getResultArray();
        }else{
            $res = $this->db->query("select * from product_stock")->getResultArray();
        }
        foreach($res as $keys => $val){
           $jsons1=json_decode($val['jsondata1']);
           $jsons2=json_decode($val['jsondata2']);
           $jsons3=json_decode($val['jsondata3']);
           $jsons4=json_decode($val['jsondata4']);
           $jsons5=json_decode($val['jsondata5']);
           $jsons6=json_decode($val['jsondata6']);
           
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
          $records=reset($final_array);
          $record=array();
          $record['mrp_default']=$records['mrp'];
          $record['color_default']=$records['color'];
          $record['price_default']=$records['price'];
          $record['size_default']=$records['size'];
          $record['purity_default']=$records['purity'];
          $record['stock_default']=$records['stock'];
          $record['sku_default']=$records['sku'];
          $record['stock_id_default']=$records['id'];
          $this->db->table('product_stock')->where(array('product_id'=>$val['product_id'],'country_code'=>$val['country_code']))->update($record);
         
        }
        echo json_encode(array('status'=>1,'message'=>'Record has been Organized successfully','product_id'=>$id));
    }
    
    public function test(){
        $products=$this->db->query("select * from products_set")->getResult();
        $record = array();
        
        foreach($products as $product){
            $intro_image=explode('.',$product->intro_image);
            $record['intro_image'] = $intro_image[0].'_.'.$intro_image[1];
            $record['intro_zoom'] = $product->intro_image;
            
           /* $yellow_image=explode('.',$product->yellow_image);
            $record['yellow_image'] = $yellow_image[0].'_.'.$yellow_image[1];
            $record['yellow_zoom'] = $product->yellow_image;
            
            $pink_image=explode('.',$product->pink_image);
            $record['pink_image'] = $pink_image[0].'_.'.$pink_image[1];
            $record['pink_zoom'] = $product->pink_image;*/
            
            $white_multi_image=json_decode($product->white_multi_image);
            $white_images = [];
            foreach ($white_multi_image as $key => $row) {
                if($row){
                    $white_image=explode('.',$row->image);
                    $image = $white_image[0].'_.'.$white_image[1];
                    $white_images[] = array('image'=>$image,'zoom'=>$row->image,'disp_order'=>$row->disp_order);
                }
            }
            $white_images_json = json_encode($white_images);
            $record['white_multi_image'] = $white_images_json;
            
            /*$yellow_multi_image=json_decode($product->yellow_multi_image);
            $yellow_images = [];
            foreach ($yellow_multi_image as $key => $row) {
                if($row){
                    $yellow_image=explode('.',$row->image);
                    $image = $yellow_image[0].'_.'.$yellow_image[1];
                    $yellow_images[] = array('image'=>$image,'zoom'=>$row->image,'disp_order'=>$row->disp_order);
                }
            }
            $yellow_images_json = json_encode($yellow_images);
            $record['yellow_multi_image'] = $yellow_images_json;
            
            $pink_multi_image=json_decode($product->pink_multi_image);
            $pink_images = [];
            foreach ($pink_multi_image as $key => $row) {
                if($row){
                    $pink_image=explode('.',$row->image);
                    $image = $pink_image[0].'_.'.$pink_image[1];
                    $pink_images[] = array('image'=>$image,'zoom'=>$row->image,'disp_order'=>$row->disp_order);
                }
            }
            $pink_images_json = json_encode($pink_images);
            $record['pink_multi_image'] = $pink_images_json;*/
            
            $this->db->table('products_set')->where('id',$product->id)->update($record);
            
        }
        
    }
    
    
}