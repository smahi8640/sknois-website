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

    <?= $this->include('admin/partial/title'); 
    $this->db      = \Config\Database::connect();
    ?> 
 
  
    <form action="<?php echo base_url(''); ?>admin1/orders" id="records-list-form" class="records-list-form" method="post" accept-charset="utf-8">
    
    <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mb-12">       
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?php if(!empty($records)) { ?>
                <button name="delete" disabled type="submit" id="submit_delete" class="btn btn-submit btn-danger" btn-task="delete">Delete</button>
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
	                  <th width="1%" scope="col" class="border-0 text-center">
	                  	<div class="custom-control custom-checkbox">
	                  		<input type="checkbox" id="checkAll" class="custom-control-input" name="checkall-toggle" value="" data-toggle="tooltip" data-placement="top" title="Check All Items" />
	                  		<label class="custom-control-label" for="checkAll"></label>
	                  	</div>
	                  </th>                  
	                  <th scope="col" class="border-0">Date</th>
	                   <th scope="col" class="border-0">Order Number</th>
	                    <th scope="col" class="border-0">Mode</th>
                       <th scope="col" class="border-0">Status</th> 
                      <th scope="col" class="border-0">Amount</th>
	                  <th width="25%" scope="col" class="border-0 text-center">Action</th>
	                </tr>
	              </thead>
	              <tbody>
	              	<?php $i = 1; foreach($records as $data) { ?>
	                <tr>
	                  <td class="text-center">
	                  	<div class="custom-control custom-checkbox">
	                  		<input type="checkbox" class="custom-control-input" id="record_id<?php echo $i; ?>" name="id[]" value="<?php echo $data->id; ?>" />
	                  		<label class="custom-control-label" for="record_id<?php echo $i; ?>"></label>
	                  	</div>
	                  </td>
					 
					 
					 <td><?php echo $data->created_date; ?></td>
					  <td><a href="<?php echo site_url('admin/orders/view/').$data->id;?>"><?php echo $data->order_number; ?></a><br/>
					  <?php $status =$this->db->query("select * from  customers where user_id='".$data->user_id."'")->getRow();
                             
                            echo $status->customer_firstname." ".$status->customer_lastname."-".$status->customer_phonenumber;
                            ?>
					  </td>
					  <td><?php echo $data->payment_method; ?></td>
					 <td><?php  $status = $this->db->query("select * from orderstatus where id='".$data->order_status."'")->getRow();
                            //$status = $this->db->get('orderstatus')->getRow(); 
                            echo $status->title;
                            ?></td> 
                     
                      <td class="text-center"><?php $tot=$data->total_amount; echo number_format($tot, 2); ?></td>
	                  <td class="text-center">
                    <a href="<?php echo site_url('admin/orders/edit/').$data->id;?>" class="btn btn-sm btn-warning d-none" title="Edit"><i class="fas fa-edit"></i></a>
	                    <a href="<?php echo site_url('admin/orders/view/').$data->id;?>" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="javascript:;" class="btn btn-sm btn-danger d-none"><i class="fas fa-trash dlt-item11" data-id="<?php echo $data->id;?>"></i></a>
                        <!-- <a href="<?php echo site_url('admin1/orders/print/').$data->id;?>" target="_blank" class="btn btn-sm btn-primary" title="Print"><i class="fas fa-print"></i></a>  -->
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
    </div>
    </div>
    </form>

       

  <?= $this->include('admin/partial/footer') ?> 

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>

<?= $this->include('admin/partial/js') ?>

<script type="text/javascript">
    
    $(document).ready(function () {
        
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false,
          "responsive": true
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
                url:'<?php echo base_url().'admin1/orders/delete'?>',
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
                    window.location = "<?php echo base_url().'admin1/orders'?>";
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
    
var buttonpressed;
$('.btn-submit').click(function() {
          buttonpressed = $(this).attr('name')
    })
        
$(document).on("submit","#records-list-form",function(e){
    e.preventDefault();
var dataCount = <?php echo count($records); ?>;
 if ($('.datalist-table input[type="checkbox"]:checked').length != 0 && dataCount != 0) {
    swal({
      title: "Are you sure?",
      text: "You want to delete record!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) { 
            if(buttonpressed=='delete'){
        	    $.ajax({
	    		url:'<?php echo base_url('admin1/orders/delete') ?>',
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
                        window.location = "<?php echo base_url().'admin1/orders'?>";
                    });
           
                },1000); 
	    			$("#mab1").hide();
	    				//toastr.success('Sent successfully.');	
	    			}
	    		}
	    	})
            }
            } else {
                    swal("Your record is safe!");
                }
        });
    } else {

                swal("Please select checkbox.");
            }
    
    })	    
        

    });
</script>
</body>
</html>