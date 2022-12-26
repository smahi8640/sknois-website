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

  <form action="<?php echo base_url(''); ?>admin/categories" id="save-form" class="records-list-form formvalidate" method="post" accept-charset="utf-8">
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
				<div class="form-group col-md-6">
					<label for="c-name">Image :</label>
					<div class="input-group">
					  	<input class="form-control image_path" id="image" name="image" value="<?php echo @$record->image?>" required/>
					  	<div class="input-group-append">
						  	<a href="<?php echo base_url('assets/filemanager/dialog.php?type=1&field_id=image&relative_url=1'); ?>" data-fancybox-type="iframe" class="btn btn-default iframe-btn" type="button">Select</a>
					  	</div>
					  	<div class="uploaded_images input-group-append">  
						  	<?php if(!empty(@$record->images)) { ?>
								<div class="uploaded_image_ele">
							  		<img id="image-preview" style="max-height:100px;max-width:100px;" src="<?php echo base_url('media/source/'.@$record->images); ?>" data-attr="<?php echo  @$record->id; ?>" class="uploaded_image">
								</div>
						  	<?php } else { ?>
							  	<div class="uploaded_image_ele" id="div-preview"  style="display:none;">
									<img style="max-height:100px;max-width:100px;" src="#"  id="image-preview" class="uploaded_image">
							  	</div>
						  	<?php } ?>
					  	</div>
					</div>
				</div>
				<div class="form-group col-md-6">
                    <label for="c-name">Title :</label>
                    <input type="text" class="form-control" name="title" placeholder="Title"  value="<?php echo @$record->title; ?>"> 
                </div>
                <div class="form-group col-md-12">
                    <label for="c-name">Description :</label>
                    <textarea class="form-control" name="description" placeholder="Description" id="summernote"><?php echo @$record->description; ?></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="c-name">Display Order :</label>
                    <input type="number" class="form-control" name="display_order" placeholder="Display Order"  value="<?php echo @$record->display_order?>"> 
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
	  title1: {
		required: true,
	  }
	},
	messages: {
	  title1: {
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
				url:'<?php echo base_url('admin/homeslider/add') ?>',
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
						//window.location = "<?php //echo base_url().'admin1/categories'?>";
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
						window.location = "<?php echo base_url().'/admin/homeslider'?>";
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
						//window.location = "<?php //echo base_url().'admin1/categories'?>";
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
