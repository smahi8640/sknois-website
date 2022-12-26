<!DOCTYPE html>
<html lang="en">
<head>

  <?= $this->include('admin/partial/head') ?>
  
</head>
<body class="hold-transition login-page overlay-wrapper">
<div class="overlay" id="mab1" style="display:none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
    
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="<?php echo  base_url(); ?>" class="h1"><b>Joyari</b></a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>
    
          <form action="#" id="save-form" class="records-list-form formvalidate" method="post" accept-charset="utf-8">
            <div class="form-group d-none">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="mobile">
                  <label class="custom-control-label" for="mobile">Click to Login with Mobile</label>
                </div>
            </div>  
              
            <div id="div_email" class="input-group mb-3 form-group">
              <input type="email" id="email" name="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div id="div_phone" class="input-group mb-3 form-group d-none">
              <input type="number" id="phone" name="phone" class="form-control" placeholder="Phone">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-phone"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3 form-group">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
           
            
            <div class="row">
            
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
            <h3><a href="http://vcaretechnologies.net/" class="text-accent" title="V Care Technologies" target="_blank">V Care Technologies</a></h3>
        </div>
      </div>
      <!-- /.card -->
    </div>

<?php // require_once(FCPATH.'app/Views/admin/partial/js.php'); ?>
<?= $this->include('admin/partial/js') ?>
<script>
 $(document).ready(function () {
    
     $('#mobile').change(function() {
        if(this.checked) {
          $('#email').val('');    
          $('#div_phone').removeClass('d-none');  
          $('#div_email').addClass('d-none');  
           
        }else{
          $('#phone').val(''); 
          $('#div_email').removeClass('d-none');  
          $('#div_phone').addClass('d-none'); 
          
        }     
    });
    
//Validation
  $('.formvalidate').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        minlength: 10,
        maxlength: 10
      },
      password: {
        required: true,
        minlength: 6
      },
      captcha: {
        required: true,
      }  
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      phone: {
        required: "Please enter a mobile no",
        phone: "Please enter a vaild  mobile number"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
      captcha: {
        required: "Please enter a Captcha",
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
  
  //TOAST
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });  
      
  //Form Submit 
 $(document).on("submit","#save-form",function(e){
	    	e.preventDefault();
	    	$.ajax({
	    		url:'<?php echo base_url('admin/user/log') ?>',
	    		method:"POST",
	    		data:new FormData(this),
	    		contentType: false,
          cache: false,
          processData:false,
          beforeSend: function(){
            $("#mab1").show();     
          },
	    		success(response){
	    			var obj =  JSON.parse(response);
	    			if(obj.status=="1"){
	    				setTimeout(function(){
                      Toast.fire({
                        icon: 'success',
                        title: obj.message
                      }).then(function() {
                        window.location = "<?php echo base_url().'/admin/dashboard'?>";
                    });
           
                },1000); 
	    			$("#mab1").hide();
	    				//toastr.success('Sent successfully.');	
	    			}else {
	    			    setTimeout(function(){
                      Toast.fire({
                        icon: 'error',
                        title: obj.message
                      }).then(function() {
                        //window.location = "<?php //echo base_url().'admin1/articles'?>";
                    });
           
                },1000); 
	    			$("#mab1").hide();
	    			}
	    		}
	    	})
	    }) 
});
</script>
</body>
</html>