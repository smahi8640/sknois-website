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


    <form action="<?php echo base_url(''); ?>admin/siteconfiguration" id="save-form" class="records-list-form formvalidate" method="post" accept-charset="utf-8">
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
                    <label for="c-name">Site Name :</label>
                    <input type="text" class="form-control" name="site_name" placeholder="Name"  value="<?php echo @$record->site_title;?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Site Logo :</label>
                    <div class="input-group">
                    <input class="form-control image_path" id="image" name="site_logo"  value="<?php echo @$record->site_logo?>"/>
                    <div class="input-group-append">
                        <a href="<?php echo base_url(''); ?>/assets/filemanager/dialog.php?type=1&amp;field_id=image&amp;relative_url=1" data-fancybox-type="iframe" class="btn btn-white iframe-btn" type="button">Select</a>
                    </div>
                    <div class="uploaded_images input-group-append">
                        <?php 
                            if(!empty(@$record->site_logo)){
                                
                                    echo '<div class="uploaded_image_ele"><img id="image-preview" style="max-height:80px;max-width:80px;" src="'.base_url('media/source/'.@$record->site_logo).'"  data-attr="'.@$record->id.'" class="uploaded_image"></div>';   
                                
                            }else{
                                echo '<div class="uploaded_image_ele" id="div-preview"  style="display:none;"><img style="max-height:80px;max-width:80px;" src="#"  id="image-preview" class="uploaded_image"></div>';   
                            }
                        ?>
                    </div>
                    
                    </div>
                    
                </div> 
                
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Site Brochure :</label>
                    <div class="input-group">
                    <input class="form-control image_path" id="brochure" name="site_brochure"  value="<?php echo @$record->site_brochure?>"/>
                    <div class="input-group-append">
                        <a href="<?php echo base_url(''); ?>/assets/filemanager/dialog.php?type=2&amp;field_id=brochure&amp;relative_url=1" data-fancybox-type="iframe" class="btn btn-white iframe-btn" type="button">Select</a>
                    </div>
                    </div>
                    
                </div> 
                
                <div class="form-group col-md-4">
                    <label for="c-name">Site Email :</label>
                    <input type="text" class="form-control" name="site_email" placeholder="Email"  value="<?php echo @$record->site_email;?>"> 
                </div>
                
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Email1 :</label>
                    <input type="text" class="form-control" name="email1" placeholder="Email"  value="<?php echo @$record->email1;?>"> 
                </div>
                
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Email2 :</label>
                    <input type="text" class="form-control" name="email2" placeholder="Email"  value="<?php echo @$record->email2;?>"> 
                </div>
                
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Email3 :</label>
                    <input type="text" class="form-control" name="email3" placeholder="Email"  value="<?php echo @$record->email3;?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Site Mobile :</label>
                    <input type="text" class="form-control" name="site_mobile" placeholder="Mobile"  value="<?php echo @$record->site_contact_number;?>"> 
                </div>
                
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Mobile1 :</label>
                    <input type="text" class="form-control" name="mobile1" placeholder="Mobile"  value="<?php echo @$record->mobile1;?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Site Address :</label>
                    <input type="text" class="form-control" name="site_address" placeholder="Address"  value="<?php echo @$record->site_address;?>"> 
                </div>
                
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Showroom Address :</label>
                    <input type="text" class="form-control" name="showroom_address" placeholder="Address"  value="<?php echo @$record->showroom_address;?>"> 
                </div>
                
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Site Timings :</label>
                    <input type="text" class="form-control" name="site_timings" placeholder="Timings"  value="<?php echo @$record->site_timings;?>"> 
                </div>
                
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Site Website :</label>
                    <input type="text" class="form-control" name="site_website" placeholder="website"  value="<?php echo @$record->site_website;?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Site FB :</label>
                    <input type="text" class="form-control" name="site_fb" placeholder="FB"  value="<?php echo @$record->site_facebook_url;?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Site Twitter :</label>
                    <input type="text" class="form-control" name="site_twitter" placeholder="Twitter"  value="<?php echo @$record->site_twitter_url;?>"> 
                </div>
                
                <div class="form-group col-md-4">
                    <label for="c-name">Site Insta :</label>
                    <input type="text" class="form-control" name="site_insta" placeholder="Insta"  value="<?php echo @$record->site_instagram_url;?>"> 
                </div>
                 
                <div class="form-group col-md-4 d-none">
                    <label for="c-name">Site Linkedin :</label>
                    <input type="text" class="form-control" name="site_linked" placeholder="Linked"  value="<?php echo @$record->site_linked;?>"> 
                </div>
                
                
                <div class="form-group col-md-12 ">
                    <label for="c-name">Privacy Policy :</label>
                    <textarea class="form-control summernote" name="privacy_policy"   ><?php echo @$record->privacy_policy?></textarea>
                </div>
                <div class="form-group col-md-12 ">
                    <label for="c-name">Exchange Return :</label>
                    <textarea class="form-control summernote" name="exchange_return"   ><?php echo @$record->exchange_return?></textarea>
                </div>
                <div class="form-group col-md-12 d-none">
                    <label for="c-name">Brands :</label>
                    <textarea class="form-control summernote" name="brands"   ><?php echo @$record->brands?></textarea>
                </div>
                <div class="form-group col-md-12 d-none">
                    <label for="c-name">Products :</label>
                    <textarea class="form-control summernote" name="products"   ><?php echo @$record->products?></textarea>
                </div>
                <div class="form-group col-md-12 d-none">
                    <label for="c-name">Categories :</label>
                    <textarea class="form-control summernote" name="categories"   ><?php echo @$record->categories?></textarea>
                </div>
                <div class="form-group col-md-12 d-none">
                    <label for="c-name">Enquiry :</label>
                    <textarea class="form-control summernote" name="enquiry"   ><?php echo @$record->enquiry?></textarea>
                </div>
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
      site_name: {
        required: true,
      }  
      
    },
    messages: {
      site_name: {
        required: "Please enter a Site Name",
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
	    		url:'<?php echo base_url('admin/siteconfiguration/add') ?>',
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
                        //window.location = "<?php //echo base_url().'admin1/category'?>";
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
                        window.location = "<?php echo base_url().'/admin/siteconfiguration'?>";
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
                        //window.location = "<?php //echo base_url().'admin1/category'?>";
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