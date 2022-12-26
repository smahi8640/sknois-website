
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
	<section class="checkout-section">
		  <div class="container">
			<div class="row">
			  <div class="checkout col-lg-7">
			      <div id="accordion">
				    <div class="content checkout__login">
    					  <ul class="nav nav-inline" role="tablist">
    						<li class="nav-item active"><a class="nav-link active show" data-toggle="tab" href="#checkout-guest-form" role="tab" aria-controls="checkout-guest-form" aria-selected="true" aria-expanded="true">Order as a guest</a></li>
    						<!--<li class="nav-item"><span href="nav-separator"> | </span></li>-->
    						<li class="nav-item"><a class="nav-link" data-link-action="show-login-form" data-toggle="tab" href="#checkout-login-form" role="tab" aria-controls="checkout-login-form" aria-expanded="false">Sign in</a></li>
    					  </ul>
    					  <div class="tab-content">
    					    <div class="tab-pane active" id="checkout-guest-form" role="tabpanel" aria-expanded="true">
    					         <form id="guestregister" method="post">
				    
					<div class="profile__right">
                        <div class="profile__box">	
                        
                            <div class="profile__box__body">
						
						 <div class="form-group row">
							<label class="col-md-2 form-control-label required">Email</label>
							<div class="col-md-7">        
							  <input class="form-control" name="email" type="email" id="email" placeholder="Email"  >
							</div>
						  </div>
						<div class="form-group row d-none">
						  <label class="col-md-2 form-control-label required">Mobile No.</label>
    								  <div class="col-md-7">  
						  	
							<input class="form-control"  name="phone" id="phone" pattern="[0-9]{10}" placeholder="Mobile" type="text" >
						  </div>
					
						</div>
						

						<div id="payment-confirmation">
						 
						  <button class="btn btn-danger my-cart-btn my-cart-b">Submit</button>
						 
						</div>
					</div>	
				    </div>
				    </div>
					
				    </form>
    					      </div>
    					      <div class="tab-pane" id="checkout-login-form" role="tabpanel" aria-hidden="true" aria-expanded="false">
    					          <div class="authentication__main">
                    <div class="left__column">
                        <h3>Sign in</h3>
                        <form id="login" method="post">
                            <div class="form-group">
                                <label >
    								<?php echo form_label('Email','email');?>
    							</label>  
    							<input class="form-control" required name="email" id="email" type="text" placeholder="email" value="">
    			
    						</div>
                            <div class="form-group">
    							<label>
    								<?php echo form_label('Password','password');?>
    							</label>    
    							  	<?php echo form_password('password', set_value('password'),'class="form-control" placeholder="Password"');?>
    						 </div>
    						 
                            
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn__login effect__btn">Login</button>
                            </div>
                         </form>                            
                    </div>
                    <div class="right__column">
                        <div class="joyari__logo">
                            <img src="<?php echo base_url('assets/frontend'); ?>/img/joyari-logo.png" alt="Joyari">
                        </div>
                        <div class="joyari__content">
                            <h3>Don't have an account?</h3>
                            <a href="<?php echo BASE.'users/register'; ?>" class="btn btn__signup effect__btn">Sign up</a>
                        </div>
                    </div>
                </div>	
    					      </div>       
    					 </div>  
    					        
					 </div>
					 </div>
    			
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
		
		
 <div class="modal fade small__popup" id="otp__popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    <h4>Enter OTP</h4>
                    <p>OTP sent on your registered email Id</p>
                    <form id="verifyotp" method="POST" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                       
                        <div class="form-group otp__input__group d-flex align-items-center justify-content-center">
                            <input type="text" class="otp__input" id="digit-1" name="digit-1" data-next="digit-2" />
                            <input type="text" class="otp__input" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                            <input type="text" class="otp__input" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                            <input type="text" class="otp__input" id="digit-4" name="digit-4" data-previous="digit-3" />
                        </div>
                        <div class="form-group mb-0">
                            <div class="single__main__title">
                                <a href="#" id="resendotp">
                                    <span class="help">Resend OTP</span>
                                </a>
                            </div>
                            <div class="result"></div>
                            <button type="submit" class="btn effect__btn">Verify</button>
                            
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

<script>
        $('.digit-group').find('input').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());
                
                if(e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));
                    
                    if(prev.length) {
                        $(prev).select();
                    }
                } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));
                    
                    if(next.length) {
                        $(next).select();
                    } else {
                        if(parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });
    </script>
    
 <script>
 $(document).ready( function() {
     
     $(document).on("submit","#login",function(e){
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url('/checkout/login'); ?>',
				method: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false
			})
			.done(function( response ) {
			    var obj =  JSON.parse(response);
			    if(obj.message_type=="success"){
			    window.location = "<?php echo base_url().'/checkout'?>";
			    }else{
				alert(obj.message);
			    }
			});
		});
     
     $(document).on("submit","#guestregister",function(e){
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url('/checkout/guestregister'); ?>',
				method: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false
			})
			.done(function( response ) {
			    var obj =  JSON.parse(response);
			    if(obj.message_type=="success"){
			    $("#otp__popup").modal('toggle');
			    }else{
				
				$("#otp__popup").modal('toggle');
			    }
			});
		});
	 
	 $(document).on("submit","#verifyotp",function(e){
			e.preventDefault();
			var fd= new FormData(this);
			fd.append("email",$("#email").val());
			$.ajax({
				url: '<?php echo base_url('/checkout/otp'); ?>',
				method: "POST",
				data: fd,
				contentType: false,
				cache: false,
				processData: false
			})
			.done(function( response ) {
			    var obj =  JSON.parse(response);
			    if(obj.message_type=="success"){
				    window.location = "<?php echo base_url().'/checkout'?>";
			    }else{
				
			    $('.result').html('<span class="not__available"><span class="suggetion"><i class="fa fa-times" aria-hidden="true"></i> Invalid OTP</span></span>'); 
				
			    }
			});
		});	
		
	
	$(document).on("click","#resendotp",function(){
	    var email = $("#email").val();
	    
	    $.ajax({
	    		url:'<?php echo base_url().'/checkout/resendotp'?>',
	    		method:"POST",
	    		data: { email: email },
	    	})
			.done(function( response ) {
			    var obj =  JSON.parse(response);
			    if(obj.message_type=="success"){
			        $("#digit-1").val('');
			        $("#digit-2").val('');
			        $("#digit-3").val('');
			        $("#digit-4").val('');
	    			$('.result').html('<span class="available"><span class="suggetion"><i class="fa fa-check" aria-hidden="true"></i> OTP resent successfully </span></span>');
           
	    			}
			});
	});  	
		
     
 });
</script>	       
    <?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>