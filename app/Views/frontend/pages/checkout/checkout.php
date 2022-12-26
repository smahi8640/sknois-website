
<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
	 


</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
    <?php
    $this->db = \Config\Database::connect();
    $request = \Config\Services::request();
    ?>
<main>  
    <section class="breadcum--block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcum__main">
                    <ul class="d-flex align-items-center">
                        <li>Home</li>
                        <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/down-arrow.svg" alt="Arrow"></li>
                        <li class="active">Checkout</li>
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
			        
			  	    <form action="<?= base_url();?>/checkout/confirm" id="checkout-form" class="checkout-form" method="post" accept-charset="utf-8">
				    
							
							
						  <!--<label hidden class="col-md-3 form-control-label required">First Name</label>
						      
							<input hidden class="form-control" name="customer_firstname" type="text" value="<?php /*echo $current_user->first_name; */?>">
						 
					
						  <label hidden class="col-md-3 form-control-label required">Last Name</label>
					        
							<input hidden class="form-control" name="customer_lastname" type="text" value="<?php /*echo $current_user->last_name; */?>">-->
						  
							  
								<label hidden class="col-md-3 form-control-label required">Social title</label>
							
									  <input hidden name="id_gender" type="radio" value="1">
									
									  <input hidden name="id_gender" type="radio" value="2">
									  
									 <label hidden class="col-md-3 form-control-label required">Company</label>
						            <input name="user_id" type="hidden" value="<?php echo $current_user->id; ?>" >
							<input hidden name="customer_company" type="text" value="">
					<div class="profile__right">
                        <div class="profile__box">	
                        
                            <div class="profile__box__body">
							  <div class="form-group row">
								<label class="col-md-2  form-control-label required">Name</label>
								<div class="col-md-5">        
								  <input class="form-control" name="customer_firstname" type="text" value="<?php echo $current_user->first_name; ?>" required placeholder="First Name">
								</div>
								<div class="col-md-5">        
								  <input class="form-control" name="customer_lastname" type="text" value="<?php echo $current_user->last_name; ?>" placeholder="Last Name">
								</div>
							  </div>
							 
						  
						<div class="form-group row ">
						  <label class="col-md-2 form-control-label required">Address</label>
						  <div class="col-md-5">  
							<textarea name="customer_address" id=""  rows="2" class="form-control" placeholder="Address" required><?php echo $current_user->customer_address; ?></textarea>    
						  </div>
						  <div class="col-md-5">  
						  <input class="form-control" name="customer_permanent_address" type="text" value="<?php echo $current_user->customer_permanent_address; ?>" placeholder="Landmark"> 
						  </div>
						</div>
							<div class="form-group  row">
						  <label class="col-md-2 form-control-label required">Zip Code</label>
						  <div class="col-md-5">        
							<input class="form-control" name="customer_pincode" id="zipcode" type="text" required value="<?php echo $current_user->customer_pincode; ?>" placeholder="Zip Code">
						  </div>
						  <div class="col-md-5">
                              <input class="form-control" name="customer_city" id="city" type="text" value="<?php echo $current_user->customer_city; ?>" required="" placeholder="City">
						
						  </div>
						</div>
					    
					    <div class="form-group row">
						  <label class="col-md-2 form-control-label required">Country / State</label>
						  <div class="col-md-5">
                               <?php
                                          $countries = $this->db->query("select * from countries where id='231'")->getResult();
                                          $options = array();
                                          $options[''] = '---';
                                          foreach ($countries AS $country) {
                                              $options[$country->id] = $country->name;
                                          }
                                           if($current_user->country!=""){ echo form_dropdown('customer_country', $options, set_value('customer_country',   $current_user->country), 'class="form-control" id="customer_country"'); 
                                          }else{ echo form_dropdown('customer_country', $options,  set_value('customer_country',   231), 'class="form-control" id="customer_country"');}
                                          ?>
						  </div>
						  <div class="col-md-5">
                              <?php
			                 echo form_dropdown('customer_state', "", $current_user->customer_state, 'class="form-control" id="customer_state" required');?>
						  </div>
						</div>
						<?php if($current_user->email){
                                $readonly="readonly";
                              
                          }else{
                            $readonly="";
                          }?>
						 <div class="form-group row">
							<label class="col-md-2 form-control-label required">Email</label>
							<div class="col-md-10">        
							  <input class="form-control" name="customer_email" type="email" required value="<?php echo $current_user->email; ?>" <?php echo $readonly; ?>>
							</div>
						  </div>
						<div class="form-group row">
						  <label class="col-md-2 form-control-label required">Mobile No.</label>
						  
    								  <div class="col-md-7">  
						  	
							<input class="form-control" required name="customer_phonenumber"  type="number" value="<?php echo $current_user->phone; ?>" placeholder="Without country code (+1)">
						  </div>
					
						</div>
						<div class="form-group row">
						  <div class="col-md-9 col-md-offset-3">
							<input hidden name="use_same_address" type="checkbox" value="1" checked="">
						
						  </div>
						</div>


                        <!--<div class="form-group">
                            <label>Payment Method</label>
                            <div>
                                <label><input type="radio" name="payment_method" value="COD" checked="checked" /> Cash on Delivery</label> <br>
                                <label><input type="radio" name="payment_method" value="CC Avenue" /> CC Avenue</label>
                            </div>
                        </div>-->
		
			
					<!--	<div class="form-group row">
						   <div class="col-md-12 col-md-offset-12">  
						  <input name="use_same_address" type="checkbox" value="1" checked="">
						  <label>I agree to the terms of service and will adhere to them unconditionally.</label>
						  </div>
						</div>-->
						<div id="payment-confirmation">
						  <?php echo form_hidden('user_id',set_value('id', $current_user->id));?>
						  <button type="submit" class="btn btn-danger my-cart-btn my-cart-b" id="confirm">Review & Confirm</button>
						  <?php //echo form_submit('submit', 'Review & Confirm', 'class="btn btn-danger my-cart-btn my-cart-b" onclick="myFunction()" id="btn-placeorder"');?>
						  
						</div>
					</div>	
				    </div>
				    </div>
					
				    </form>
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
		</div>
	</section>

<script type="text/javascript">

	/*jQuery(document).ready( function() {
	
		jQuery('#btn-placeorder').click( function() {
							
			jQuery('#checkout-form').submit();
			
		});
	
	});*/

</script>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/admin/css/intlTelInput.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/intlTelInput.js'); ?>"></script>
<script type="text/javascript">
    
	function checkzip(zipcode){
	jQuery.ajax({
			method: "GET",
			url: "https://ziptasticapi.com/"+zipcode
			
		})
		.done(function( response ) {
		    var obj =  JSON.parse(response);
			if(obj.country == "US") {
			    jQuery("#city").val(obj.city);
			    $("#customer_state option").each(function() {
                  if($(this).text().toUpperCase() == obj.city.toUpperCase()) {
                    $(this).attr('selected', true);            
                  }else{
                     $(this).attr('selected', false);      
                  }                        
                });
			    jQuery("#confirm").removeAttr("disabled");
				
			}else{
				alert("It seems we are not serving this zipcode!");
				jQuery("#confirm").attr("disabled","true");
			}
		});
	}	 
	
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


    jQuery(document).ready( function() {
        getstate(231);
        setTimeout( function() { 
        checkzip(jQuery('#zipcode').val());   
        }, 1000);
    	
	jQuery("#zipcode").on("change", function() {
	    getstate(231);
	    setTimeout( function() { 
	    checkzip(jQuery('#zipcode').val());   
	    }, 1000);
	});	
	

       

        jQuery('#customer_country').change( function () {

            var customer_country = jQuery(this).val();
            getstate(customer_country);

        });
        
    });
    
</script>