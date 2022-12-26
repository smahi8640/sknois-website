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
                                <form id="register" class="formvalidate">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input class="form-control" required="" name="first_name" type="text" placeholder="First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input class="form-control" required="" name="last_name" type="text" placeholder="Last Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input class="form-control" required="" id="email" name="email" type="text" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                            <label for="">Mobile</label>
                                            <input class="form-control" required name="phone" id="phone" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Without country code (+1)">
                                        </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <?php echo form_password('password', set_value('password'),'class="form-control" placeholder="Password"');?>
    						            
                                    </div>
                                    <div class="form-group form-check">
                                            <input type="checkbox" id="terms" name="terms" checked class="form-check-input" required readonly>
                                            <label for="terms" class="custom__label">I have read and agreed with <a href="#">Terms & Conditions</a></label>
                                        </div>
                                    <!--<div class="form-group checkBox">
                                        <input type="checkbox" name="remember" id="remember" class="custom__checkbox">
                                        <label for="remember" class="custom__label">Remember me</label>
                                        <a href="<?php //echo base_url('forgot-your-password'); ?>" class="forgot__password float-right">Forgot your password?</a>
                                    </div>-->
                                    <div class="form-group mb-0 ">
                                        <a href="<?php echo BASE.'user/otp'; ?>" class="forgot__password float-right d-none">Login with OTP</a>
                                        <button class="btn btn__login effect__btn">Register</button>
                                    </div>
                                 </form>
                            </div>
                            <div class="right__column">
                                
                                <div class="joyari__content">
                                    <h3>Already have an account?</h3>
                                    <a href="<?php echo BASE.'users/login'; ?>" class="btn btn__signup effect__btn">Sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		
	
<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
<script>
 $(document).ready( function() {
     
     //Validation
	  $('.formvalidate').validate({
    rules: {
        email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
      },
      first_name: {
        required: true,
      },
      last_name: {
        required: true,
      },
	  phone: {
        required: true,
      },
      terms: {
        required: true,
        minlength: 1,
      }           
      
    },
    messages: {
        email: {
        required: "Please enter email",
        email: "Please enter a vaild email"
      },
      password: {
        required: "Please enter password",
      },
      first_name: {
        required: "Please enter first name",
      },
      last_name: {
        required: "Please enter last name",
      },
	  phone: {
        required: "Please enter mobile",
      },
	  terms: {
        required: "Please accept our terms",
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

     $(document).on("submit","#register",function(e){
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url('/users/register'); ?>',
				method: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false
			})
			.done(function( response ) {
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
			});
		});
 });
</script>	   		
       </body>

</html>		       
    