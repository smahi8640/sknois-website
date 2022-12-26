<?php

/**
 *
 * @package     INDRA.Admin
 * @subpackage  INDRA
 * @version 	1.0.0
 * @since 		2019
 *
 * @copyright   Copyright (C) 2019 INDRA. All rights reserved.
 * @author 		GopiKumar Patel
 * @link 		gopipatel.ce@gmail.com
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="single_product">
    <div class="container">
        <div class="row">

            <div class="products_image col-lg-5 col-md-5 mb-4 ftco-animate">
                <div class="image_selected">
                    <a href="<?php echo site_url('media/source/'.$record->intro_image); ?>" class="image-popup">
                        <img src="<?php echo site_url('media/source/'.$record->intro_image); ?>" alt="The Boarding Pass" class="img-fluid">
                    </a>

                </div>
                <div class="small_image">
                    <ul class="small_slider image_list owl-carousel">
                        <li data-image="<?php echo site_url('media/source/'.$record->intro_image); ?>">
                            <img src="<?php echo site_url('media/source/'.$record->intro_image); ?>" alt="">
                        </li>
                        <?php
                        $query = $this->db->where('product_id',$record->id)->get('products_images');

                        $data= $query->result();
                        foreach ($data as $datas) {?>
                            <li data-image="<?php echo site_url('media/source/'.$datas->image); ?>">
                                <img src="<?php echo site_url('media/source/'.$datas->image); ?>" alt="">
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="products_nav_container">
                        <div class="products_nav small_prev"><i class="fas fa-chevron-left"></i></div>
                        <div class="products_nav small_next"><i class="fas fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>

            <!--<div class="col-lg-5 col-md-5 mb-4 ftco-animate">
    			    <div class="main-slider">
                        <div id="slider" class="flexslider">
                            <ul class="slides">
                                  <li>
                                    <a href="<?php echo site_url('media/source/'.$record->intro_image); ?>" class="image-popup">
                                      <img src="<?php echo site_url('media/source/'.$record->intro_image); ?>" alt="The Boarding Pass" class="img-fluid">
                                    </a>
                                  </li>
                                  <?php
            $query = $this->db->where('product_id',$record->id)->get('products_images');

            $data= $query->result();
            foreach ($data as $datas) {?>
                                  <li>
                                    <a href="<?php echo site_url('media/source/'.$datas->image); ?>" class="image-popup">
                                      <img src="<?php echo site_url('media/source/'.$datas->image); ?>" alt="The Boarding Pass" class="img-fluid">
                                    </a>
                                  </li>

                                  <?php } ?>
                            </ul>
                        </div>
                      <div id="carousel" class="flexslider">
                          <ul class="slides">
                              <li><img src="<?php echo site_url('media/source/'.$record->intro_image); ?>" alt=""></li>
                             <?php
            $query = $this->db->where('product_id',$record->id)->get('products_images');

            $data= $query->result();
            foreach ($data as $datas) {?>
                              <li><img src="<?php echo site_url('media/source/'.$datas->image); ?>" alt=""></li>
                              <?php } ?>
                          </ul>
                          <div class="custom-navigation">
                              <a href="#" class="flex-prev"><i class="fa fa-angle-left"></i></a>
                              <a href="#" class="flex-next"><i class="fa fa-angle-right"></i></a>
                          </div>
                      </div>
                    </div>

    			</div>-->
            <div class="col-lg-7 col-md-7 product-details pl-md-5 ftco-animate">
                <h3><?php echo $record->title; ?></h3>
                <p class="price"><span>Rs.
    				<?php if($record->product_price=="0" || $record->product_price==$record->product_final_price){?>
                        <?php echo $record->product_final_price; ?></span>
                    <?php } else{?>
                        <?php echo $record->product_final_price; ?></span><span class="mr-2 price-dc">RS.<?php echo $record->product_price; ?></span>
                    <?php	}?>
                <p><?php echo $record->description; ?></p>

                <form method="post" action="<?php echo base_url();?>products/addtocart/<?php echo $record->alias; ?>">

                    <?php if($record->attribute_ids != '') { ?>
                        <?php $attributes = explode(',', $record->attribute_ids); ?>
                        <?php $attribute_values = json_decode($record->attribute_values); ?>
                        <?php // echo "<pre>"; print_r($attributes); echo "</pre>"; ?>

                        <?php foreach ($attributes AS $attribute) { ?>
                            <?php if($attribute != '') { ?>
                                <?php $attribute_details = $this->attributes_model->recordlist($attribute); ?>
                                <?php $attribute_options = $attribute_values->{$attribute} ?>
                                <?php // echo "<pre>"; print_r($attribute_details); echo "</pre>"; ?>
                                <div class="product-variants">
                                    <span class="control-label"><?php echo $attribute_details[0]->title; ?> : </span>
                                    <?php if($attribute_details[0]->title=="Size"){?>
                                        <span class="size_guide"><a href="#">Size Guide</a></span>
                                    <?php } ?>
                                    <!--  <?php // $attribute_options = explode(',', $attribute_details[0]->options); ?>
                                            <select name="attribute[<?php echo $attribute_details[0]->title; ?>]" class="form-control">
                                                <?php foreach ($attribute_options AS $attribute_option) { ?>
                                                <option value="<?php echo $attribute_option; ?>"><?php echo $attribute_option; ?></option>
                                                <?php } ?>
                                            </select>-->
                                    <ul class="size_list">
                                        <?php $i = 0; foreach ($attribute_options AS $attribute_option) { ?>
                                            <li>
                                                <input class="input-radio"  type="radio" value="<?php echo $attribute_option; ?>" name="attribute[<?php echo $attribute_details[0]->title; ?>]" <?php if($i == 0) { ?> checked="checked" <?php } ?> />
                                                <span class="radio-label"><?php echo $attribute_option; ?></span>
                                            </li>
                                            <?php $i++; } ?>

                                    </ul>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <!--<div class="product-variants">
                            <span class="control-label">Gender:</span>
                            <div class="gender">
                                <label class="selected"><input type="radio" class="input_color" name="optradio" checked="checked">Male</label>
                                <label><input type="radio" class="input_color" name="optradio">Female</label>
                            </div>
                        </div>
                        <div class="product-variants">
                            <div class="form-group d-flex">
                                <span class="control-label">Color:</span>
                                <div class="color_list">
                                    <label><input type="radio" class="input_color" name="optradio" checked="checked">
                                        <span class="color" style="background-color: #ffffff"><span class="sr-only">White</span></span>
                                    </label>
                                </div>
                                <div class="color_list">
                                    <label><input type="radio" class="input_color" name="optradio">
                                        <span class="color" style="background-color: #000000"><span class="sr-only">Black</span></span>
                                    </label>
                                </div>
                                <div class="color_list">
                                    <label><input type="radio" class="input_color" name="optradio">
                                        <span class="color" style="background-color: #ff0000"><span class="sr-only">Red</span></span>
                                    </label>
                                </div>
                                <div class="color_list">
                                    <label><input type="radio" class="input_color" name="optradio">
                                        <span class="color" style="background-color: #ffff00"><span class="sr-only">Yellow</span></span>
                                    </label>
                                </div>
                            </div>
                        </div>-->
                    <?php } else { ?>
                        <input type="hidden" name="attribute" value=""/>
                    <?php } ?>

                    <input type="hidden" name="id" value="<?php echo $record->id;?>"/>
                    <input type="hidden" name="img" value="<?php echo $record->intro_image;?>"/>
                    <input type="hidden" name="name" value="<?php echo $record->title;?>"/>
                    <input type="hidden" name="price" value="<?php echo $record->product_final_price;?>"/>
                    <input type="hidden" name="mrp" value="<?php echo $record->product_price;?>"/>

                    <div class="product-variants">
                        <span class="control-label">Quantity:</span>
                        <div class="qty">
                            <div class="input-group">
                                <input type="text" id="quantity" name="qty" class="qty form-control input-number" value="1" min="1" max="100">
                                <span class="plus_minus input-group-btn-vertical mr-2">
                                    <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                        <i class="ion-ios-add"></i>
                                    </button>
                                    <button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
                                        <i class="ion-ios-remove"></i>
                                    </button>
                                  </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-variants">
                        <div class="add_cart">
                            <button type="button" id="add-to-cart" class="btn btn-primary add-to-cart">Add to Cart</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>


<section class="related_products">
    <div class="container">
        <div class="row justify-content-center pt-3 mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate fadeInUp ftco-animated">
                <h2>Related Products</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if($record->related_product_ids != '') { ?>
                    <?php $related_products = explode(',', $record->related_product_ids); ?>
                    <div class="related_slider owl-carousel ftco-animate">
                        <?php foreach ($related_products AS $related_product) { ?>
                            <?php
                            $related_product_record = $this->products_model->recordlist($related_product);
                            $category_ids = explode(',', $related_product_record[0]->category_ids);
                            $category_record = $this->categories_model->recordlist($category_ids[0]);
                            ?>
                            <form method="post" id="form-addtocart-<?php echo $related_product_record[0]->id; ?>" action="<?php echo base_url();?>products/addtocart/1">
                                <input type="hidden" name="id" value="<?php echo $related_product_record[0]->id;?>"/>
                                <input type="hidden" name="img" value="<?php echo $related_product_record[0]->intro_image;?>"/>
                                <input type="hidden" name="name" value="<?php echo $related_product_record[0]->title;?>"/>
                                <input type="hidden" name="price" value="<?php echo $related_product_record[0]->product_final_price;?>"/>
                                <input type="hidden" name="mrp" value="<?php echo $related_product_record[0]->product_price;?>"/>
                                <input type="hidden" name="qty" value="1"/>

                                <div class="related_product ftco-animate">
                                    <div class="product">
                                        <a href="<?php echo base_url('products/'.$related_product_record[0]->alias); ?>" class="img-prod">
                                            <img class="img-fluid" src="<?php echo base_url('media/source/').$related_product_record[0]->intro_image; ?>" alt="<?php echo $related_product_record[0]->title; ?>">
                                        </a>
                                        <div class="text">
                                            <h3 class="product_name"><a href="<?php echo base_url('products/'.$related_product_record[0]->alias); ?>"><?php echo $related_product_record[0]->title; ?></a></h3>
                                            <div class="description clearfix">
                                                <div class="category">
                                                    <p><?php echo $category_record[0]->title; ?></p>
                                                </div>
                                                <div class="pricing">
                                                    <p class="price"><span>Rs.<?php echo $related_product_record[0]->product_final_price; ?></span></p>
                                                </div>
                                            </div>
                                            <!--<p class="bottom-area ">
                                              <?php if($related_product_record[0]->attribute_ids == '') { ?>
                                                  <button class="rel-add-to-cart btn btn-link" data-formid="form-addtocart-<?php echo $related_product_record[0]->id; ?>" id="<?php echo 'add-to-cart-'.$related_product_record[0]->id; ?>" type="button"><span>Add to Cart<i class="ion-ios-add ml-1"></i></button>
                                              <?php } else { ?>
                                                  <a href="<?php echo base_url('')?>products/productssingle/<?php echo $related_product_record[0]->alias; ?>" class="add-to-cart"><span>View Details <i class="ion-ios-eye ml-1"></i></span></a>
                                              <?php } ?>
                                          </p>-->
                                        </div>
                                    </div>
                                </div>

                            </form>

                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="col-md-12 text-center alert alert-info">
                        No related products.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    jQuery(document).ready( function () {


        jQuery('.rel-add-to-cart').click( function() {

            var formId = jQuery(this).attr('data-formid');

            var quantity = 1;

            var attribute = {};
            var id = jQuery('#'+formId+' input[name="id"]').val();
            var img = jQuery('#'+formId+' input[name="img"]').val();
            var name = jQuery('#'+formId+' input[name="name"]').val();
            var price = jQuery('#'+formId+' input[name="price"]').val();
            var mrp = jQuery('#'+formId+' input[name="mrp"]').val();

            jQuery.ajax({
                url: '<?php echo base_url('addtocartAjax'); ?>',
                type: 'POST',
                /*data: {
                    id : '<?php echo $products->id;?>',
                            img : '<?php echo $products->intro_image;?>',
                            name : '<?php echo $products->title;?>',
                            price : '<?php echo $products->product_final_price;?>',
                            mrp : '<?php echo $products->product_price;?>',
                            qty : quantity,
                            attribute : attribute
                        },*/
                data: {
                    id : id,
                    img : img,
                    name : name,
                    price : price,
                    mrp : mrp,
                    qty : quantity,
                    attribute : attribute
                },
                dataType: 'json'
            }).done(function( response ) {
                if (response){
                    if(response.status == 200){
                        var cart_count = response.cart_count;
                        jQuery('.cart_acc .s_cart .cart_count').text(cart_count);
                        myFunction();
                    } else {
                        //error handler
                        //myFunction();
                        alert(response.msg);
                    }
                } else {
                    alert('Please try again.');
                }
            });

        });

    });

</script>

<script type="text/javascript">

    jQuery(document).ready( function () {


        jQuery('#add-to-cart').click( function() {

            var quantity = jQuery('#quantity').val();

            var attribute = {};
            <?php if($record->attribute_ids != '') { ?>
            <?php foreach ($attributes AS $attribute) { ?>
            <?php $attribute_details = $this->attributes_model->recordlist($attribute); ?>
            var radioValue = jQuery("input[name=\"attribute[<?php echo $attribute_details[0]->title; ?>]\"]:checked").val();
            attribute['<?php echo $attribute_details[0]->title; ?>'] = radioValue;
            <?php } ?>
            <?php } ?>

            console.log(attribute);

            jQuery.ajax({
                url: '<?php echo base_url('addtocartAjax'); ?>',
                type: 'POST',
                data: {
                    id : '<?php echo $record->id;?>',
                    img : '<?php echo $record->intro_image;?>',
                    name : '<?php echo $record->title;?>',
                    price : '<?php echo $record->product_final_price;?>',
                    mrp : '<?php echo $record->product_price;?>',
                    qty : quantity,
                    attribute : attribute
                },
                dataType: 'json'
            }).done(function( response ) {
                if (response){
                    if(response.status == 200){
                        var cart_count = response.cart_count;
                        jQuery('.cart_acc .s_cart .cart_count').text(cart_count);
                        jQuery('.product-variants input[type="radio"]').prop('checked', false);
                        jQuery('.product-variants ul li:first-child input[type="radio"]').prop('checked', true);
                        myFunction();
                    } else {
                        //error handler
                        //myFunction();
                        alert(response.msg);
                    }
                } else {
                    alert('Please try again.');
                }
            });

        });

    });


    function myFunction() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>
<div id="snackbar">Product added in cart successfully.</div>

<!-- Modal -->
<!--<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-sm-center" id="exampleModalLabel">
              <i class="fa fa-check" aria-hidden="true"></i>  Product successfully added to your shopping cart
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 divide-right">
                <div class="row">
                  <div class="col-md-6">
                    <img class="product-image" src="<?php echo base_url('assets/')?>images/crop-top.jpg" alt="Drink and I Know Things T Shirt" title="Drink and I Know Things T Shirt" itemprop="image">
                  </div>
                  <div class="col-md-6">
                    <h6 class="h6 product-name">Drink and I Know Things T Shirt</h6>
                    <p class="price">₹800</p>
                      <span><strong>Size</strong>: S</span><br>
                      <span><strong>Color</strong>: Yellow</span><br>
                      <p><strong>Quantity:</strong>&nbsp;1</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 divide-left">
                <div class="cart-content">
                      <p class="cart-products-count">There are 3 items in your cart.</p>
                      <p><strong>Total products:</strong>&nbsp;₹157.15</p>
                    <p><strong>Total shipping:</strong>&nbsp;Free </p>
                    <p><strong>Total:</strong>&nbsp;₹157.15 (tax incl.)</p>
                  <div class="cart-content-btn">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Continue shopping</button>
                      <a href="cart.html" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>  Proceed to checkout</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>-->