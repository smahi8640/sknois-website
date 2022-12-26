
<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
	 

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

        getstate(101);

        jQuery('#customer_country').change( function () {

            var customer_country = jQuery(this).val();
            getstate(customer_country);

        });


    });

</script>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
    <?php
    $this->db = \Config\Database::connect();
    $request = \Config\Services::request();
    ?>
<main> 
	<section class="shopping__cart--block">
        <div class="container">
            <div class="row">
                <div class="checkout col-lg-7 col-md-6">
			  	<?php echo form_open('confirm/confirm',array('id'=>'checkout-form', 'class'=>'checkout-form'));?>
			  	 <div class="profile__right">
                    <div class="profile__box">	                      
                        <div class="profile__box__body">
                            
						
					      
						<input hidden name="customer_company" type="text" value="">
						  <input name="user_id" type="hidden" value="<?php echo $current_data->user_id; ?>" readonly="readonly" placeholder="First Name">
						  <input name="country_code" type="hidden" value="<?php echo $current_data->country_code; ?>" readonly="readonly" placeholder="First Name">
						  <input name="customer_firstname" hidden type="text" value="<?php echo $current_data->first_name; ?>" readonly="readonly" placeholder="First Name">
						 <input name="customer_lastname" hidden type="text" value="<?php echo $current_data->last_name; ?>" readonly="readonly" placeholder="Last Name">
							
						 <input name="amount" hidden value="<?php echo $carttotal['total_price']; ?>" />
					  
					<textarea name="customer_address" hidden id="" rows="2" placeholder="Address" readonly="readonly"><?php echo $current_data->customer_address; ?></textarea>    
					  <input readonly="readonly" hidden name="customer_permanent_address" type="text" value="<?php echo $current_data->customer_permanent_address; ?>" placeholder="Landmark"> 
					  <input name="customer_pincode" hidden type="text" readonly="readonly" value="<?php echo $current_data->customer_pincode; ?>" placeholder="Zip Code">
					 <input name="customer_city" hidden type="text" value="<?php echo $current_data->customer_city; ?>" readonly="readonly" placeholder="City">
						<select name="customer_state" hidden readonly="readonly">
                              <option value="<?php echo $current_data->customer_state; ?>"><?php $data=$this->db->query("select * from states where id='".$current_data->customer_state."'")->getRow();
                            		echo $data->name; ?></option>
                          </select>
                       <select name="customer_country"  hidden readonly="readonly" >
                              <option value="<?php echo $current_data->country; ?>">
                              <?php $data=$this->db->query("select * from countries where id='".$current_data->country."'")->getRow();
                            		echo $data->name; ?></option>
                          </select>
                          
                       	 <input name="customer_email" hidden type="email" required value="<?php echo $current_data->email; ?>" readonly="readonly">
					<input readonly="readonly" hidden name="customer_phonenumber" type="text" value="<?php echo $current_data->phone; ?>">
					 <input name="use_same_address" hidden type="checkbox" value="1" checked="">
					
					
					<div class="address-view">
					
        				  <p class="address-name">
        					<span><?php echo $current_data->first_name." ".$current_data->last_name; ?></span>
        				  </p>
        				  <p>
        					<span><?php echo $current_data->customer_address; ?></span>
        				  </p>
        				  <p>
        					<span><?php echo $current_data->customer_permanent_address; ?></span>
        				  </p>
        				  <p>
        					<span><?php echo $current_data->customer_city; ?>-</span>
        					<span><?php echo $current_data->customer_pincode; ?>-</span>
        					<span><?php $data=$this->db->query("select * from states where id='".$current_data->customer_state."'")->getRow();
                            		echo $data->name; ?>-</span>
                            		<span><?php 
                            		$data=$this->db->query("select * from countries where id='".$current_data->country."'")->getRow();
                            		echo $data->name; ?></span>
        				  </p>
        				  <p>
        					<span><?php echo $current_data->email; ?></span>
        				  </p>
        				  <p class="mobile">
        					<span><?php echo  $current_data->country_code." ".$current_data->phone; ?></span>
        				  </p>
        				  
        				  <!--<div class="address-btns">
        				 
        				      <a href="<?php echo base_url('checkout') ?>" class="addressedit">Edit</a>
        				  </div>-->
				    </div>
                   
                
                    <div class="form-group d-none">
                        
                        <label class="pay-method">Payment Method</label>
                        
                        
                        <div class="custom__radio ">
                            <input type="radio" required="" class="custom__radio__input" id="p2" checked="" name="payment_method" value="Paypal"> 
                            <!--<label for="p2">PayPal</label>-->
                            <img src="<?php echo base_url()?>/media/source/pp1.png" height="30px" />
                        </div>
                    </div>
                        <div class="form-group checkBox"> 
                            <input name="use_same_address" id="terms" class="custom__checkbox" type="checkbox" checked="" required="" value="1">
                            <label class="custom__label" for="terms">I agree to the terms of service and will adhere to them unconditionally.</label>
                        </div>
                        
                        <div id="payment-confirmation">
                            <input type="image" src="<?php echo base_url()?>/media/source/pp1.png" name="submit"  alt="submit"/>  
                        </div>
                  
	                            </div>
                                </div>
                            </div>
                       <?php echo form_close();?>
			  </div>
			  
			  <div class="col-lg-5">
                    <div class="order__summary__main">
                       
                        <h4>Order Summary</h4>
                            <div class="order__summary">
                                <p class="subtotal">Subtotal <span class="price-values">$<?php echo $carttotal['total_mrp']; ?></span></p>
                                <?php if($carttotal['total_mrp']=="0" || $carttotal['total_price']==$carttotal['total_mrp']){ }else{?>
                                <p class="discount">You Saved <span class="price-values">-$<?php echo $carttotal['total_mrp']-$carttotal['total_price']; ?></span></p>
                                <?php }?>
                                <p class="discount">Coupon Discount <span class="price-values"><a class="coupon_discount"><?php //echo $discount; ?></a></span></p>
                                <p class="shipping__charge">Delivery Charge (Standard) <span class="price-values"><span class="free">FREE</span></span></p>
                                <p class="price--breakup--final mb-0">Nett Amount <span class="price-values final_price">$<?php echo $carttotal['total_price']; ?></span></p>
                            </div>
                            
                        
                    </div>
                </div>
			</div>
		  </div>
		</section>
