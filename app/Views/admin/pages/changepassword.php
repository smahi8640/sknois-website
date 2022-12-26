<?php $refer= @$_SERVER['HTTP_REFERER']; ?>
<!DOCTYPE html>
<html lang="en">
<head>

  <?= $this->include('admin/partial/head') ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed overlay-wrapper">
<div class="overlay" id="mab1" style="display:none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
<div class="wrapper">

  <?= $this->include('admin/partial/top') ?>

  <?= $this->include('admin/partial/sidemenu') ?>

  <?= $this->include('admin/partial/title') ?>

  <form  id="save-form" class="records-list-form formvalidate" method="post" accept-charset="utf-8">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Change Password
            </h3>
       </div>
        <div class="card-body">

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="c-name">New Password :</label>
                    <input type="password" class="form-control" name="password" required> 
                </div>
                <div class="form-group col-md-6">
                    <label for="c-name">Confirm Password :</label>
                    <input type="password" class="form-control" name="cpassword" required> 
                </div>

                
            </div>

        </div>   
        <div class="card-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp;&nbsp;SAVE DATA</button>
            <a class="btn btn-danger" href="<?php echo $refer;?>"><i class="fas fa-times" aria-hidden="true"></i>&nbsp;&nbsp;CLOSE</a>
            <button class="btn btn-warning" type="reset"><i class="fas fa-redo" aria-hidden="true"></i>&nbsp;&nbsp;RESET</button>
            
        </div>
    </div>    
  </form>

  <?= $this->include('admin/partial/footer') ?>

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>

<?= $this->include('admin/partial/js') ?>

<script>
$(document).ready( function() {
//Validation
  $('.formvalidate').validate({
    rules: {
      password: {
        required: true,
      }  
      
    },
    messages: {
      password: {
        required: "Please enter a Password",
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
	    		url:'<?php echo base_url('admin/settings/changepassword') ?>',
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
                        //window.location = "<?php //echo base_url().'admin1/brands'?>";
                    });
           
                },1000); 
	    			$("#mab1").hide();
	    				//toastr.success('Sent successfully.');	
	    			}
	    			else {
	    			    setTimeout(function(){
                      Toast.fire({
                        icon: 'danger',
                        title: obj.message
                      }).then(function() {
                        //window.location = "<?php //echo base_url().'admin1/brands'?>";
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
