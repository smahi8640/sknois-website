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
 
  
    
    <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 mb-6">    
     <div class="card collapsed-card">
        <div class="card-header">
            <h3 class="card-title">  
                <a href="<?php echo site_url('admin1/pincode/export');?>" class="btn btn-success">Export Data</a>
            </h3>
        	<div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form id="import">  
            <div class="row">
            <div class="form-group col-md-6">
                <input type="file" name="file">
            </div>
    		<div class="col-md-6">
    		    <button name="active" type="submit" id="submit_import" class="btn btn-submit btn-info" btn-task="status" >Import Data</button>	
    		</div>
    		</div>
    		</form>
		</div>  
	</div>
	</div>
	</div>
    <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mb-12">       
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?php if(!empty($records)) { ?>
                <button name="delete" type="submit" id="submit_delete" class="btn btn-submit btn-danger" btn-task="delete">Delete All</button>
                <?php } ?>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
       </div>
        <div class="card-body">
                    <?php if(!empty($records)) { ?>
                        <table id="example2" class="table table-bordered table-hover datalist-table" >
                            <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">Pincode</th>
                                <th scope="col" class="border-0">City</th>
                                <th scope="col" class="border-0">State</th>
                                <th scope="col" class="border-0">Delivery Days</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; foreach($records as $data) { ?>
                                <tr>
                                    <td><?php echo $data->code; ?></td>
                                    <td><?php echo $data->city; ?></td>
                                    <td><?php echo $data->state; ?></td>
                                    <td><?php echo $data->delivery_days; ?></td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                       <?php } else { ?>
            <div class="alert alert-info alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-info"></i> Alert!</h5>
              No Records Found
            </div>
            <?php } ?>
        </div>
    </div>   
    </div>
    </div>

 <?php require_once(APPPATH.'views/admin1/partial/footer.php'); ?>

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>

<?php require_once(APPPATH.'views/admin1/partial/js.php'); ?>

<script type="text/javascript">
    
    $(document).ready(function () {
        
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          columnDefs: [  
            {
            targets: [ 3 ],
            sortable: false
            }
        ]
        });

        
     
//TOAST
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });  
    
    //Delete
    $(document).on("click","#submit_delete",function(){
    var id = $(this).attr('data-id');
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url:'<?php echo base_url().'admin1/pincode/deleteall'?>',
                method:"POST",
                data:{id:id},
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
                    window.location = "<?php echo base_url().'admin1/pincode'?>";
                });
       
            },1000); 
                }
                }
            })
        } else {
            swal("Your record is safe!");
        }
    });
    })
    
    //Import
    $(document).on("submit","#import",function(e){
	    	e.preventDefault();
	    	$.ajax({
	    		url:'<?php echo base_url().'admin1/pincode/import'?>',
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
	    			if(obj.status){
	    				setTimeout(function(){
                        Toast.fire({
                        icon: 'success',
                        title: obj.message
                      }).then(function() {
                        window.location = "<?php echo base_url().'admin1/pincode'?>";
                    });
           
                },1000); 
	    			$("#mab1").hide();
	    				//toastr.success('Sent successfully.');	
	    			}
	    		}
	    	})
	    })

    });
</script>
</body>
</html>