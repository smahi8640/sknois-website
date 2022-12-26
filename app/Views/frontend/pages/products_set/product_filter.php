<div id="ajax-post-container" class="row">
  <?php
  $this->db = \Config\Database::connect();
  //print_r($products);
  if(!empty($products)) { ?>
    <?php foreach($products AS $record) { 
    ?>  
    <div class="col-lg-3">
        <div class="product__item">
            <div class="product__head">
                <div class="product__img">
                    <a href="<?php echo BASE?>products_set/<?php echo $record['alias'].'-'.$record['style_no']; ?>">
						<?php 
						    $img = base_url('media/source/').'/'.$record['intro_image'];
						?>
                        <img src="<?php echo $img; ?>" alt="">
                    </a>
                </div>
            </div>
            <div class="product__content justify-content-center align-items-center">
                <div class="product__name ">
                    <h4 class="name"><a href="<?php echo BASE.'products_set/'.$record['alias'].'-'.$record['style_no']; ?>"><?php echo $record['title']; ?></a></h4>
                    <h4><?php echo $record['product_short_description']; ?></h4>
                </div>
                <div class="price d-flex justify-content-center align-items-center" style="display:none !important;">
                    <?php
                        if($record['product_price']=="0" || $record['product_price']==$record['product_final_price']){?>
                        <h4>$ <?php echo $record['product_final_price']; ?></h4> 
                    <?php }else{?> 
                        <h4>$ <?php echo $record['product_final_price']; ?> 
                        <span class="offer">$ <?php echo $record['product_price']; ?></span>
                        </h4>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    
    <?php }?>
    </div>
 
    <?php } 
    else{ ?>
            <div class="col-md-12 text-center alert alert-info">No related products.</div>
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