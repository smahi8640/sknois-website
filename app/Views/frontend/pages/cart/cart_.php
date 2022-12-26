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

<script type="text/javascript">
    // To conform clear all data in cart.
    function clear_cart() {
        var result = confirm('Are you sure want to clear all products?');

        if (result) {
             var x = document.getElementById("snackbar2");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            window.location = "<?php echo base_url('cart/remove/all'); ?>";
        } else {
            return false; // cancel button
        }
    }
</script>

        <!--	PRODUCTLISTPAGE WRAPPER	-->

	<section class="cart-section">
      <div class="container">
        <div class="row">
                    <?php
        // If cart is empty, this will show below message.
        if(empty($cart_check)) {
        ?>
            <!--<h4 class="cart_title">My Cart</h4-->
            <div class="cart_empty col-md-12">
                <div class="cart_inner">
                    <img src="<?php echo base_url('assets/images/cart-empty.png'); ?>">
                    <h4>Hey, it feel so light!</h4>
                    <p>Your Shopping Cart is empty</p>
                    <a href="<?php echo base_url();?>" class="btn btn-outline-primary">ADD ITEMS</a>
                </div>
            </div>
            <!--<div class="alert alert-info">To add products to your shopping cart click on "Add to Cart" Button</div>-->
        <?php }  ?>
        
         <?php
         // All values of cart store in "$cart".
         if ($cart = $this->cart->contents()): ?>
         <div class="col-lg-7 col-md-12 col-sm-12">
                    <div class="cart-list">
             
                  
                 <?php  
                 //print_r(json_encode($this->cart->contents()));
                   // Create form and send all values in "shopping/update_cart" function.
                 $attributes = array('id' => 'cart-update');
                    echo form_open('cart/updatecart',$attributes);
                    $grand_total = 0;
                    $disgrand_total = 0;
                    $i = 1;
                    $itemIndex=1;
                    foreach ($cart as $item):
                      

                    //   echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                    //  Will produce the following output.
                    // <input type="hidden" name="cart[1][id]" value="1" />

                    echo form_hidden('cart[' . $item['rowid'] . '][id]', $item['id']);
                    echo form_hidden('cart[' . $item['rowid'] . '][rowid]', $item['rowid']);
                    echo form_hidden('cart[' . $item['rowid'] . '][name]', $item['name']);
                    echo form_hidden('cart[' . $item['rowid'] . '][price]', $item['price']);
                    echo form_hidden('cart[' . $item['rowid'] . '][mrp]', $item['mrp']);
                    echo form_hidden('cart[' . $item['rowid'] . '][qty]', $item['qty']);
                    echo form_hidden('cart[' . $item['rowid'] . '][attribute]', $item['attribute']);
                    ?>
                    <div class="cart-item">
                        <div class="cItem-left">
                            <div class="left-inner">
                                <img class="img_center" src="<?php echo base_url('media/source/').$item['img']?>">
                            </div>
                        </div>
                        <div class="cItem-right">
                            <div class="right-inner">
                                <div class="item-des">
                                <h3><?php echo $item['name']; ?></h3>
                                <span>
                                    <?php
                                        if($item['attribute'] != '') {

                                            $attributes = unserialize($item['attribute']);
                                            foreach ($attributes AS $attribute) {

                             $valarr = explode(':', $attribute);
                             echo $valarr[1].'<br/>';
                       
                                                //echo $attribute.'<br/>';
                                            }
                                              /*
                                              $arraynama="";
                                              foreach((array)$attributes as  $value) {
                                                  echo $value;
                                                  $arraynama .= $value." / ";
                                                  }
                                              $newarraynama = rtrim($arraynama, "/ ");
                                             echo $newarraynama;*/
                                        }
                                    ?>
                                </span>
                                <div class="quantity">
                           <div class="input-group">
                             <input type="text" id="quantity_<?php echo $itemIndex;?>" name="cart[<?php echo $item['rowid'];?>][qty]'" onchange="submitCartUpdateForm()" class="qty form-control input-number" value="<?php echo $item['qty'];?>" min="1" max="100">
                              <span class="plus_minus input-group-btn-vertical mr-2">
                                <button type="button" class="quantity-right-plus btn qtyplus" field="quantity_<?php echo $itemIndex;?>" data-type="plus"  data-field="">
                                    <i class="icon-plus fa fa-plus" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="quantity-left-minus btn qtyminus"  data-type="minus" data-field="" field="quantity_<?php echo $itemIndex;?>">
                                    <i class="icon-minus fa fa-minus" aria-hidden="true"></i>
                                </button>
                              </span>
                            </div>
                          </div>
                                <div class="price">
                                    <h5 class="main-price">Total: ₹<?php
                $disgrand_total = $disgrand_total + ($item['price']*$item['qty']);
                $grand_total = $grand_total + ($item['mrp']*$item['qty']); echo number_format($item['subtotal'], 2); ?></h5>
                                  
                                  <h6>Price: ₹<?php echo number_format($item['price'], 2); ?></h6>
                                  <?php if($item['mrp']=="0" || $item['mrp']==$item['price']){ } else{?>
                                  <h5 class="discount-price">₹<?php echo number_format($item['mrp'], 2); ?></h5>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="c_Item-bottom">
                            <div class="bottom-inner">
                              <a onclick="myFunction3()" href="<?php echo base_url('cart/remove/' . $item['rowid']); ?>"><i class="fa fa-trash" aria-hidden="true"></i>  REMOVE</a>
                            </div>
                        </div>
                    </div>
         <?php $itemIndex++; endforeach; ?>
         </div>
        </div>
         
         
         
        
          
          
          <div class="col-lg-5 col-md-6 cart-wrap">
            <div class="cart-total mb-3">
              <h3>Cart Summary</h3>
              <p class="d-flex">
                <span>Item MRP</span>
                <span>₹<?php echo number_format($grand_total, 2); ?></span>
              </p>
            <!--  <p class="d-flex">
                <span>Delivery</span>
                <span>Free</span>
              </p>-->
              <p class="d-flex">
                <span>Discount</span>
                <span>₹<?php echo number_format($grand_total-$disgrand_total, 2); ?></span>
              </p>
              <hr>
              <p class="d-flex total-price">
                <span>Total</span>
                <span>₹<?php echo number_format($disgrand_total, 2); ?></span>
              </p>
            </div>
           <!-- <div class="coupon-block">
                <label>Coupon</label>
                <div class="form-inline">
                    <input type="text" class="form-control mb-2 mr-sm-2" id="coupon_cide" placeholder="Coupon Code">
                    <button type="submit" class="btn btn-primary mb-2">Apply</button>
                </div>
            </div>-->
            <!--<label style="color:Red">Dear Customer, we are not operational due to restrictions imposed by local authorities 
					   on the movement of goods inspite of clear guidelines provided by central authorities to enable essential services. We are working with the authorities
					   to be back soon.</label>-->
            <hr/>
            <p>
               <!-- <input  type="submit" class="btn btn-info" onclick="myFunction1()" data-toggle="modal" data-target="#cart-modal" value="Update Cart">-->
                <input type="button" class="btn btn-warning" value="Clear Cart" onclick="clear_cart()" data-toggle="modal" data-target="#cart-modal">
                <?php echo form_close(); ?>
                <input type="button" class="btn btn-success"  value="Proceed to Checkout" onclick="window.location = 'checkout'">
            </p>
          </div>
           <?php endif; ?>
        </div>
      </div>
    </section>
    
  
    
  <style>
#snackbar1 {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar1.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>


    	<script>
function myFunction1() {
  var x = document.getElementById("snackbar1");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>
<div id="snackbar1">Cart Updated Successfully.</div>



  <style>
#snackbar2 {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar2.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>
    	<script>
function myFunction3() {
  var x = document.getElementById("snackbar3");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
   var href = event.currentTarget.getAttribute('href')
  window.location= href;
}
</script>
<div id="snackbar2">Cart Cleared Successfully.</div>




  <style>
#snackbar3 {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar3.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>
    	<script>
function myFunction3() {
  var x = document.getElementById("snackbar3");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
   var href = event.currentTarget.getAttribute('href')
  window.location= href;
}



function singleAddToCart(quantity) {

                var quantity = quantity;

                var attribute = {};
                <?php if($record->attribute_ids != '') { ?>
                <?php $attribute_list = $this->products_model->getattribute($record->id); ?>
                <?php foreach ($attribute_list AS $attribute) { ?>
                <?php // $attribute_details = $this->attributes_model->recordlist($attribute); ?>
                var radioValue = jQuery("input[name=\"attribute[<?php echo $attribute['title']; ?>]\"]:checked").val();
                attribute['<?php echo $attribute['title']; ?>'] = radioValue;
                <?php } ?>
                <?php } ?>


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

        }

function submitCartUpdateForm() {
  setTimeout(function(){ $("#cart-update").submit(); }, 100);
       
    }

    $('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        
        var currentVal = parseInt($('input[id='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[id='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[id='+fieldName+']').val(0);
        }
        submitCartUpdateForm();
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[id='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[id='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[id='+fieldName+']').val(0);
        }
        submitCartUpdateForm();
    });

</script>
<div id="snackbar3">Cart Item Removed Successfully.</div>