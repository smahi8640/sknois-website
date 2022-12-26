<?php $refer= @$_SERVER['HTTP_REFERER']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once(APPPATH.'views/admin1/partial/head.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed overlay-wrapper">
<div class="overlay" id="mab1" style="display:none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
<div class="wrapper">
  <?php require_once(APPPATH.'views/admin1/partial/top.php'); ?>

 <?php require_once(APPPATH.'views/admin1/partial/sidemenu.php'); ?>
 
 <?php require_once(APPPATH.'views/admin1/partial/title.php'); ?>


    <form action="<?php echo base_url(''); ?>admin1/coupons" id="save-form" class="records-list-form formvalidate" method="post" accept-charset="utf-8">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?php echo isset($record) ? 'Update' : 'Add';?> &nbsp;<?php echo $title; ?>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
       </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="c-name">Title :</label>
                    <input type="text" class="form-control" name="title" required placeholder="Title"  value="<?php echo @$record->title?>"> 
                </div>
                <div class="form-group col-md-4">
                    <label for="c-name">Code :</label>
                    <input type="text" class="form-control" name="code" placeholder="Code"  value="<?php echo @$record->code?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Type :</label>
                    <select name="type" class="form-control">
                        <?php if(@$record->type=='percentage'){
                            $selected1="selected";
                            $selected2="";
                        }else{
                            $selected1="";
                            $selected2="selected";
                        }
                        ?>
                    <option value="percentage" <?php echo $selected1; ?>>Percentage(%)</option>
                    <option value="amount" <?php echo $selected2; ?>>Amount</option>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Value :</label>
                    <input type="text" class="form-control" name="value" required placeholder="Value"  value="<?php echo @$record->value?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Start Date</label>
                    <input type="date" class="form-control date"  name="start_date"  value="<?php echo @$record->start_date;?>">
                </div> 
                
                <div class="form-group col-md-4">
                    <label for="c-name">End Date</label>
                    <input type="date" class="form-control date"  name="end_date"  value="<?php echo @$record->end_date;?>">
                </div> 
                
                <div class="form-group col-md-4">
                    <label for="c-name">Total Uses :</label>
                    <input type="text" class="form-control" name="total_uses" placeholder="Total Uses"  value="<?php echo @$record->total_uses?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Min. Order Amount :</label>
                    <input type="text" class="form-control" name="min_orderamount" placeholder="Min. Order Amount"  value="<?php echo @$record->min_orderamount?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Access :</label>
                    <select name="access" class="form-control">
                        <?php if(@$record->access=='public'){
                            $selected1="selected";
                            $selected2="";
                        }else{
                            $selected1="";
                            $selected2="selected";
                        }
                        ?>
                    <option value="public" <?php echo $selected1; ?>>Public</option>
                    <option value="registered" <?php echo $selected2; ?>>Registered</option>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Status :</label>
                    <select name="status" class="form-control">
                        <?php if(@$record->status=='1'){
                            $selected1="selected";
                            $selected2="";
                        }else{
                            $selected1="";
                            $selected2="selected";
                        }
                        ?>
                    <option value="1" <?php echo $selected1; ?>>Published</option>
                    <option value="0" <?php echo $selected2; ?>>Unpublished</option>
                    </select>
                </div>
        </div>   
        <div class="card-footer">
            <input type="hidden" name="id" value="<?php echo @$record->id;?>" />
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp;&nbsp;SAVE DATA</button>
            <a class="btn btn-danger" href="<?php echo $refer;?>"><i class="fas fa-times" aria-hidden="true"></i>&nbsp;&nbsp;CLOSE</a>
            <button class="btn btn-warning" type="reset"><i class="fas fa-redo" aria-hidden="true"></i>&nbsp;&nbsp;RESET</button>
            
        </div>
    </div>    
    </form>

       

 <?php require_once(APPPATH.'views/admin1/partial/footer.php'); ?>

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>

<?php require_once(APPPATH.'views/admin1/partial/js.php'); ?>

<script>
$(document).ready( function() {
//Validation
  $('.formvalidate').validate({
    rules: {
      title: {
        required: true,
      }  
      
    },
    messages: {
      title: {
        required: "Please enter a Title",
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
	    		url:'<?php echo base_url('admin1/coupons/add') ?>',
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
                        //window.location = "<?php //echo base_url().'admin1/coupons'?>";
                    });
           
                },1000); 
	    			$("#mab1").hide();
	    				//toastr.success('Sent successfully.');	
	    			}
	    			else if(obj.status=="2"){
	    				setTimeout(function(){
                      Toast.fire({
                        icon: 'success',
                        title: obj.message
                      }).then(function() {
                        window.location = "<?php echo base_url().'admin1/coupons'?>";
                    });
           
                },1000); 
	    			$("#mab1").hide();
	    				//toastr.success('Sent successfully.');	
	    			}else {
	    			    setTimeout(function(){
                      Toast.fire({
                        icon: 'danger',
                        title: obj.message
                      }).then(function() {
                        //window.location = "<?php //echo base_url().'admin1/coupons'?>";
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