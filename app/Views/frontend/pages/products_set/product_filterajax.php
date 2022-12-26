<?php if(!empty($records)) { ?>
    <?php foreach($records AS $record) { 
        $product_details=$this->db->query("SELECT mrp,final_price,size,id,description,item_no,sku FROM product_details WHERE final_price = ( SELECT final_price FROM product_details where product_id='".$record->id."' order by stock desc,final_price asc limit 1) and product_id='".$record->id."'")->row();
         
     if(file_exists(FCPATH."media/source/".$record->intro_image)) { 
    ?>  
    <div class="col-lg-3">
        <div class="product__item">
            <div class="product__head">
                <div class="product__img">
                    <a href="<?php echo base_url('')?>jewellery/products/<?php echo $record->alias.'-'.$product_details->sku; ?>">
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
                         <a href="<?php echo base_url('')?>jewellery/products/<?php echo $record->alias.'-'.$product_details->sku; ?>">
                             <img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>img/visibility.svg" alt="Shopping Cart">
                        </a>
                    </div>
                    <div class="product__btn">
                        <a class="add_to_wishlist" href="#" data-id="<?php echo $product_details->id; ?>" id="addtowishlist-form">
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
                    <h4 class="name"><a href="<?php echo base_url('jewellery/products/'.$record->alias.'-'.$product_details->sku); ?>"><?php echo $record->title; ?></a></h4>
                    <h4><?php echo $product_details->description; ?></h4>
                    <div class="price d-flex justify-content-center align-items-center">
                         <?php 
    						if($product_details->mrp=="0" || $product_details->mrp==$product_details->final_price){?>
                            <h4>₹ <?php echo $product_details->final_price; ?></h4> 
                        <?php }else{?> 
                            <h4>? <?php echo $product_details->final_price; ?> 
                            <span class="offer">₹ <?php echo $product_details->mrp; ?></span>
                            </h4>
                        <?php }?>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php }} ?>
    <?php } 
    else{ ?>
            <!-- <div class="col-md-12 text-center alert alert-info">No related products.</div> -->
    <?php }?>
   
   <script>
$(document).ready( function() {
    $(document).on("click","#addtowishlist-form",function(){
			var product_id = $(this).data("id");
			//alert(product_id);
			$.ajax({
				url: '<?php echo base_url('addwishlistproduct'); ?>',
				method: "POST",
				data: { product_id:product_id},
	    		dataType: 'json',
			})
			.done(function( response ) {
				$('.main__header .cart__icon .whistlist .cart__count').html(response.wishlist_count);
				swal({
					title: "Message!",
					text: response.message,
					type: response.message_type
				});
			});
		});
});
</script>