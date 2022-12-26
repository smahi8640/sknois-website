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
  
    <form action="<?php echo base_url(''); ?>admin1/articles" id="records-list-form" class="records-list-form" method="post" accept-charset="utf-8">
    <div class="card">
        <div class="card-body">
            <?php if(!empty($records)) { ?>
            <table id="example2" class="table table-bordered table-hover datalist-table" >
                <thead class="bg-light">
                <tr>
                    <th scope="col" class="border-0">Email</th>
                    <th scope="col" class="border-0">Date</th>
                    <th scope="col" class="border-0 text-center" data-orderable="false">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php  foreach($records as $data) { ?>
                    <tr>
                        <td><?php echo $data['email_address']; ?></td>
                        <td><?php echo $data['created_date']; ?></td>
                        <td class="text-center">
                           <a href="javascript:;" class="btn btn-sm btn-danger"><i class="fas fa-trash dlt-item" data-id="<?php echo $data['id'];?>"></i></a>
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
        ],
        dom: 'Bfrtip',
        buttons: ['excel']
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
                url:'<?php echo base_url().'/admin/forms/delete_subscribers'?>',
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
                    window.location = "<?php echo base_url().'/admin/forms/subscribers'?>";
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