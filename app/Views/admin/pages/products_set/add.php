<?php $refer= @$_SERVER['HTTP_REFERER']; ?>
<!DOCTYPE html>
<html lang="en">
<head>

  <?= $this->include('admin/partial/head') ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed overlay-wrapper">
<div class="overlay" id="mab1" style="display:none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
<div class="wrapper">

  <?= $this->include('admin/partial/top') ?>

  <?= $this->include('admin/partial/sidemenu') ?>

  <?= $this->include('admin/partial/title') ?>
<?php $this->db = \Config\Database::connect();?>

 <form action="<?php echo base_url(''); ?>admin/products_set" id="save-form" class="records-list-form formvalidate" method="post" accept-charset="utf-8">
    
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $title; ?></h3><?php //echo (empty($cust))?"Add":"Update"; ?> 
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
            </div>
                
            <div class="card-body">
                <div class="form-row">
              
                        <div class="form-group col-md-3 d-none">
                            <label >Type :</label>
                            <select id="product_diamond" name="product_diamond" class="form-control">
                            <option value="1" <?=(@$record->types=="1") ? "selected" : "" ?>>Natural</option>
                            <!--<option value="2" <?//=(@$record->types=="2") ? "selected" : "" ?>>Lab-Grown</option>-->
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="c-name">Title (no special characters allowed):</label>
                            <input type="text" class="form-control" name="title" placeholder="Title" required value="<?php echo @$record->title?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="c-name">Alias :</label>
                            <input type="text" class="form-control" name="alias" placeholder="Alias"  value="<?php echo @$record->alias?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="c-name">Style Code :</label>
                            <input type="text" class="form-control" name="style_no" placeholder="Style No" required value="<?php echo @$record->style_no?>">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="c-name">Short Description :</label>
                            <textarea class="form-control" name="product_short_description"   ><?php echo @$record->product_short_description;?></textarea>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label for="c-name">Description :</label>
                            <textarea class="form-control summernot" name="description" id="summernot"  ><?php echo @$record->description;?></textarea>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="c-name">Gender :</label>
                            <select name="gender" class="form-control">
                                <?php if(@$record->gender=='1'){
                                    $selected1="selected";
                                    $selected2="";
                                    $selected4="";
                                    $selected3="";
                                }else if(@$record->gender=='2'){
                                    $selected1="";
                                    $selected2="selected";
                                    $selected4="";
                                    $selected3="";
                                }else if(@$record->gender=='3'){
                                    $selected1="";
                                    $selected2="";
                                    $selected4="";
                                    $selected3="selected";
                                }else if(@$record->gender=='4'){
                                    $selected1="";
                                    $selected2="";
                                    $selected3="";
                                    $selected4="selected";
                                }
                                ?>
                            <option value="1" <?php echo @$selected1; ?>>Male</option>
                            <option value="2" <?php echo @$selected2; ?>>Female</option>
                            <option value="3" <?php echo @$selected3; ?>>Kids</option>
                            <option value="4" <?php echo @$selected4; ?>>Unisex</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="c-name">MRP :</label>
                            <input type="number" class="form-control" name="product_price" placeholder="MRP" value="<?php echo @$record->product_price?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="c-name">Final Price :</label>
                            <input type="number" class="form-control" name="product_final_price" placeholder="Final Price" value="<?php echo @$record->product_final_price?>">
                        </div>
                        
                        <!--<div class="form-group col-md-4 d-none">
                            <label for="c-name">Collection :</label>
                            <div class="select2-purple">
                            <select class="select2" data-dropdown-css-class="select2-purple" name="category_ids[]" multiple="multiple"  data-placeholder="Select Category" style="width: 100%;">
                                <?php 
                                    //foreach ($categoriestree AS $category) {
                                    //    $selected='';
                                    //    foreach(explode(',',@$record->category_ids) as $j){
                                    //    if($category['id']==$j){
                                     //       $selected='selected';
                                    //    }
                                    //    }
                                ?>
                                <option value="<?php //echo $category['id']; ?>" <?php //echo $selected; ?>><?php //echo $category['title'];?></option>
                                <?php //}?>
                            </select>
                            </div>
                        </div>-->
                        
                      
                        <div class="form-group col-md-4">
                            <label for="c-name">Collection :</label>
                            <div class="select2-purple">
                                <select  id="category_ids" name="category_ids" data-dropdown-css-class="select2-purple" class="form-control select2" data-tags="true">
                                    <option value="">----</option>
                                    <?php
                                    $category_ids=$this->db->query("select distinct(category_ids) from products_set where category_ids IS NOT NULL order by category_ids asc")->getResult();
                                        if(@$category_ids){ 
                                            foreach($category_ids as  $v){
                                                $selected='';
                                                if($v->category_ids==@$record->category_ids){
                                                    $selected="selected";
                                                }else{
                                                    $selected="";
                                                }
                                                echo "<option value='".$v->category_ids."' '".$selected."'>".$v->category_ids."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-12 ">
                            <label for="c-name">Products (Multiple):</label>
                            <div class="select2-purple">
                                <?php
                                $selected1=array();
                                foreach(explode(',',@$record->product_id) as $l){
                                    $datas=$this->db->query("select * from products where id='".$l."'")->getRow();
                                    $selected1[$l]=$datas->title;
                                }
                                    
                                ?>
                            <select  id="multiproduct"  name="product_ids[]" multiple="multiple" data-placeholder="Select Products" style="width: 100%;">
                                <?php 
                                    foreach($selected1 AS $key => $product) {
                                ?>
                                <option value="<?php echo @$key; ?>" selected><?php echo @$product;?></option>
                                <?php }?>
                                <?php 
                                    foreach($products AS $product) {
                                    ?>
                                <option value="<?php echo @$product['id']; ?>"><?php echo @$product['title'];?></option>
                                <?php }?>
                            </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Labels :</label>
                            <div class="select2-purple">
                            <select class="select2" data-dropdown-css-class="select2-purple" name="label_ids[]" multiple="multiple" data-placeholder="Select Label" style="width: 100%;">
                                <?php 
                                    foreach ($labels AS $label) {
                                        $selected='';
                                        foreach(explode(',',@$record->label_ids) as $k){
                                        if($label->id==$k){
                                            $selected='selected';
                                        }
                                        }
                                ?>
                                <option value="<?php echo $label->id; ?>" <?php echo $selected; ?>><?php echo $label->title;?></option>
                                <?php }?>
                            </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4 ">
                            <label for="c-name">Related Sets :</label>
                            <div class="select2-purple">
                            <select class="select2" data-dropdown-css-class="select2-purple" name="related_product_ids[]" multiple="multiple" data-placeholder="Select Related Sets" style="width: 100%;">
                                <?php 
                                    foreach ($rel_products AS $rel_product) {
                                        $selected='';
                                        foreach(explode(',',@$record->related_product_ids) as $l){
                                        if(@$rel_product['id']==$l){
                                            $selected='selected';
                                        }
                                        }
                                ?>
                                <option value="<?php echo @$rel_product['id']; ?>" <?php echo $selected; ?>><?php echo @$rel_product['title'];?></option>
                                <?php }?>
                            </select>
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Sku Code :</label>
                            <input type="text" class="form-control" name="product_sku" placeholder="Sku Code" value="<?php echo @$record->product_sku?>">
                        </div>
                        
                        
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Item No :</label>
                            <input type="text" class="form-control" name="item_no" placeholder="Item No" value="<?php echo @$record->item_no?>">
                        </div>
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Lab Name :</label>
                            <input type="text" class="form-control" name="lab_name" placeholder="Lab Name" value="<?php echo @$record->lab_name?>">
                        </div>
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Height :</label>
                            <input type="text" class="form-control" name="height" placeholder="Height" value="<?php echo @$record->height?>">
                        </div>
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Width :</label>
                            <input type="text" class="form-control" name="width" placeholder="Width" value="<?php echo @$record->width?>">
                        </div>
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Lenght :</label>
                            <input type="text" class="form-control" name="lenght" placeholder="Lenght" value="<?php echo @$record->lenght?>">
                        </div>
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Weight :</label>
                            <input type="text" class="form-control" name="weight" placeholder="Weight" value="<?php echo @$record->weight?>">
                        </div>
                        
                        <div class="form-group col-md-4 d-none">
                            <label for="c-name">Purity :</label>
                            <input type="text" class="form-control" name="purity" placeholder="Purity" value="<?php echo @$record->purity?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="c-name">Display Order :</label>
                            <input type="number" class="form-control" name="disp_order" placeholder="1" value="<?php echo @$record->disp_order?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="c-name">Search Key word :</label>
                            <div class="select2-purple">
                                <select  id="products_keys" name="products_keys[]" data-dropdown-css-class="select2-purple" class="form-control select2" data-tags="true" multiple="multiple">
                                    <?php
                                        if(@$record->products_keys){ 
                                            $product_keys =  explode(',', @$record->products_keys); 
                                            if($product_keys){
                                                foreach($product_keys as $k => $v){
                                                    echo "<option value='".$v."' selected>".$v."</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <!-- <input type="text" class="form-control" name="products_keys" id='products_keys' placeholder="Meta Keyword"  value="<?php //echo @$record->products_keys?>">  -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="c-name">Status :</label>
                            <select name="status" class="form-control">
                                <?php if(@$record->status=='1'){
                                    $selected1="selected";
                                    $selected2="";
                                }else if(@$record->status=='0'){
                                    $selected1="";
                                    $selected2="selected";
                                }
                                ?>
                            <option value="1" <?php echo $selected1; ?>>Published</option>
                            <option value="0" <?php echo $selected2; ?>>Unpublished</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="c-name">Meta Title :</label>
                            <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" value="<?php echo @$record->meta_title?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="c-name">Meta Tags :</label>
                            <input type="text" class="form-control" name="meta_tags" placeholder="Meta Tags" value="<?php echo @$record->meta_tags?>">
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label for="c-name">Meta Description :</label>
                            <textarea class="form-control summernote333" name="meta_description"   ><?php echo @$record->meta_description;?></textarea>
                        </div>
                    </div>

                    <?php 
                        if(@$record->video != '') {
                        $videos = json_decode(@$record->video);
                        } else {
                        $videos = array();
                        }
                    ?>
                        <div class="row">
                        <?php 
                        $video_white="";
                        $video_yellow="";
                        $video_pink="";
                        $video_white_disp_order="";
                        $video_yellow_disp_order="";
                        $video_pink_disp_order="";
                        if(!empty($videos)) {                             
                            foreach($videos AS $video) {
                                if($video->type=="white"){
                                    $video_white=$video->video;
                                    $video_white_disp_order=$video->disp_order;
                                }else if($video->type=="yellow"){
                                    $video_yellow=$video->video;
                                    $video_yellow_disp_order=$video->disp_order;
                                }else if($video->type=="pink"){
                                    $video_pink=$video->video;
                                    $video_pink_disp_order=$video->disp_order;
                                }
                            }
                        }
                        ?>
                            <div class="form-group col-md-4">
                                
                                <label for="c-name">Video :</label>
                                <div class="input-group">
                                    <input class="form-control image_path col-md-9" id="video_white" name="video_white"  value="<?php echo @$video_white; ?>"/>
                                    <input type="text" name="video_white_disp_order" value="<?= ($video_white_disp_order) ? $video_white_disp_order : "0"; ?>" placeholder="order" id="product_disp_order" class="form-control col-md-2" />     
                                    <div class="input-group-append">
                                        <a href="<?php echo base_url('assets/'); ?>/filemanager/dialog.php?type=2&amp;field_id=video_white&amp;relative_url=1" data-fancybox-type="iframe" class="btn btn-primary iframe-btn" type="button">Select</a>
                                    </div>
                                </div>    
                                <div class="uploaded_images input-group-append">
                                    <?php 
                                        if(!empty(@$video_white)){?>
                                        <video controls width="150" height="80">  
                                        <source src="<?php echo base_url('media/source/'.@$video_white); ?>" type="video/mp4">  
                                        Your browser does not support the html video tag.  
                                        </video>
                                    <?php }?>   
            
                                </div>                                                       
                            </div>
                            <div class="form-group col-md-4 d-none">                               
                                <label for="c-name">Video Yellow:</label>
                                <div class="input-group">
                                    <input class="form-control image_path col-md-9" id="video_yellow" name="video_yellow"  value="<?php echo @$video_yellow; ?>"/>
                                    <input type="text" name="video_yellow_disp_order" value="<?= ($video_yellow_disp_order) ? $video_yellow_disp_order : "0"; ?>" placeholder="order"  id="product_disp_order" class="form-control col-md-2" />     
                                    <div class="input-group-append">
                                        <a href="<?php echo base_url('assets/'); ?>/filemanager/dialog.php?type=2&amp;field_id=video_yellow&amp;relative_url=1" data-fancybox-type="iframe" class="btn btn-primary iframe-btn" type="button">Select</a>
                                    </div>
                                </div>    
                                <div class="uploaded_images input-group-append">
                                    <?php 
                                        if(!empty(@$video_yellow)){?>
                                        <video controls width="150" height="80">  
                                        <source src="<?php echo base_url('media/source/'.@$video_yellow); ?>" type="video/mp4">  
                                        Your browser does not support the html video tag.  
                                        </video>
                                    <?php }?>   
                                </div>                                 
                            </div>
                            <div class="form-group col-md-4 d-none">
                                <label for="c-name">Video Pink:</label>
                                <div class="input-group">
                                    <input class="form-control image_path col-md-9" id="video_pink" name="video_pink"  value="<?php echo @$video_pink; ?>"/>
                                    <input type="text" name="video_pink_disp_order" value="<?= ($video_pink_disp_order) ? $video_pink_disp_order : "0"; ?>" placeholder="order" id="product_disp_order" class="form-control col-md-2" /> 
                                    <div class="input-group-append">
                                        <a href="<?php echo base_url('assets/'); ?>/filemanager/dialog.php?type=2&amp;field_id=video_pink&amp;relative_url=1" data-fancybox-type="iframe" class="btn btn-primary iframe-btn" type="button">Select</a>
                                    </div>
                                </div>    
                                <div class="uploaded_images input-group-append">
                                    <?php 
                                    if(!empty(@$video_pink)){?>
                                        <video controls width="150" height="80">  
                                        <source src="<?php echo base_url('media/source/'.@$video_pink); ?>" type="video/mp4">  
                                        Your browser does not support the html video tag.  
                                        </video>
                                    <?php }?>
                                    
                                        
                                </div>                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                    <label for="c-name">Image :</label>
                                    <div class="input-group">   
                                      <input class="form-control image_path" id="intro_image" name="intro_image" value="<?php echo @$record->intro_image?>" placeholder="Image"/>
                                      <div class="input-group-append">
                                          <a href="<?php echo base_url('assets/filemanager/dialog.php?type=1&field_id=intro_image&relative_url=1'); ?>" data-fancybox-type="iframe" class="btn btn-default iframe-btn" type="button">Select</a>
                                      </div>
                                      <input class="form-control image_path" id="intro_zoom" name="intro_zoom" value="<?= (@$record->intro_zoom)?@$record->intro_zoom:@$record->intro_image ?>" placeholder="Zoom Image"/>
                                      <div class="input-group-append">
                                          <a href="<?php echo base_url('assets/filemanager/dialog.php?type=1&field_id=intro_zoom&relative_url=1'); ?>" data-fancybox-type="iframe" class="btn btn-default iframe-btn" type="button">Select</a>
                                      </div>
                                    </div>
                                    <div class="uploaded_images input-group-append">
                                          
                                          <?php if(!empty(@$record->intro_image)) { ?>
                                            <div class="uploaded_image_ele">
                                              <img id="image-preview" style="max-height:80px;max-width:80px;" src="<?php echo base_url('media/source/'.@$record->intro_image); ?>" data-attr="<?php echo  @$record->id; ?>" class="uploaded_image">
                                            </div>
                                          <?php } else { ?>
                                              <div class="uploaded_image_ele" id="div-preview"  style="display:none;">
                                                <img style="max-height:80px;max-width:80px;" src="#"  id="image-preview" class="uploaded_image">
                                              </div>
                                          <?php } ?>
                
                                      </div>
                                    
                                </div> 
                                
                            <div class="form-group col-md-4 d-none">
                                <label for="c-name">Yellow Image :</label>
                                <div class="input-group">
                                  <input class="form-control image_path" id="yellow_image" name="yellow_image" value="<?php echo @$record->yellow_image?>"/>
                                  <div class="input-group-append">
                                      <a href="<?php echo base_url('assets/filemanager/dialog.php?type=1&field_id=yellow_image&relative_url=1'); ?>" data-fancybox-type="iframe" class="btn btn-default iframe-btn" type="button">Select</a>
                                  </div>
                                </div>
                                
                                <div class="uploaded_images input-group-append">
                                      
                                      <?php if(!empty(@$record->yellow_image)) { ?>
                                        <div class="uploaded_image_ele">
                                          <img id="image-preview" style="max-height:80px;max-width:80px;" src="<?php echo base_url('media/source/'.@$record->yellow_image); ?>" data-attr="<?php echo  @$record->id; ?>" class="uploaded_image">
                                        </div>
                                      <?php } else { ?>
                                          <div class="uploaded_image_ele" id="div-preview_yellow"  style="display:none;">
                                            <img style="max-height:80px;max-width:80px;" src="#"  id="image-preview_yellow" class="uploaded_image">
                                          </div>
                                      <?php } ?>
            
                                  </div>
                                
                            </div> 
                                
                            <div class="form-group col-md-4 d-none">
                                <label for="c-name">Pink Image :</label>
                                <div class="input-group">     
                                  <input class="form-control image_path" id="pink_image" name="pink_image" value="<?php echo @$record->pink_image?>"/>
                                  <div class="input-group-append">
                                      <a href="<?php echo base_url('assets/filemanager/dialog.php?type=1&field_id=pink_image&relative_url=1'); ?>" data-fancybox-type="iframe" class="btn btn-default iframe-btn" type="button">Select</a>
                                  </div>
                                </div>
                                <div class="uploaded_images input-group-append">
                                      
                                      <?php if(!empty(@$record->pink_image)) { ?>
                                        <div class="uploaded_image_ele">
                                          <img id="image-preview" style="max-height:80px;max-width:80px;" src="<?php echo base_url('media/source/'.@$record->pink_image); ?>" data-attr="<?php echo  @$record->id; ?>" class="uploaded_image">
                                        </div>
                                      <?php } else { ?>
                                          <div class="uploaded_image_ele" id="div-preview_pink"  style="display:none;">
                                            <img style="max-height:80px;max-width:80px;" src="#"  id="image-preview_pink" class="uploaded_image">
                                          </div>
                                      <?php } ?>
            
                                  </div>
                                
                            </div> 
                                
                        </div>
                        <div class="row">
                            <?php 
                              if(@$record->white_multi_image != '') {
                                $white_multi_image = json_decode($record->white_multi_image);
                              } else {
                                $white_multi_image = array();
                              }
                            ?>
                            <div  class="form-group col-md-4">
                              <label for="white_multi_image">Product Images</label>																								
                              <div class="white_multi_image_action">
                                <input type="hidden" name="white_multi_image_list" id="white_multi_image_list">
                                <a href="<?php echo base_url('assets/filemanager/dialog.php?type=1&field_id=white_multi_image_list&relative_url=1'); ?>" class="btn bg-orange btn-add_media_image iframe-btn" data-fancybox-type="iframe" >Select Images</a>
                                <div class="text-danger small">Note : Add/Remove image(s) of Product.</div>
                              </div>
                              <hr/>
                              <div id="white_multi_image_list-wrapper" class="white_multi_image_list-wrapper todo-list">
                              
                                  <?php if(!empty($white_multi_image)) { ?>
                
                                    <?php $i = 0; foreach($white_multi_image AS $white_multi_img) { ?>
                                    <div class="white_multi_image_list-container">
                                      <div class="input-group mb-2">
                                     
                                        <input type="text" name="white_multi_image[]" value="<?php echo $white_multi_img->image; ?>"  id="white_multi_image<?php echo $i; ?>" class="form-control" placeholder="Image"/>
                                        <input type="text" name="white_multi_zoom[]" value="<?= (@$white_multi_img->zoom)?@$white_multi_img->zoom:@$white_multi_img->image ?>"  id="white_multi_zoom<?php echo $i; ?>" class="form-control" placeholder="Zoom Image" />
                                        <input type="text" name="white_disp_order[]" value="<?php echo $white_multi_img->disp_order; ?>"  id="product_disp_order<?php echo $i; ?>" class="form-control" />
                                        <span class="input-group-btn">
                                          <a href="#" class="btn btn-danger remove_field"><i class="fas fa-times" aria-hidden="true"></i></a>
                                        </span>
                                        <img style="max-height:80px;max-width:80px;" src="<?php echo base_url().'/media/source/'.$white_multi_img->image; ?>"  id="image-preview" class="uploaded_image">
                                      </div>
                                     
                                    </div>
                                    <?php $i++; } ?>
                
                                  <?php }else{ 
                                      for($j=1;$j<=5;$j++){
                                      ?>
                                    <div class="white_multi_image_list-container">
                                      <div class="input-group mb-2">                                     
                                        <input type="text" name="white_multi_image[]" value=""  id="white_multi_image<?php echo $j; ?>" class="form-control" placeholder="Image"/>
                                        <input type="text" name="white_multi_zoom[]" value=""  id="white_multi_zoom<?php echo $j; ?>" class="form-control" placeholder="Zoom Image"/>
                                        <input type="text" name="white_disp_order[]" value="<?= $j; ?>"  id="product_disp_order<?php echo $j; ?>" class="form-control" />
                                        <span class="input-group-btn">
                                          <a href="#" class="btn btn-danger remove_field"><i class="fas fa-times" aria-hidden="true"></i></a>
                                        </span>                                        
                                      </div>                                     
                                    </div>
                                 <?php  }} ?>
                                </div>
                            </div>
                            <?php 
                              if(@$record->yellow_multi_image != '') {
                                $yellow_multi_image = json_decode($record->yellow_multi_image);
                              } else {
                                $yellow_multi_image = array();
                              }
                            ?>
                            <div  class="form-group col-md-4 d-none">
                              <label for="yellow_multi_image">Yellow Images</label>																								
                              <div class="yellow_multi_image_action">
                                <input type="hidden" name="yellow_multi_image_list" id="yellow_multi_image_list">
                                <a href="<?php echo base_url('assets/filemanager/dialog.php?type=1&field_id=yellow_multi_image_list&relative_url=1'); ?>" class="btn bg-orange btn-add_media_image iframe-btn" data-fancybox-type="iframe" >Select Images</a>
                                <div class="text-danger small">Note : Add/Remove image(s) of Product.</div>
                              </div>
                              <hr/>
                              <div id="yellow_multi_image_list-wrapper" class="yellow_multi_image_list-wrapper todo-list">
                              
                                  <?php if(!empty($yellow_multi_image)) { ?>
                
                                    <?php $i = 0; foreach($yellow_multi_image AS $yellow_multi_img) { ?>
                                    <div class="yellow_multi_image_list-container">
                                      <div class="input-group mb-2">
                                     
                                        <input type="text" name="yellow_multi_image[]" value="<?php echo $yellow_multi_img->image; ?>"  id="yellow_multi_imageID<?php echo $i; ?>" class="form-control" />
                                        <input type="text" name="yellow_disp_order[]" value="<?php echo $yellow_multi_img->disp_order; ?>"  id="product_disp_order<?php echo $i; ?>" class="form-control" />
                                        
                                        <span class="input-group-btn">
                                         <a href="#" class="btn btn-danger remove_field_yellow"><i class="fas fa-times" aria-hidden="true"></i></a>
                                        </span>
                                        <img style="max-height:80px;max-width:80px;" src="<?php echo base_url().'/media/source/'.$yellow_multi_img->image; ?>"  id="image-preview_yellow" class="uploaded_image">
                                      </div>
                                     
                                    </div>
                                    <?php $i++; } ?>
                
                                    <?php }else{ 
                                      for($j=1;$j<=5;$j++){
                                      ?>
                                    <div class="yellow_multi_image_list-container">
                                      <div class="input-group mb-2">
                                     
                                        <input type="text" name="yellow_multi_image[]" value=""  id="yellow_multi_imageID<?php echo $j; ?>" class="form-control" />
                                        <input type="text" name="yellow_disp_order[]" value="<?= $j; ?>"  id="product_disp_order<?php echo $j; ?>" class="form-control" />
                                        
                                        <span class="input-group-btn">
                                         <a href="#" class="btn btn-danger remove_field_yellow"><i class="fas fa-times" aria-hidden="true"></i></a>
                                        </span>
                                        
                                      </div>
                                     
                                    </div>
                                 <?php  }} ?>
                
                                </div>
                            </div>
                            
                            <?php 
                              if(@$record->pink_multi_image != '') {
                                $pink_multi_image = json_decode($record->pink_multi_image);
                              } else {
                                $pink_multi_image = array();
                              }
                            ?>
                            <div  class="form-group col-md-4 d-none">
                              <label for="pink_multi_image">Pink Images</label>																								
                              <div class="pink_multi_image_action">
                                <input type="hidden" name="pink_multi_image_list" id="pink_multi_image_list">
                                <a href="<?php echo base_url('assets/filemanager/dialog.php?type=1&field_id=pink_multi_image_list&relative_url=1'); ?>" class="btn bg-orange btn-add_media_image iframe-btn" data-fancybox-type="iframe" >Select Images</a>
                                <div class="text-danger small">Note : Add/Remove image(s) of Product.</div>
                              </div>
                              <hr/>
                              <div id="pink_multi_image_list-wrapper" class="pink_multi_image_list-wrapper todo-list">
                              
                                  <?php if(!empty($pink_multi_image)) { ?>
                
                                    <?php $i = 0; foreach($pink_multi_image AS $pink_multi_img) { ?>
                                    <div class="pink_multi_image_list-container">
                                      <div class="input-group mb-2">
                                     
                                        <input type="text" name="pink_multi_image[]" value="<?php echo $pink_multi_img->image; ?>"  id="pink_multi_imageID<?php echo $i; ?>" class="form-control" />
                                        <input type="text" name="pink_disp_order[]" value="<?php echo $pink_multi_img->disp_order; ?>"  id="product_disp_order<?php echo $i; ?>" class="form-control" />
                                        
                                        <span class="input-group-btn">
                                         <a href="#" class="btn btn-danger remove_field_pink"><i class="fas fa-times" aria-hidden="true"></i></a>
                                        </span>
                                        <img style="max-height:80px;max-width:80px;" src="<?php echo base_url().'/media/source/'.$pink_multi_img->image; ?>"  id="image-preview_pink" class="uploaded_image">
                                      </div>
                                     
                                    </div>
                                    <?php $i++; } ?>
                
                                    <?php }else{ 
                                      for($j=1;$j<=5;$j++){
                                      ?>
                                    <div class="pink_multi_image_list-container">
                                      <div class="input-group mb-2">
                                     
                                        <input type="text" name="pink_multi_image[]" value=""  id="pink_multi_imageID<?php echo $j; ?>" class="form-control" />
                                        <input type="text" name="pink_disp_order[]" value="<?= $j; ?>"  id="product_disp_order<?php echo $j; ?>" class="form-control" />
                                        
                                        <span class="input-group-btn">
                                         <a href="#" class="btn btn-danger remove_field_pink"><i class="fas fa-times" aria-hidden="true"></i></a>
                                        </span>
                                       </div>
                                     
                                    </div>
                                 <?php  }} ?>
                
                                </div>
                            </div>
                            
                            
                            </div>
                        <?php 
                            $diamonds = json_decode(@$record->diamond_data); 
                           
                            //if($diamonds){
                            //foreach($diamonds as $diamond){
                        ?>
                        <div class="row d-none">   
                            <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Diamond
                                    </h3>                                   
                                 </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col">
                                            
                                            <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label >Color :</label>
                                                <select name="diamond_color" id="color" class="form-control">
                                                <option value="D-E" <?=(@$diamonds[0]->color=="D-E") ? "selected" : "" ?>>D-E</option>
                                                <option value="E-F" <?=(@$diamonds[0]->color=="E-F") ? "selected" : "" ?>>E-F</option>
                                                <option value="F-G" <?=(@$diamonds[0]->color=="F-G") ? "selected" : "" ?>>F-G</option>
                                                <option value="G-H" <?=(@$diamonds[0]->color=="G-H") ? "selected" : "" ?>>G-H</option>
                                                </select>
                                                
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label >Clarity :</label>
                                                <select id="clarity" name="clarity" class="form-control">
                                                <option value="VVS" <?=(@$diamonds[0]->clarity=="VVS") ? "selected" : "" ?>>VVS</option>
                                                <option value="VS" <?=(@$diamonds[0]->clarity=="VS") ? "selected" : "" ?>>VS</option>
                                                <option value="VS-SI" <?=(@$diamonds[0]->clarity=="VS-SI") ? "selected" : "" ?>>VS-SI</option>
                                                <option value="SI" <?=(@$diamonds[0]->clarity=="SI") ? "selected" : "" ?>>SI</option>
                                                <option value="SI-1" <?=(@$diamonds[0]->clarity=="SI-1") ? "selected" : "" ?>>SI-1</option>
                                                <option value="I" <?=(@$diamonds[0]->clarity=="I") ? "selected" : "" ?>>I</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label >Setting Type :</label>
                                                <select id="setting_type" name="setting_type" class="form-control">
                                                <option value="Prong" <?=(@$diamonds[0]->setting_type=="Prong") ? "selected" : "" ?>>Prong</option>
                                                <option value="Bezel" <?=(@$diamonds[0]->setting_type=="Bezel") ? "selected" : "" ?>>Bezel</option>
                                                <option value="Pave" <?=(@$diamonds[0]->setting_type=="Pave") ? "selected" : "" ?>>Pave</option>
                                                <option value="Channel" <?=(@$diamonds[0]->setting_type=="Channel") ? "selected" : "" ?>>Channel</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label >Unit :</label>
                                                <select id="unit" name="diamond_unit" class="form-control">
                                                <option value="ct" <?=(@$diamonds[0]->diamond_type=="ct") ? "selected" : "" ?>>ct</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2 d-none">
                                                <label for="c-name">Diameter :</label>
                                                <input type="text" class="form-control" id="diameter" name="diameter" placeholder="Diameter" value="<?php echo @$diamonds[0]->diameter?>" >
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="c-name">Total Diamond Count :</label>
                                                <input type="text" class="form-control" id="count" name="count" placeholder="Count" value="<?php echo @$diamonds[0]->count?>" >
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="c-name">Total Diamond Weight :</label>
                                                <input type="text" class="form-control" id="weight"  name="diamond_weight" placeholder="Weight" value="<?php echo @$diamonds[0]->weight?>" >
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label for="c-name">Diamond Type :</label>
                                                <select id="diamond"  name="diamond_type" class="form-control">
                                                <option value="Natural Diamond" <?=(@$diamonds[0]->diamond_type=="Natural Diamond") ? "selected" : "" ?>>Natural Diamond</option>
                                                <option value="Laboratory Grown Diamond" <?=(@$diamonds[0]->diamond_type=="Laboratory Grown Diamond") ? "selected" : "" ?>>Laboratory Grown Diamond</option>
                                                <option value="Lab Grown Diamond" <?=(@$diamonds[0]->diamond_type=="Lab Grown Diamond") ? "selected" : "" ?>>Lab Grown Diamond</option>    
                                                <option value="Mined Diamond" <?=(@$diamonds[0]->diamond_type=="Mined Diamond") ? "selected" : "" ?>>Mined Diamond</option>
                                            </select>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label for="c-name">Center Diamond Weight :</label>
                                                <input type="text" class="form-control" id="center_weight" name="center_weight" placeholder="Center Diamond Weight" value="<?php echo @$diamonds[0]->center_weight?>" >
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label >Center Diamond Color :</label>
                                                <select id="center_color" name="center_color" class="form-control">
                                                <option value="D-E" <?=(@$diamonds[0]->color=="D-E") ? "selected" : "" ?>>D-E</option>
                                                <option value="E-F" <?=(@$diamonds[0]->color=="E-F") ? "selected" : "" ?>>E-F</option>
                                                <option value="F-G" <?=(@$diamonds[0]->color=="F-G") ? "selected" : "" ?>>F-G</option>
                                                <option value="G-H" <?=(@$diamonds[0]->color=="G-H") ? "selected" : "" ?>>G-H</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label >Center Diamond Clarity :</label>
                                                <select id="center_clarity" name="center_clarity" class="form-control">
                                                <option value="VVS" <?=(@$diamonds[0]->clarity=="VVS") ? "selected" : "" ?>>VVS</option>
                                                <option value="VS" <?=(@$diamonds[0]->clarity=="VS") ? "selected" : "" ?>>VS</option>
                                                <option value="VS-SI" <?=(@$diamonds[0]->clarity=="VS-SI") ? "selected" : "" ?>>VS-SI</option>
                                                <option value="SI" <?=(@$diamonds[0]->clarity=="SI") ? "selected" : "" ?>>SI</option>
                                                <option value="SI-1" <?=(@$diamonds[0]->clarity=="SI-1") ? "selected" : "" ?>>SI-1</option>
                                                <option value="I" <?=(@$diamonds[0]->clarity=="I") ? "selected" : "" ?>>I</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label for="c-name">Side Diamond Weight :</label>
                                                <input type="text" class="form-control" id="side_weight" name="side_weight" placeholder="Side Diamond Weight" value="<?php echo @$diamonds[0]->side_weight?>" >
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label >Side Diamond Color :</label>
                                                
                                                <select id="side_color" name="side_color" class="form-control">
                                                <option value="D-E" <?=(@$diamonds[0]->color=="D-E") ? "selected" : "" ?>>D-E</option>
                                                <option value="E-F" <?=(@$diamonds[0]->color=="E-F") ? "selected" : "" ?>>E-F</option>
                                                <option value="F-G" <?=(@$diamonds[0]->color=="F-G") ? "selected" : "" ?>>F-G</option>
                                                <option value="G-H" <?=(@$diamonds[0]->color=="G-H") ? "selected" : "" ?>>G-H</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label >Side Diamond Clarity :</label>
                                                <select id="side_clarity" name="side_clarity" class="form-control">
                                                <option value="VVS" <?=(@$diamonds[0]->clarity=="VVS") ? "selected" : "" ?>>VVS</option>
                                                <option value="VS" <?=(@$diamonds[0]->clarity=="VS") ? "selected" : "" ?>>VS</option>
                                                <option value="VS-SI" <?=(@$diamonds[0]->clarity=="VS-SI") ? "selected" : "" ?>>VS-SI</option>
                                                <option value="SI" <?=(@$diamonds[0]->clarity=="SI") ? "selected" : "" ?>>SI</option>
                                                <option value="SI-1" <?=(@$diamonds[0]->clarity=="SI-1") ? "selected" : "" ?>>SI-1</option>
                                                <option value="I" <?=(@$diamonds[0]->clarity=="I") ? "selected" : "" ?>>I</option>
                                                </select>
                                            </div>
                                            
                                            </div>
                                                    
                                        </div>
                                    </div>
                                </div>
                                
                        </div>
                        </div>
                        </div>
                        <?php //}}?>
                        <?php 
                            $chains = json_decode(@$record->chain_data); 
                            //if($chains){
                            //foreach($chains as $chain){
                        ?>
                        <div class="row d-none">
                            <div class="col-md-12">
                                <div class="card ">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Chain
                                        </h3>
                                        
                                     </div>
                                    <div class="card-body">
                                             
                                        <div class="row">
                                            <div class="col">
                                                        
                                               
                                                <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label >Metal :</label>
                                                    <input type="text" class="form-control" id="metal" name="metal" placeholder="Metal" value="<?php echo @$chains[0]->metal?>">
                                                </div>    
                                                <div class="form-group col-md-3">
                                                    <label >Color :</label>
                                                    <input type="text" class="form-control" id="color" name="chain_color" placeholder="Color" value="<?php echo @$chains[0]->color?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label >Purity :</label>
                                                    <input type="text" class="form-control" id="purity" name="chain_purity" placeholder="Purity" value="<?php echo @$chains[0]->purity?>">
                                                </div>
                                                
                                                <div class="form-group col-md-3">
                                                    <label >Unit :</label>
                                                    <input type="text" class="form-control" id="unit" name="chain_unit" placeholder="Unit" value="<?php echo @$chains[0]->unit?>">
                                                </div>
                                                 <div class="form-group col-md-3">
                                                    <label for="c-name">Type :</label>
                                                    <input type="text" class="form-control" id="types" name="types" placeholder="Type" value="<?php echo @$chains[0]->types?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="c-name">Adjustable :</label>
                                                    <input type="text" class="form-control" id="adjustable" name="adjustable" placeholder="Adjustable" value="<?php echo @$chains[0]->adjustable?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="c-name">Weight :</label>
                                                    <input type="text" class="form-control" id="weight" name="chain_weight" placeholder="Weight" value="<?php echo @$chains[0]->weight?>">
                                                </div>
                                                
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="card-footer">  
                                       
                                    </div>
                            </div>
                            </div>
                        </div>
                        <?php //}}?>     
                   
                <div class="clearfix"></div>
               
            </div>
            <div class="card-footer">
                <div class="row">
                   <div class="col-md-7">
                        <input type="hidden" name="id" id="product-id" value="<?php echo @$record->id;?>" />
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> SAVE DATA</button>
                    </div>
                    <div class="col-md-5 d-none">
                        <?php if(@$record){ ?>
                        <a id="withsize" class="btn btn-warning"><i class="fa fa-save"></i> Ring Size</a>
                        <a id="withoutsize" class="btn btn-info"><i class="fa fa-save"></i> Without Size</a>
                        <a id="deletestock" class="btn btn-danger"><i class="fa fa-trash"></i> Delete Stock</a>
                        <?php }?>
                </div>        
            </div>
        </div>   
        </div>
        </form>
        
      <?php if(@$record->id){?>
    
    <div class="card d-none">  
    
        <div class="card-header">
            <h3 class="card-title">  
            Product Stock India
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>    
            
        	
        </div>
        
        
        <div class="card-body ">
            <div class="row ">
                <form id="stock-save-india1" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="101" />
                <input type="hidden" name="type" id="type-code" value="1" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                           <!-- <th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $stocks=$this->db->query("select * from product_stock where product_id='".$record->id."' and country_code='101'")->getRow();
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata1);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-india2" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="101" />
                <input type="hidden" name="type" id="type-code" value="2" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata2);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-india3" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="101" />
                <input type="hidden" name="type" id="type-code" value="3" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata3);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-india4" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="101" />
                <input type="hidden" name="type" id="type-code" value="4" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata4);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-india5" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="101" />
                <input type="hidden" name="type" id="type-code" value="5" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata5);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-india6" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="101" />
                <input type="hidden" name="type" id="type-code" value="6" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata6);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
		</div>
		
		<div class="card-footer">
                
                <button type="submit" id="save_india" class="btn btn-success"><i class="fa fa-save"></i> SAVE STOCK</button>
            </div>
		
	</div>

      <?php }?>
      
      
      
      <?php if(@$record->id){?>
    <div class="card d-none">  
    
        <div class="card-header">
            <h3 class="card-title">  
            Product Stock US
             </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>    
           
        	
        </div>
        
        
         <div class="card-body ">
            <div class="row ">
                <form id="stock-save-us1" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="231" />
                <input type="hidden" name="type" id="type-code" value="1" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $stocks=$this->db->query("select * from product_stock where product_id='".$record->id."' and country_code='231'")->getRow();
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata1);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-us2" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="231" />
                <input type="hidden" name="type" id="type-code" value="2" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata2);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-us3" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="231" />
                <input type="hidden" name="type" id="type-code" value="3" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata3);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-us4" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="231" />
                <input type="hidden" name="type" id="type-code" value="4" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata4);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-us5" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="231" />
                <input type="hidden" name="type" id="type-code" value="5" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata5);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
    		
    		<div class="row mt-2">
                <form id="stock-save-us6" > 
                <input type="hidden" name="pid" id="product-id" value="<?php echo @$record->id;?>" />
                <input type="hidden" name="country_code" id="country-code" value="231" />
                <input type="hidden" name="type" id="type-code" value="6" />
                <table id="gold-reading" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purity</th>
                            <!--<th>Center Diamond</th>-->
                            <th>Price</th>
                            <th>Mrp</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($stocks){
                        $json_stocks=json_decode($stocks->jsondata6);
                        
                        $i=1;
                        foreach($json_stocks as $key=> $stock){
                        ?> 
                        <input type="hidden" id="i<?= $key?>" class="stock-item"  name="stock_id[]" value="<?= $key?>"/>
                        <tr id="tr_<?= $key?>">
                            <td><?= $i;?></td>
                            <td><input type="text" id="<?= $key?>" class="sku-item" data-id="<?= $key?>" name="stock_sku[]" value="<?= $stock->sku?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="color-item" data-id="<?= $key?>" name="stock_color[]" value="<?= $stock->color?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="size-item" data-id="<?= $key?>" name="stock_size[]" value="<?= $stock->size?>"/></td>
                            <td><input type="text" id="<?= $key?>" class="purity-item" data-id="<?= $key?>" name="stock_purity[]" value="<?= $stock->purity?>"/></td>
                            <!--<td><input type="text" id="<?//= $key?>" class="center_diamond-item" data-id="<?//= $key?>" name="stock_center_diamond[]" value="<?//= $stock->center_diamond?>"/></td>-->
                            <td><input type="number" id="<?= $key?>" class="price-item" data-id="<?= $key?>" name="stock_price[]" value="<?= $stock->price?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="mrp-item" data-id="<?= $key?>" name="stock_mrp[]" value="<?= $stock->mrp?>"/></td>
                            <td><input type="number" id="<?= $key?>" class="stock-item1" data-id="<?= $key?>" name="stock_stock[]" value="<?= $stock->stock?>"/></td>
                        </tr>
                        <?php $i++;}}?>
                        </tbody>
                    </table>
                </form>      
    		</div>
		</div>
		
		<div class="card-footer">
                
                <button type="submit" id="save_us" class="btn btn-success"><i class="fa fa-save"></i> SAVE STOCK</button>
            </div>
		
		
	</div>
      <?php }?>

  <?= $this->include('admin/partial/footer') ?>

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>

<?= $this->include('admin/partial/js') ?>

<script>

     var media_max_fields = 10;
    var product_images_list_wrapper__white = $("#white_multi_image_list-wrapper"); //Fields wrapper
    var x = <?php echo count($white_multi_image); ?>;
    var media_max_fields1 = 10;
    var product_images_list_wrapper__yellow = $("#yellow_multi_image_list-wrapper");
    var x1 = <?php echo count($yellow_multi_image); ?>; //initlal text box count
    var media_max_fields2 = 10;
    var product_images_list_wrapper__pink = $("#pink_multi_image_list-wrapper");
    var x2 = <?php echo count($pink_multi_image); ?>;
    function responsive_filemanager_callback(field_id){ 
        if(field_id == 'intro_image'){
            var url=$('#'+field_id).val();
            $("#image-preview").attr('src','<?php echo base_url()?>/media/source/'+url);
            $("#div-preview").removeAttr('style');
        }
        if(field_id == 'pink_image'){
            var url=$('#'+field_id).val();
            $("#image-preview_pink").attr('src','<?php echo base_url()?>/media/source/'+url);
            $("#div-preview_pink").removeAttr('style');
        }
        if(field_id == 'yellow_image'){
            var url=$('#'+field_id).val();
            $("#image-preview_yellow").attr('src','<?php echo base_url()?>/media/source/'+url);
            $("#div-preview_yellow").removeAttr('style');
        }
            
        if(field_id == 'white_multi_image_list'){
           
            if(x < media_max_fields){
                var images = $("#"+field_id).val();
                var is_json = isJson(images);
                var html = '';
                if(is_json){
                    obj = JSON.parse(images);
                    for(var i = 0; i < obj.length; i++){
                        if(x < media_max_fields){
                            x++;
                            var white_multi_image_list_html  = '<div class="white_multi_image_list-container">';
                                white_multi_image_list_html  = '<div class="input-group mb-2">';
                                    white_multi_image_list_html += '<input name="white_multi_image[]" value="'+obj[i]+'" id="white_multi_imageID'+x+'" class="form-control" type="text" placeholder="Image">';
                                    white_multi_image_list_html += '<input name="white_multi_zoom[]" value="'+obj[i]+'" id="white_multi_zoomID'+x+'" class="form-control" type="text" placeholder="Zoom Image">';
                                    white_multi_image_list_html += '<input name="white_disp_order[]" value="'+x+'" id="white_orderID'+x+'" class="form-control" type="number">';
                                    white_multi_image_list_html += '<span class="input-group-btn">';
                                      white_multi_image_list_html += '<a href="#" class="btn btn-danger remove_field"><i class="fas fa-times" aria-hidden="true"></i></a>';
                                    white_multi_image_list_html += '</span>';
                                    white_multi_image_list_html += '<img style="max-height:80px;max-width:80px;" src="#"  id="multi-image_preview'+x+'" class="uploaded_image">';
                                white_multi_image_list_html += '</div>'; 
                            white_multi_image_list_html += '</div>';
                            $(product_images_list_wrapper__white).append(white_multi_image_list_html);
                            
                            $("#multi-image_preview"+x).attr('src','<?php echo base_url()?>/media/source/'+obj[i]);
                        }
                    }
                }
                else{
                    
                    x++;
                    var white_multi_image_list_html  = '<div class="white_multi_image_list-container">';
                        white_multi_image_list_html  = '<div class="input-group mb-2">';
                            white_multi_image_list_html += '<input name="white_multi_image[]" value="'+images+'" id="white_multi_imageID'+x+'" class="form-control" type="text" placeholder="Image">';
                            white_multi_image_list_html += '<input name="white_multi_zoom[]" value="'+images+'" id="white_multi_zoomID'+x+'" class="form-control" type="text" placeholder="Zoom Image">';
                            white_multi_image_list_html += '<input name="white_disp_order[]" value="'+x+'" id="white_orderID'+x+'" class="form-control" type="number">';
                            white_multi_image_list_html += '<span class="input-group-btn">';
                              white_multi_image_list_html += '<a href="#" class="btn btn-danger remove_field"><i class="fas fa-times" aria-hidden="true"></i></a>';
                            white_multi_image_list_html += '</span>';
                            white_multi_image_list_html += '<img style="max-height:80px;max-width:80px;" src="#"  id="multi-image_preview'+x+'" class="uploaded_image">';
                        white_multi_image_list_html += '</div>'; 
                    white_multi_image_list_html += '</div>';
                    $(product_images_list_wrapper__white).append(white_multi_image_list_html);
                   
                    $("#multi-image_preview"+x).attr('src','<?php echo base_url()?>/media/source/'+images);
                }
            }
        }
        if(field_id == 'yellow_multi_image_list'){
            if(x1 < media_max_fields1){
                var images = $("#"+field_id).val();
                var is_json = isJson(images);
                var html = '';
                if(is_json){
                    obj = JSON.parse(images);
                    for(var i = 0; i < obj.length; i++){
                        if(x1 < media_max_fields1){
                            x1++;
                            var yellow_multi_image_list_html1  = '<div class="yellow_multi_image_list-container">';
                                yellow_multi_image_list_html1  = '<div class="input-group mb-2">';
                                    yellow_multi_image_list_html1 += '<input name="yellow_multi_image[]" value="'+obj[i]+'" id="yellow_multi_imageID'+x1+'" class="form-control" type="text">';
                                    yellow_multi_image_list_html1 += '<input name="yellow_disp_order[]" value="'+x+'" id="yellow_orderID'+x+'" class="form-control" type="number">';
                                    yellow_multi_image_list_html1 += '<span class="input-group-btn">';
                                    yellow_multi_image_list_html1 += '<a href="#" class="btn btn-danger remove_field_yellow"><i class="fas fa-times" aria-hidden="true"></i></a>';
                                    yellow_multi_image_list_html1 += '</span>';
                                    yellow_multi_image_list_html1 += '<img style="max-height:80px;max-width:80px;" src="#"  id="multi-image_preview_yellow'+x1+'" class="uploaded_image">';
                                yellow_multi_image_list_html1 += '</div>';
                            yellow_multi_image_list_html1 += '</div>';
                            $(product_images_list_wrapper__yellow).append(yellow_multi_image_list_html1);
                            
                            $("#multi-image_preview_yellow"+x1).attr('src','<?php echo base_url()?>/media/source/'+obj[i]);
                        }
                    }
                }
                else{
                    x1++;
                    var yellow_multi_image_list_html1  = '<div class="yellow_multi_image_list-container">';
                        yellow_multi_image_list_html1  = '<div class="input-group mb-2">';
                            yellow_multi_image_list_html1 += '<input name="yellow_multi_image[]" value="'+images+'" id="yellow_multi_imageID'+x1+'" class="form-control" type="text">';
                            yellow_multi_image_list_html1 += '<input name="yellow_disp_order[]" value="'+x+'" id="yellow_orderID'+x+'" class="form-control" type="number">';
                            yellow_multi_image_list_html1 += '<span class="input-group-btn">';
                            yellow_multi_image_list_html1 += '<a href="#" class="btn btn-danger remove_field_yellow"><i class="fas fa-times" aria-hidden="true"></i></a>';
                            yellow_multi_image_list_html1 += '</span>';
                            yellow_multi_image_list_html1 += '<img style="max-height:80px;max-width:80px;" src="#"  id="multi-image_preview_yellow'+x1+'" class="uploaded_image">';
                        yellow_multi_image_list_html1 += '</div>';
                    yellow_multi_image_list_html1 += '</div>';
                    $(product_images_list_wrapper__yellow).append(yellow_multi_image_list_html1);
                    
                    $("#multi-image_preview_yellow"+x1).attr('src','<?php echo base_url()?>/media/source/'+images);
                }
            }
        }
        if(field_id == 'pink_multi_image_list'){
            if(x2 < media_max_fields2){
                var images = $("#"+field_id).val();
                var is_json = isJson(images);
                var html = '';
                if(is_json){
                    obj = JSON.parse(images);
                    for(var i = 0; i < obj.length; i++){
                        if(x2 < media_max_fields2){
                            x2++;
                            var pink_multi_image_list_html2  = '<div class="pink_multi_image_list-container">';
                                pink_multi_image_list_html2  = '<div class="input-group mb-2">';
                                    pink_multi_image_list_html2 += '<input name="pink_multi_image[]" value="'+obj[i]+'" id="pink_multi_imageID'+x2+'" class="form-control" type="text">';
                                    pink_multi_image_list_html2 += '<input name="pink_disp_order[]" value="'+x+'" id="pink_orderID'+x+'" class="form-control" type="number">';
                                    pink_multi_image_list_html2 += '<span class="input-group-btn">';
                                    pink_multi_image_list_html2 += '<a href="#" class="btn btn-danger remove_field_pink"><i class="fas fa-times" aria-hidden="true"></i></a>';
                                    pink_multi_image_list_html2 += '</span>';
                                    pink_multi_image_list_html2 += '<img style="max-height:80px;max-width:80px;" src="#"  id="multi-image_preview_pink'+x2+'" class="uploaded_image">';
                                pink_multi_image_list_html2 += '</div>';
                            pink_multi_image_list_html2 += '</div>';
                            $(product_images_list_wrapper__pink).append(pink_multi_image_list_html2);
                            
                            $("#multi-image_preview_pink"+x2).attr('src','<?php echo base_url()?>/media/source/'+obj[i]);
                        }
                    }
                }
                else{
                    x2++;
                    var pink_multi_image_list_html2  = '<div class="pink_multi_image_list-container">';
                        pink_multi_image_list_html2  = '<div class="input-group mb-2">';
                            pink_multi_image_list_html2 += '<input name="pink_multi_image[]" value="'+images+'" id="pink_multi_imageID'+x2+'" class="form-control" type="text">';
                            pink_multi_image_list_html2 += '<input name="pink_disp_order[]" value="'+x+'" id="pink_orderID'+x+'" class="form-control" type="number">';
                            pink_multi_image_list_html2 += '<span class="input-group-btn">';
                            pink_multi_image_list_html2 += '<a href="#" class="btn btn-danger remove_field_pink"><i class="fas fa-times" aria-hidden="true"></i></a>';
                            pink_multi_image_list_html2 += '</span>';
                            pink_multi_image_list_html2 += '<img style="max-height:80px;max-width:80px;" src="#"  id="multi-image_preview_pink'+x2+'" class="uploaded_image">';
                        pink_multi_image_list_html2 += '</div>';
                    pink_multi_image_list_html2 += '</div>';
                    $(product_images_list_wrapper__pink).append(pink_multi_image_list_html2);
                    $("#multi-image_preview_pink"+x2).attr('src','<?php echo base_url()?>/media/source/'+images);
                }
            }
        }
    }
    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
    
    $(document).ready( function() {
      $(function() {
    $('#multiproduct').selectize({
      plugins: ['remove_button', 'drag_drop']
  });
});  
      
		$(product_images_list_wrapper__white).on("click",".remove_field", function(e){ //user click on remove text
	        e.preventDefault(); $(this).parent().parent('div').remove(); x--;
	    });


		
        $(product_images_list_wrapper__yellow).on("click",".remove_field_yellow", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent('div').remove(); x1--;
        });

   
        
        $(product_images_list_wrapper__pink).on("click",".remove_field_pink", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent('div').remove(); x2--;
        });
    
        //Validation
        $('.formvalidate').validate({
        rules: {
            title: {
                required: true,
            },
            style_no: {
                required: true,
            }
        },
        messages: {
            title: {
                required: "Please enter a Title",
            },
            style_no: {
                required: "Please enter a Style No",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
  
    //TOAST
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });  
    
    // Update Stock
    $(document).on("click","#save_india",function(){
        
        $("#stock-save-india1").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-india2").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-india3").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-india4").each(function(){
            var fd = new FormData(this);
            var obj="";
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-india5").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-india6").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                 obj =  JSON.parse(response);
                /*if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        
        setTimeout(function(){
            Toast.fire({
                icon: 'success',
                title: obj.message
            }).then(function() {
                window.location = "<?php echo base_url().'/admin/products_set/edit/'?>"+obj.product_id;
            });
        },1000); 
          
    })   
    
        
    $(document).on("click","#save_us",function(){
        
        $("#stock-save-us1").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-us2").each(function(){
            var obj="";
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-us3").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-us4").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-us5").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        $("#stock-save-us6").each(function(){
            var fd = new FormData(this);
            $.ajax({
            url:'<?php echo base_url().'/admin/products_set/updatestock'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                obj =  JSON.parse(response);
                /*if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                }*/
            }
        })
        });
        
        setTimeout(function(){
            Toast.fire({
                icon: 'success',
                title: obj.message
            }).then(function() {
                window.location = "<?php echo base_url().'/admin/products_set/edit/'?>"+obj.product_id;
            });
        },1000); 
          
    })   
    
    $(document).on("click","#withsize",function(){
        
        var pid='<?= @$record->id ?>';
        var product_sku='<?//= @$record->product_sku ?>';
        var product_price='<?= @$record->product_price ?>';
        var product_final_price='<?= @$record->product_final_price ?>';
        var purity='<?//= @$record->purity ?>';
        
        $.ajax({
            url:'<?php echo base_url().'/admin/products_set/addstock'?>',
            method:"POST",
            data:{id:1,product_sku:product_sku,product_price:product_price,product_final_price:product_final_price,purity:purity,pid:pid},
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            window.location = "<?php echo base_url().'/admin/products_set/edit/'?>"+obj.product_id;
                        });
                    },1000); 
                }else{
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'danger',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php //echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                    $("#mab1").hide();
                }
            }
        })
           
    })
    
    $(document).on("click","#withoutsize",function(){
        
        var pid='<?= @$record->id ?>';
        var product_sku='<?//= @$record->product_sku ?>';
        var product_price='<?= @$record->product_price ?>';
        var product_final_price='<?= @$record->product_final_price ?>';
        var purity='<?//= @$record->purity ?>';
        
        $.ajax({
            url:'<?php echo base_url().'/admin/products_set/addstock'?>',
            method:"POST",
            data:{id:2,product_sku:product_sku,product_price:product_price,product_final_price:product_final_price,purity:purity,pid:pid},
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            window.location = "<?php echo base_url().'/admin/products_set/edit/'?>"+obj.product_id;
                        });
                    },1000); 
                }else{
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'danger',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php //echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                    $("#mab1").hide();
                }
            }
        })
           
    })
    
    //Delete
    $(document).on("click","#deletestock",function(){
       
        var pid='<?= @$record->id ?>';
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:'<?php echo base_url().'/admin/products_set/deletestock'?>',
                    method:"POST",
                    data:{pid:pid},
                    beforeSend: function(){
                        $("#mab1").show();          
                    },
                    success(response){
                        var obj =  JSON.parse(response);
                        if(obj.status=="1"){
                            setTimeout(function(){
                                Toast.fire({
                                    icon: 'success',
                                    title: obj.message
                                }).then(function() {
                                    window.location = "<?php echo base_url().'/admin/products_set/edit/'?>"+obj.product_id;
                                });
                            },1000); 
                        }
                    }
                })
            } else {
                swal("Your record is safe!");
            }
        });
    })  
    
    //Delete
    $(document).on("click",".dlt-item",function(){
        var id = $(this).attr('data-id');
        var pid = $(this).attr('data-pid');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:'<?php echo base_url().'admin/product_details/delete'?>',
                    method:"POST",
                    data:{id:id,pid:pid},
                    beforeSend: function(){
                        $("#mab1").show();          
                    },
                    success(response){
                        var obj =  JSON.parse(response);
                        if(obj.status=="1"){
                            setTimeout(function(){
                                Toast.fire({
                                    icon: 'success',
                                    title: obj.message
                                }).then(function() {
                                    window.location = "<?php echo base_url().'admin/products_set/view/'?>"+obj.data;
                                });
                            },1000); 
                        }
                    }
                })
            } else {
                swal("Your record is safe!");
            }
        });
    })  
    
    function check(str) {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });  
        $.ajax({
            url:'<?php echo base_url().'/admin/products_set/check'?>',
            method:"POST",
            data:{id:str},
            beforeSend: function(){
                $("#mab1").show();          
            },
            success(response){
                 obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                           window.location = "<?php echo base_url().'/admin/products_set/edit/'?>"+obj.product_id;
                        });
                    },1000); 
                        //toastr.success('Sent successfully.'); 
                }
            }
        });
        
    }
    
    //Form Submit 
    $(document).on("submit","#save-form",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url('admin/products_set/add') ?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("#mab1").show();     
            },
            success(response){
                var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            $("#mab1").show();
                            Toast.fire({
                            icon: 'success',
                            title: "Organizing Category please wait..."
                        }).then(function() {
                             check(obj.product_id);
                        });
                        });
                    },1000); 
                    $("#mab1").hide();
                        //toastr.success('Sent successfully.'); 
                }
                else if(obj.status=="2"){
                    $("#product-id").val(obj.product_id);
                    $("#ajaxpdetails").show();
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'success',
                            title: obj.message
                        }).then(function() {
                            $("#mab1").show();
                            Toast.fire({
                            icon: 'success',
                            title: "Organizing Category please wait..."
                        }).then(function() {
                             check(obj.product_id);
                        });
                        });
                    },1000); 
                    $("#mab1").hide();
                }else {
                    setTimeout(function(){
                        Toast.fire({
                            icon: 'danger',
                            title: obj.message
                        }).then(function() {
                            //window.location = "<?php echo base_url().'admin/products_set/view1/'?>"+obj.product_id;
                        });
                    },1000); 
                    $("#mab1").hide();
                }
            }
        })
    }); 

    $(document).on("submit","#frm-add-product",function(e){
        e.preventDefault();
        var product_id = $("#product-id").val();
        var form = $(this);
        if(product_id == '' || product_id == 0){
            swal({
              title: "",
              text: "Please add product details.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            });
            return false;
        }
        var formData = new FormData(this);
        formData.append('pid', product_id);
        $.ajax({
            url:'<?php echo base_url('admin/products_set/add_product_detail') ?>',
            method:"POST",
            data:formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();     
            },
            success(response){
                var obj =  JSON.parse(response);
                if(obj.status=="1"){
                    $(form).find("#product_detail_id").val(obj.product_detail_id);
                    setTimeout(function(){
                  Toast.fire({
                    icon: 'success',
                    title: obj.message
                  }).then(function() {
                    
                });
       
            },1000); 
                $("#mab1").hide();
                    //toastr.success('Sent successfully.'); 
                }
                else if(obj.status=="2"){
                    $(form).find("#product_detail_id").val(obj.product_detail_id);
                    $(form).closest("#pdetails").find(".product_detail_div").show();
                    setTimeout(function(){
                  Toast.fire({
                    icon: 'success',
                    title: obj.message
                  }).then(function() {
                    // window.location = "<?php echo base_url().'admin/products_set/view/'?>"+obj.data;
                });
       
            },1000); 
                $("#mab1").hide();
                    //toastr.success('Sent successfully.'); 
                }else {
                    setTimeout(function(){
                  Toast.fire({
                    icon: 'danger',
                    title: obj.message
                  }).then(function() {
                    //window.location = "<?php //echo base_url().'admin/category'?>";
                });
       
            },1000); 
                $("#mab1").hide();
                }
            }
        })
    });
   }); 

</script> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.css" />

</body>
</html>                
