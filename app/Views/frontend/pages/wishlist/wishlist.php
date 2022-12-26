

<?php $user = $this->ion_auth->user()->row();?>
        <section class="shopping__cart--block">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-12">
                        <?php if($this->session->flashdata('message')) { ?>
            			<div class="message-area-wrapper">
            				<div class="alert alert-<?php echo $this->session->flashdata('message_type'); ?> alert-dismissible fade show mb-0">
            					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            					<?php 
            						$message_title = 'Notice';
            						if($this->session->flashdata('message_type') == 'success') { 
            							$message_title = 'Message';
            						} elseif ($this->session->flashdata('message_type') == 'danger') {
            							$message_title = 'Error';
            						} elseif ($this->session->flashdata('message_type') == 'warning') {
            							$message_title = 'Warning';
            						}
            					?>
            					<h5 class="alert-heading text-capitalize"><?php echo $message_title; ?></h5>
            					<?php echo $this->session->flashdata('message');?>
            				</div>
            			</div>
            			<?php } ?>
                    </div>
                    
                    <div class="col-lg-8 offset-2">
                        <div class="shopping__cart__list">
                            
                            
                    <?php 
                    $items = $this->wishlist->contents();
                    
						//$cart_details = $this->cart->contents();
						//echo "<pre>"; print_r($cart_details); exit;
						if($wishlist_details){
                        foreach($wishlist_details as $wish){
                            
                            
                        $datas=json_decode($wish['attributes']);
                        $product_details=$this->db->query("select * from product_details where id='".$datas->product_size."'")->row();
                        $product_id[] = $datas->product_size;
                        //$product_gold=$this->db->query("select * from product_gold where id='".$datas->product_gold."'")->row();
                        //$product_diamond=$this->db->query("select * from product_diamond where id='".$datas->product_diamond."'")->row();
                        $alias=$this->db->query("select * from products where id='".$wish['product_id']."'")->row();
                        ?>
                            <div class="shopping__cart__item">
                                <div class="product__img">
									<?php 
										if(file_exists(FCPATH."media/source/".$wish['image'])) { 
											$img = base_url('media/source/').$wish['image'];
										} else { 
											$img = base_url('media/source/joyari-logo.png');
										}
									?>
                                    <a href="#"><img src="<?php echo $img; ?>" alt="Product"></a>
                                </div>
                                <div class="product__des">
                                    <div class="title__header">
                                        <h4 class="product__name"><a href="<?php echo base_url('')?>jewellery/products/<?php echo $alias->alias.'-'.$product_details->sku; ?>"><?php echo $wish['title']; ?></a></h4>
                                        <p class="cart__sku"><?php echo $product_details->sku;?></p>
                                        <div class="cart__update__options d-flex align-items-center">
                                            <?php if($product_details->size!="0"){?>
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
                                            
                                        </div>
                                        <!--<p class="cart__inventory"> Last <?php echo $product_details->stock;?> pieces left! </p>-->
                                    </div>
                                    <div class="details__footer">
                                        <h5 class="product__price">₹<?php echo $wish['price']; ?>
                                        <?php if($wish['mrp']=="0" || $wish['mrp']==$wish['price']){ }else{?>
                                        <span class="offer__line">₹<?php echo $wish['mrp']; ?></span>
                                        <span class="discountprice">Save ₹<?php echo $wish['mrp']-$wish['price']; ?></span>
                                        <?php }?>
                                        </h5>
                                    </div>
                                </div>
                                <div class="product__actions">
                                    <div class="product__actions__list">
                                        <a href="<?php echo base_url('addtocart/'.$wish['cart_row_id']); ?>" class="btn__outline btn__move">Move to Cart</a>
                                        <a href="<?php echo base_url('removewishlist/'.$wish['cart_row_id']); ?>" class="btn__outline btn__remove">Remove from Wishlist</a>
                                    </div>
                                </div>
                            </div>
                        <?php }}else{?>    
                            <div class="shopping__cms text-center">
                                <div class="shopping__cms__img">
                                    <img src="<?php echo base_url('assets/frontend/img/') ?>empty-wishlist.svg" alt="Image">
                                </div>
                                <div class="shopping__cms__content">
                                    <h3>Your wishlist is empty</h3>
                                    <p>Looks like you heaven't made your choice yet...</p>
                                    <a href="<?php echo base_url('jewellery/products/all'); ?>" class="btn cms__btn effect__btn">Shop now</a>
                                </div>
                            </div>
                            <!--<div class="alert alert-info">No Products in Wishlist.</div>-->
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
<script>
   
</script>