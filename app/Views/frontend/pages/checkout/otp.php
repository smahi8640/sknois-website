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

$cart = $this->cart->contents();
$grand_total = 0;
$disgrand_total=0;
foreach ($cart as $item):
     $disgrand_total = $disgrand_total + ($item['price']*$item['qty']);
	//$grand_total = $grand_total + $item['subtotal'];
	$grand_total = $grand_total + ($item['mrp']*$item['qty']); 
endforeach;

?>

<script type="text/javascript">

    jQuery(document).ready( function() {

        function getstate(country_id) {

            jQuery.ajax({
                url: '<?php echo base_url('checkout/getstates'); ?>',
                method: 'POST',
                dataType: 'html',
                data: { country_id : country_id },
                success: function(data) {
                    jQuery('#customer_state').html( data );
                }
            });

        }

        getstate(<?php if($current_user->country!=""){ echo $current_user->country;}else{ echo "101";} ?>);

        jQuery('#customer_country').change( function () {

            var customer_country = jQuery(this).val();
            getstate(customer_country);

        });


    });

</script>


<!--  INNERPAGE SECTION	-->
<main>
    <section class="breadcum--block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcum__main">
                    <ul class="d-flex align-items-center">
                        <li>Home</li>
                        <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>img/down-arrow.svg" alt="Arrow"></li>
                        <li class="active"><?php echo $this->uri->segment(1); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>		
	<section class="checkout-section" style="margin-top: 20px;">
		<div class="container">
			<div class="row">
			    <div class="checkout col-lg-7 ">
			        
			  	    <?php echo form_open('checkout/otp',array('id'=>'checkout-form', 'class'=>'checkout-form'));?>
				    
							
						
					<div class="profile__right">
                        <div class="profile__box">	
                        
                            <div class="profile__box__body">
						<div class="form-group row">
						  <label class="col-md-2 form-control-label required">OTP</label>
						  
    								  <div class="col-md-7">  
						  	
							<input class="form-control" required name="otp" placeholder="Enter OTP" pattern="[0-9]{4}" type="text" >
						  </div>
					
						</div>
						<div id="payment-confirmation">
						  <?php echo form_hidden('user_id',set_value('id', $this->session->userdata('user_id')));?>
						  <button type="submit" class="btn btn-danger my-cart-btn my-cart-b">Submit</button>
						  <?php //echo form_submit('submit', 'Review & Confirm', 'class="btn btn-danger my-cart-btn my-cart-b" onclick="myFunction()" id="btn-placeorder"');?>
						  
						</div>
					</div>	
				    </div>
				    </div>
					
				    <?php echo form_close();?>
			    </div>
			    <div class="col-lg-5">
                    <div class="order__summary__main">
						<?php
                        if($coupon_data){
                            if($coupon_data['type'] == 'amount'){
                                $final_cost = $sum->gr - $coupon_data['value'];
                                $discount = '₹'.$coupon_data['value'];
                            }
                            else{
                                $discount = ($sum->gr * $coupon_data['value']) / 100;
                                $final_cost = $sum->gr - $discount;
                                $final_cost = $final_cost;
                                $discount = '₹'.$discount;
                            }
                        }
                        else{
                            $final_cost = $sum->gr;
                            $discount = 'Apply Coupon';
                        }
                        ?>
                        <h4>Order Summary</h4>
                        <div class="order__summary">
                            <p class="subtotal">Subtotal <span class="price-values">₹<?php echo $sum->gr_mrp; ?></span></p>
                            <?php if($sum->gr_mrp=="0" || $sum->gr_mrp==$sum->gr){ }else{?>
                            <p class="discount">You Saved <span class="price-values">- ₹3,363</span></p>
                            <?php }?>
                            <p class="discount">Coupon Discount <span class="price-values"><a class="css-6yxsag epg3bs00"><?php echo $discount; ?></a></span></p>
                            <p class="shipping__charge">Delivery Charge (Standard) <span class="price-values"><span class="free">FREE</span></span></p>
                            <p class="price--breakup--final mb-0">TOTAL COST <span class="price-values">₹<?php echo $final_cost; ?></span></p>
                        </div>
                        
                    </div>
                </div>
			</div>
		</div>
	</section>

