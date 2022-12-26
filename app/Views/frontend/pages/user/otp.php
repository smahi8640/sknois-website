
        <section class="authentication--block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="authentication__main">
                            <div class="left__column">
                                <h3>Sign in</h3>
                                
                                    <div class="form-group d-none">
                                        <label for="">Enter Mobile</label>
                                        <input class="form-control" required name="identity1" id="phone" pattern="[0-9]{10}" type="number" placeholder="Mobile">
    						            <p class="mt-2 mb-0 text-danger result"></p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Enter Email Id</label>
                                        <input class="form-control" required name="identity" id="email" type="email" placeholder="Email Id">
    						            <p class="mt-2 mb-0 text-danger result"></p>
                                    </div>
                                    <div class="form-group mb-0">
                                        <a href="#" id="get_otp"   class="btn btn__login effect__btn">Generate OTP</a>
                                        <a href="<?php echo base_url('user/login'); ?>" class="forgot__password float-right">Login with Password</a>
                                    </div>
                                
                            </div>
                            <div class="right__column">
                                <div class="joyari__logo">
                                    <img src="<?php echo base_url('assets/frontend/'); ?>img/joyari-logo.png" alt="Joyari">
                                </div>
                                <div class="joyari__content">
                                    <h3>Don't have an account?</h3>
                                    <a href="<?php echo base_url('register'); ?>" class="btn btn__signup effect__btn">Sign up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		
		
	<div class="modal fade small__popup" id="otp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <button type="submit" class="btn effect__btn">Submit</button>
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
     
     $(document).on("click","#get_otp1",function(){
		     var phone = $("#phone").val();
		     if(phone!="" && phone.length=='10'){
			$.ajax({
				method: "POST",
    			url: "<?php echo site_url('user/checkPhone'); ?>",
    			dataType: 'json',
    			data: { phone: phone },
			})
			.done(function( response ) {
			    if(response.result != null) {
			        $('.result').html('');
			       $("#otp").modal('toggle');
			    }else{
			       $('.result').html('<span class="suggetion text-danger">Please enter valid mobile number</span>');
			    }
			});
		     }else{
		         $('.result').html('<span class="suggetion text-danger">Please enter valid mobile number</span>'); 
		     }
		});
		
	$(document).on("click","#get_otp",function(){
		     var email = $("#email").val();
		     if(email!=""){
			$.ajax({
				method: "POST",
    			url: "<?php echo site_url('user/checkEmail'); ?>",
    			dataType: 'json',
    			data: { email: email },
			})
			.done(function( response ) {
			    if(response.result != null) {
			        $('.result').html('');
			       $("#otp").modal('toggle');
			    }else{
			       $('.result').html('<span class="suggetion text-danger">Please enter valid Email Id</span>');
			    }
			});
		     }else{
		         $('.result').html('<span class="suggetion text-danger">Please enter valid Email Id</span>'); 
		     }
		});	
		
	$(document).on("submit","#verifyotp",function(e){
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url('user/verifyotp'); ?>',
				method: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false
			})
			.done(function( response ) {
			    var obj =  JSON.parse(response);
			    if(obj.message_type=="success"){
				    window.location = "<?php echo base_url().'user/profile'?>";
			    }else{
				
			    $('.result').html('<span class="not__available"><span class="suggetion"><i class="fa fa-times" aria-hidden="true"></i> Invalid OTP</span></span>'); 
				
			    }
			});
		});	
	
	$(document).on("click","#resendotp1",function(){
		var phone = $("#phone").val();
	    
	    
	    $.ajax({
	    		url:'<?php echo base_url().'user/resendotp'?>',
	    		method:"POST",
	    		data: { phone:phone },
	    		dataType: 'json',
	    	})
			.done(function( response ) {
			    //var obj =  JSON.parse(response);
			    if(response.status) {
			        $("#digit-1").val('');
			        $("#digit-2").val('');
			        $("#digit-3").val('');
			        $("#digit-4").val('');
	    			$('.result').html('<span class="available"><span class="suggetion"><i class="fa fa-check" aria-hidden="true"></i> OTP resent successfully </span></span>');
           
	    			}
			});
	});  	
	
	$(document).on("click","#resendotp",function(){
		var email = $("#email").val();
	    
	    
	    $.ajax({
	    		url:'<?php echo base_url().'user/resendotp'?>',
	    		method:"POST",
	    		data: { email:email },
	    		dataType: 'json',
	    	})
			.done(function( response ) {
			    //var obj =  JSON.parse(response);
			    if(response.status) {
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