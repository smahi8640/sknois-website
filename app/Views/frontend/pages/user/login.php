<?php 
$this->db = \Config\Database::connect();
$request = \Config\Services::request();
?>
<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<main>
        <section class="authentication--block">
            <div class="container">
            
                    <div class="col-lg-12">
                        <div class="authentication__main">
                            <div class="left__column">
                                <h3>Sign in</h3>
                               <form id="login" class="formvalidate">
                                    <div class="form-group d-none">
                                        <label for="">Enter Mobile</label>
                                        <input class="form-control"  name="identity" pattern="[0-9]{10}" type="text" placeholder="Mobile">
    						            
                                    </div>
                                    <div class="form-group">
                                        <label for="">Enter Email</label>
                                        <input class="form-control" required name="identity" id="email" type="email" placeholder="Email">
    						            
                                    </div>
                                    <div class="form-group">
                                        <label for="">Enter Password</label>
                                        <?php echo form_password('password', set_value('password'),'class="form-control" placeholder="Password"');?>
    						            
                                    </div>
                                    <!--<div class="form-group checkBox">
                                        <input type="checkbox" name="remember" id="remember" class="custom__checkbox">
                                        <label for="remember" class="custom__label">Remember me</label>
                                        <a href="<?php //echo base_url('forgot-your-password'); ?>" class="forgot__password float-right">Forgot your password?</a>
                                    </div>-->
                                    <div class="form-group mb-0 ">
                                        <a href="<?php echo BASE.'user/otp'; ?>" class="forgot__password float-right d-none">Login with OTP</a>
                                        <button type="submit" class="btn btn__login effect__btn">Login</button>
                                        <a href="#" id="loginotp">
                                            <span class="help">Login with OTP</span>
                                        </a>
                                    </div>
                                 </form>
                            </div>
                            <div class="right__column">
                                
                                <div class="joyari__content">
                                    <h3>Don't have an account?</h3>
                                    <a href="<?php echo BASE.'users/register'; ?>" class="btn btn__signup effect__btn">Sign up</a>
                                </div>
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
                                <a href="#" id="loginotp">
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
		
	
<?= $this->include('frontend/partial/footer') ?>
<?= $this->include('frontend/partial/js') ?>
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
 $(document).ready(function () {
    //Validation
  $('.formvalidate').validate({
    rules: {
        email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
      }   
      
    },
    messages: {
        email: {
        required: "Please enter email",
        email: "Please enter a vaild email"
      },
      password: {
        required: "Please enter password",
      }       
      
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
});
	$(document).on("submit","#login",function(e){
		e.preventDefault();
		$.ajax({
			url:'<?php echo base_url().'/users/login'?>',
			method:"POST",
			data:new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success(response){
			    var obj =  JSON.parse(response);
			    if(obj.message_type=="success"){
				 swal(obj.message, {
				 	icon: "success",
				 });
                window.location = obj.url;
			  }else{
			      swal(obj.message, {
					icon: "error",
				});
			  }
			}
		})
	})
	
	$(document).on("click","#loginotp",function(){
			var email = $("#email").val();
			var atposition=email.indexOf("@");  
            var dotposition=email.lastIndexOf(".");  
            if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){ 
                alert("please enter valid email id");
            }else{
			$.ajax({
				url: '<?php echo base_url('/checkout/guestregister'); ?>',
				method: "POST",
				data: { email: email },
			})
			.done(function( response ) {
			    var obj =  JSON.parse(response);
			    if(obj.message_type=="success"){
			    $("#otp__popup").modal('toggle');
			    }else{
				
				$("#otp__popup").modal('toggle');
			    }
			});
			}
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
				    window.location = obj.url;
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
       </body>

</html>	
	
