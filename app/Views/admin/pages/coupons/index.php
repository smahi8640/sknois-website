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
 
  
    <form action="<?php echo base_url(''); ?>admin1/coupons" id="records-list-form" class="records-list-form" method="post" accept-charset="utf-8">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="<?php echo site_url('admin1/coupons/view');?>" class="btn btn-success">New</a>
                <?php if(!empty($records)) { ?>
                <button name="submit" type="submit" id="submit_delete" class="btn btn-submit btn-danger" btn-task="delete">Delete</button>
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
                    <thead>
	                <tr>
	                  <th width="1%" scope="col"  class="border-0 text-center">
	                  	<div class="custom-control custom-checkbox">
	                  		<input type="checkbox" id="checkAll" class="custom-control-input" name="checkall-toggle" value="" data-toggle="tooltip" data-placement="top" title="Check All Items" />
	                  		<label class="custom-control-label" for="checkAll"></label>
	                  	</div>
	                  </th>                  
	                  <th scope="col" class="border-0">Title</th>
	                  <th width="20%" scope="col" class="border-0 text-center">Action</th>
	                </tr>
	              </thead>
	              <tbody>
	              	<?php $i = 1; foreach($records as $data) { ?>
	                <tr>
	                  <td class="text-center" >
	                  	<div class="custom-control custom-checkbox">
	                  		<input type="checkbox" class="custom-control-input" id="record_id<?php echo $i; ?>" name="id[]" value="<?php echo $data->id; ?>" />
	                  		<label class="custom-control-label" for="record_id<?php echo $i; ?>"></label>
	                  	</div>
	                  </td>
					 <td><a href="<?php echo site_url('admin1/coupons/view/').$data->id;?>" ><?php echo $data->title; ?></a></td>
	                  <td class="text-center">
                        <a href="<?php echo site_url('admin1/coupons/view/').$data->id;?>" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo site_url('admin1/coupons/used/').$data->id;?>" class="btn btn-sm btn-success" title="Used"><i class="fas fa-eye"></i></a>
                        <a href="javascript:;" class="btn btn-sm btn-danger"><i class="fas fa-trash dlt-item" data-id="<?php echo $data->id;?>"></i></a>
                    </td>
	                  
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
    </form>

       

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
            targets: [ 0 ],
            sortable: false
            },
            {
            targets: [ 2 ],
            sortable: false
            }
        ]
        });

        $("#checkAll").click(function () {
            $('.datalist-table input:checkbox').not(this).prop('checked', this.checked);
        });

     
//TOAST
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });  
    
    //Delete
    $(document).on("click",".dlt-item",function(){
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
                url:'<?php echo base_url().'admin1/coupons/delete'?>',
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
                    window.location = "<?php echo base_url().'admin1/coupons'?>";
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
    
$(document).on("submit","#records-list-form",function(e){
    e.preventDefault();
var dataCount = <?php echo count($records); ?>;
 if ($('.datalist-table input[type="checkbox"]:checked').length != 0 && dataCount != 0) {
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) { 
        	    $.ajax({
	    		url:'<?php echo base_url('admin1/coupons/delete') ?>',
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
                        window.location = "<?php echo base_url().'admin1/coupons'?>";
                    });
           
                },1000); 
	    			$("#mab1").hide();
	    				//toastr.success('Sent successfully.');	
	    			}
	    		}
	    	})
        	  
            } else {
                    swal("Your record is safe!");
                }
        });
    } else {

                swal("Please select checkbox.");
            }
    
    })	    
        /*jQuery('.btn-clear').click( function() {
                        
            jQuery('select[name="filter[status]"]').val('');
            jQuery('select[name="filter[articles_id]"]').val('');
            jQuery('#group-list-form').submit();
            
        });*/

    });
</script>
</body>
</html>