
  <?php if(!empty($records)) { ?>
    <?php foreach($records AS $record) { 
     if(file_exists(FCPATH."media/source/".$record->intro_image)) { 
     ?>  
    <div class="col-lg-3">
        <div class="product__item">
            <div class="product__head">
                <div class="product__img">
                    <a href="<?php echo base_url('')?>products/<?php echo $record->alias; ?>">
						<?php 
							if(file_exists(FCPATH."media/source/".$record->intro_image)) { 
								$img = base_url('media/source/').$record->intro_image;
							} else { 
								$img = base_url('media/source/joyari-logo.png');
							}
						?>
                        <img src="<?php echo $img; ?>" alt="">
                    </a>
                </div>
              
                <div class="product__btns d-flex align-items-center justify-content-center">
                    <!--<div class="product__btn">
                        <a href="#">
                            <img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>img/search.svg" alt="View">
                        </a>
                    </div>-->
                    <div class="product__btn">
                         <a href="<?php echo base_url('')?>products/<?php echo $record->alias; ?>">
                             <img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>img/visibility.svg" alt="Shopping Cart">
                        </a>
                    </div>
                    <div class="product__btn">
                        <a href="<?php echo site_url('addwishlistproduct/'.$record->id); ?>">
                            <img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>img/whishlist.svg" alt="Whishlist">
                        </a>
                    </div>
                </div>
            </div>
            <div class="product__content d-flex">
              <?php 
                    if($record->video!=""){?>  
                <div class="product__video">
                        <button type="button" data-toggle="modal" data-target="#product__video<?php echo $record->id; ?>">
                            <img src="<?php echo base_url('assets/frontend/'); ?>img/play.svg" class="in__svg" alt="Play Video">
                        </button>
                    </div>
                <?php }?>    
                <div class="product__name">
                    <h4 class="name"><a href="<?php echo base_url('products/'.$record->alias); ?>"><?php echo $record->title; ?></a></h4>
                    <h4><?php echo $record->product_short_description; ?></h4>
                </div>
                <div class="price d-flex justify-content-center align-items-center">
                     <?php 
						$product_details=$this->db->query("select  MIN(final_price),mrp,final_price from product_details where product_id='".$record->id."' limit 1")->row();
						if($record->mrp=="0" || $record->mrp==$record->final_price){?>
                        <h4>? <?php echo $record->final_price; ?></h4> 
                    <?php }else{?> 
                        <h4>? <?php echo $record->final_price; ?> 
                        <span class="offer">? <?php echo $record->mrp; ?></span>
                        </h4>
                    <?php }?>
                   
                </div>
            </div>
        </div>
    </div>
    
    <?php }} ?>
    <?php } 
    else{ ?>
            <div class="col-md-12 text-center alert alert-info">No related products.</div>
    <?php }?>
   