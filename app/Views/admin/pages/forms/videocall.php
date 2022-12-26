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
 
  
    <form action="<?php echo base_url(''); ?>admin1/articles" id="records-list-form" class="records-list-form" method="post" accept-charset="utf-8">
    <div class="card">
        <div class="card-body">
            <?php if(!empty($records)) { ?>
            <table id="example2" class="table table-bordered table-hover datalist-table" >
                <thead class="bg-light">
                <tr>
                    <th scope="col" class="border-0">Full Name</th>
                    <th scope="col" class="border-0">Mobile</th>
                    <th scope="col" class="border-0">Sku</th>
                    <th scope="col" class="border-0">Date</th>
                    <th width="20%" scope="col" class="border-0 text-center" data-orderable="false">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($records as $data) { ?>
                    <tr>
                        <td><?php echo $data->fullname; ?></td>
                        <td><?php echo $data->mobile; ?></td>
                        <td><?php 
                        $pid=explode(',',$data->product_details_id);
                        foreach($pid as $p){
                        $product_detail=$this->db->query("select * from product_details where id='".$p."'")->row();
                        $sku=$product_detail->sku.',';
                         echo $sku;
                        }
                        ?></td>
                        <td><?php echo $data->created_at; ?></td>
                        <td class="text-center">
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
                url:'<?php echo base_url().'admin1/forms/delete_videocall'?>',
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
                    window.location = "<?php echo base_url().'admin1/forms/videocall'?>";
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