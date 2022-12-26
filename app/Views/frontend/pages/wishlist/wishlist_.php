
        <section class="shopping__cart--block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-2">
                        <div class="shopping__cart__list">
                            
                            
                    <?php 
						$wishlist_details = $this->wishlist->contents();
						//echo "<pre>"; print_r($wishlist_details); exit;
                        foreach($wishlist_details as $wishlist){
                            //$datas=json_decode($wishlist['options']);
							$datas=$wishlist['options'];
                        	$product_details=$this->db->query("select * from product_details where id='".$datas->product_size."'")->row();
                        ?>
                            <div class="shopping__cart__item">
                                <div class="product__img">
									<?php 
										if(file_exists(FCPATH."media/source/".$wishlist['img'])) { 
											$img = base_url('media/source/').$wishlist['img'];
										} else { 
											$img = base_url('media/source/joyari-logo.png');
										}
									?>
                                    <a href="#"><img src="<?php echo $img; ?>" alt="Product"></a>
                                </div>
                                <div class="product__des">
                                    <div class="title__header">
                                        <h4 class="product__name"><?php echo $wishlist['name']; ?></h4>
                                        <p class="cart__sku"><?php echo $product_details->sku;?></p>
                                        <div class="cart__update__options d-flex align-items-center">
                                            <?php print_r($product_details);if($product_details->size!="0"){?>
                                            <div class="product__size">
                                                <label for="">Size : <?php echo $product_details->size;?> </label>
                                                <!--<select class="product__size__option">
                                                    <option selected><?php echo $product_details->size;?></option>
                                                    <option value="1">15</option>
                                                    <option value="2">16</option>
                                                    <option value="3">17</option>
                                                </select>-->
												
                                            </div>
                                            <?php }?>
                                            <div class="product__size">
                                                <label for="">Quantity : <?php echo $wishlist['qty']; ?></label>
                                                <!--<select class="product__size__option">
                                                    <option selected>1</option>
                                                    <option value="1">2</option>
                                                    <option value="2">3</option>
                                                    <option value="3">4</option>
                                                </select>-->
                                            </div>
                                        </div>
                                        <!--<p class="cart__inventory"> Last <?php echo $product_details->stock;?> pieces left! </p>-->
                                    </div>
                                    <div class="details__footer">
                                        <p class="delivery__details">Expected Delivery - </p>
                                        <h5 class="product__price">₹<?php echo $wishlist['price']; ?>
                                        <?php if($wishlist['mrp']=="0" || $wishlist['mrp']==$wishlist['price']){ }else{?>
                                        <span class="offer__line">₹<?php echo $wishlist['mrp']; ?></span>
                                        <span class="discountprice">Save ₹<?php echo $wishlist['mrp']-$wishlist['price']; ?></span>
                                        <?php }?>
                                        </h5>
                                    </div>
                                </div>
                                <div class="product__actions">
                                    <div class="product__actions__list">
                                        <a href="<?php echo base_url('addtocart/'.$wishlist['cart_row_id']); ?>" class="btn__outline btn__move">Move to Cart</a>
                                        <a href="<?php echo base_url('removewishlist/'.$wishlist['rowid']); ?>" class="btn__outline btn__remove">Remove from Wishlist</a>
                                    </div>
                                </div>
                            </div>
                        <?php }?>    
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
<script>
   
</script>