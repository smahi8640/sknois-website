<?php 

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\Slug;   // use the Slug Library
use App\Models\CategoriesModel;

class Products_set extends BaseController
{
    
   
    public function index()
    {
        
        if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('admin');
        }
        
	    $data['title'] = 'Products Set';
	    //$data['records'] = $this->db->query("select * from products_set")->getResultArray();
	    //$data['rel_products'] = $this->db->query("select * from products")->getResultArray();
       $task = $this->request->getPost('task');
        if($task == 'delete') {
            $record_ids = $this->request->getPost('record_id');
            $this->deleteRecords($record_ids);
        }
        $data['records'] = $this->db->query("select * from products_set")->getResultArray();
	    return view('admin/pages/products_set/index',$data);
	    
        
    }

    public function product_list()
    {
        $session = session();
        if(empty($session->has('email'))){
            return redirect()->to('login');
        }
        $CategoriesModel = new CategoriesModel();
        $data['title'] = 'Products Set';
        $data['records'] = $this->db->query("select * from products_set")->getResultArray();
        return view('admin/pages/products_set/product_list',$data);   
    }

    public function getProductList(){
        $draw = $this->request->getPost('draw');
        $res = $this->db->query("select * from products_set")->getResultArray();
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
        $data['title'] = 'Products Set';
        //$CategoriesModel = new CategoriesModel();
        //$data['categoriestree'] = $CategoriesModel->fetchCategoryTreeAdmin();
        $data['rel_products'] = $this->db->query("select * from products_set")->getResultArray();
        $data['products'] = $this->db->query("select * from products")->getResultArray();
         $data['labels'] = $this->db->query("select * from product_labels")->getResult();
        $data['manufacturers'] = $this->db->query("select * from manufacturer")->getResult();
        //$data['rel_products'] = $this->db->query("select * from products")->getResult();
        if($id)
        {
            $data['record'] = $this->db->query("select * from products_set where id='".$id."'")->getRow();
        }
        
        return view('admin/pages/products_set/add', $data);
        
        
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
            
                //$record['category_ids'] = @implode(',', $this->request->getPost('category_ids[]'));
                
                $record['category_ids'] = $this->request->getPost('category_ids');
                
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
                
                if($this->request->getPost('product_ids[]') != '') {
                  $record['product_id'] = @implode(',', $this->request->getPost('product_ids[]'));
                } else {
                    $record['product_id'] = '';
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
               
                $this->db->table('products_set')->where('id',$id)->update($record);
                
                echo json_encode(array('status'=>1,'message'=>'Record has been updated successfully.','product_id'=>$id));
            
            } else {
            
                $record['created_by'] = $this->currentuser->id;
                $record['created_date'] = date('Y-m-d H:i:s');
                
                $this->db->table('products_set')->insert($record);
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
                $this->db->table('products_set')->where('id',$i)->delete();
            }

            echo json_encode(array('status'=>1,'message'=>'Record has been deleted successfully'));
            
        }

        
    }
    
    public function addstock()
    {
        $id=$this->request->getPost('id');
        $pid=$this->request->getPost('pid');
        $pstock=$this->db->query("select * from product_stock where product_id='".$this->request->getPost('pid')."'")->getResult();
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
    
     public function publish($ids) {

        $id = $ids;
        $record = array();
        $record['status'] = '1';
        $record['updated_by'] = $this->currentuser->id;
        $record['updated_date'] = date('Y-m-d H:i:s');
        
        $this->db->table('products_set')->where('id',$id)->update($record);

        $notifications = array();
        $notifications['type'] = 'success';
        $notifications['message'] = 'Record publish successfully.';
        $this->session->setFlashdata('notifications', $notifications);

        return redirect()->to(site_url('admin/products_set'));

    }

    public function unpublish($ids) {

        $id = $ids;
        $record = array();
        $record['status'] = '0';
        $record['updated_by'] = $this->currentuser->id;
        $record['updated_date'] = date('Y-m-d H:i:s');

        $this->db->table('products_set')->where('id',$id)->update($record);

        $notifications = array();
        $notifications['type'] = 'success';
        $notifications['message'] = 'Record unpublish successfully.';
        $this->session->setFlashdata('notifications', $notifications);

        return redirect()->to(site_url('admin/products_set'));

    }


    public function deleteRecords($ids)
	{		
		
		if(!is_array($ids)) {
			$ids = array($ids);
		}

        
		foreach($ids AS $id) {
			$this->db->table('products_set')->where('id',$id)->delete();
		}

        $notifications = array();
        $notifications['type'] = 'success';
        $notifications['message'] = 'Record(s) deleted successfully.';
        $this->session->setFlashdata('notifications', $notifications);

		return redirect()->to(site_url('admin/products_set'));
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
    
    public function check(){
        $id=$this->request->getPost('id');
        if($id){
            $products=$this->db->query("select * from products_set where id='".$id."'")->getResult();
        }else{
            $products=$this->db->query("select * from products_set")->getResult();
        }
        $record = array();
        $attr=[];
        foreach($products as $product){
            $pids=explode(',',$product->product_id);
            foreach($pids as $key1=>$pid){
                
            $product_id=$this->db->query("select * from products where id='".$pid."'")->getRow();
            $cats=explode(',',$product_id->category_ids);
            
                foreach($cats as $key=> $cat){
                    
                 $catid=$this->db->query("select * from categories where id='".$cat."' and parent_id='0'")->getRow();
                 if($catid){
                    $attr[$key+$key1]=$catid->id;
                 }
                }
            }
            $record['attribute_values']=implode(',',$attr);
            $this->db->table('products_set')->where('id',$product->id)->update($record);
            
        }
        echo json_encode(array('status'=>1,'message'=>'Record has been Organized successfully','product_id'=>$id));
        
    }
    
}