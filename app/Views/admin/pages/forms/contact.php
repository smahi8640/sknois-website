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
<?php $this->db = \Config\Database::connect();?>
 
  
    <form action="<?php echo base_url(''); ?>admin/articles" id="records-list-form" class="records-list-form" method="post" accept-charset="utf-8">
    <div class="card">
        <div class="card-body">
            <?php if(!empty($records)) { ?>
            <table id="example2" class="table table-bordered table-hover datalist-table" >
                <thead class="bg-light">
                <tr>
                    <th scope="col" class="border-0">Name</th>
                    <th scope="col" class="border-0">Email</th>
                    <th scope="col" class="border-0">Mobile</th>
                    <th scope="col" class="border-0">Date</th>
                    <th scope="col" class="border-0  text-center"  data-orderable="false" >Action</th>
                </tr>
                </thead>
                <tbody>
                <?php  foreach($records as $data) { ?>
                    <tr>
                        <td><?php echo $data->name; ?></td>
                        <td><?php echo $data->email; ?></td>
                        <td><?php echo $data->mobile; ?></td>
                        <td><?php echo $data->created_at; ?></td>
                        <td class="text-center">
                            <a href="#" data-toggle="modal" data-target="#modal-default<?php echo $data->id; ?>" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                            <a href="javascript:;" class="btn btn-sm btn-danger"><i class="fas fa-trash dlt-item" data-id="<?php echo $data->id;?>"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
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

       

 <?= $this->include('admin/partial/footer') ?>

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>
<?php  foreach($records as $data) { ?>
<div class="modal fade" id="modal-default<?php echo $data->id; ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Contact</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                    <div class="modal-body">
                       <div class="row">
                           <div class="form-group col-md-6">
                                <label for="c-name">Name :</label>
                                <input type="text" class="form-control" name="name" placeholder="Name"  id="name" value="<?php echo $data->name; ?>"> 
                            </div>
                            <div class="form-group col-md-6">
                                <label for="c-name">Email :</label>
                                <input type="text" class="form-control" name="email" placeholder="Email"  id="email" value="<?php echo $data->email; ?>"> 
                            </div>
                            <div class="form-group col-md-6">
                                <label for="c-name">Mobile :</label>
                                <input type="text" class="form-control" name="mobile" placeholder="Mobile"  id="mobile" value="<?php echo $data->mobile; ?>"> 
                            </div>
                            <div class="form-group col-md-6">
                                <label for="c-name">Subject :</label>
                                <input type="text" class="form-control" name="subject" placeholder="Subject"  id="subject" value="<?php echo $data->subject; ?>"> 
                            </div>
                            <div class="form-group col-md-12">
                                <label for="c-name">Description :</label>
                                <textarea class="form-control" name="description" placeholder="Description"  id="description"><?php echo $data->description; ?> </textarea>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php }?>


<?= $this->include('admin/partial/js') ?>

<script type="text/javascript">
    
    $(document).ready(function () {
        
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true
         
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
                url:'<?php echo base_url().'/admin/forms/delete_contact'?>',
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
                    window.location = "<?php echo base_url().'/admin/forms/contact'?>";
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
    
});
</script>
</body>
</html>