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
  
    <form action="<?php echo base_url(''); ?>/admin/products_set" id="records-list-form" class="records-list-form" method="post" accept-charset="utf-8">
    <input type="hidden" name="task" value="" />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-12">       
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="<?php echo base_url('admin/products_set/edit');?>" class="btn btn-success">New</a>
                            <button type="button" class="btn px-3 btn-settask btn-danger btn-delete text-uppercase" task-action="delete">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
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
                                <th scope="col" class="border-top-0 border-bottom-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="checkall-toggle" value="" id="checkAll" class="custom-control-input" />
                                        <label for="checkAll" class="custom-control-label"></label>
                                    </div>
                                </th>
                                <th scope="col" class="border-top-0 border-bottom-0">Image</th>
                                <th scope="col" class="border-top-0 border-bottom-0">Title</th>
                                <th scope="col" class="border-top-0 border-bottom-0">Style No</th>
                                <th scope="col" class="border-top-0 border-bottom-0">Status</th>
                                <th scope="col" class="border-top-0 border-bottom-0 text-center" width="10%">Action</th>
                            </tr>
                            </thead>
                        <tbody>
                            <?php $i = 1; foreach($records as $data) { 
                                //$main = json_decode($data['image']);
                            ?>
                                <tr>   
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="record_id[]" value="<?= $data['id']; ?>" id="record_id<?= $data['id']; ?>" class="custom-control-input" />
                                            <label for="record_id<?= $data['id']; ?>" class="custom-control-label"></label>
                                        </div>
                                    </td> 
                                    <td>
                                        <img src="<?php echo base_url('media/source/'.$data['intro_image']) ;?>" height="60px" />
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('admin/products_set/edit/'.$data['id']) ;?>" ><?php echo $data['title']; ?></a>
                                        <small class="d-block">(Alias : <?php echo $data['alias']; ?>)</small>
                                    </td>
                                    
                                    <td>
                                        <?php echo $data['style_no']; ?>
                                    </td>
                                     <td class="text-center">
                                            <?php // ($data['status']=="1")?"Published":"UnPublished"?>
                                            <?php if($data['status'] == "1") { ?>
                                                <a class="btn btn-sm btn-success" href="<?= site_url('admin/products_set/unpublish/'.$data['id']); ?>"><i class="far fa-check-circle"></i></a>
                                            <?php } else { ?>
                                                <a class="btn btn-sm btn-danger" href="<?= site_url('admin/products_set/publish/'.$data['id']); ?>"><i class="far fa-times-circle"></i></a>
                                            <?php } ?>
                                        </td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url('/admin/products_set/edit/'.$data['id']);?>" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:;" class="btn btn-sm btn-danger"><i class="fas fa-trash dlt-item" data-id="<?php echo $data['id'];?>"></i></a>
                                    
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
        
        $("#checkAll").click(function () {
            $('#records-list-form input:checkbox').not(this).prop('checked', this.checked);
        });

        
        $('.btn-settask').on('click', function() {

            var dataCount = 1;
            if ($('#example2 input[type="checkbox"]:checked').length != 0 && dataCount != 0) {
                
                var buttontask = $(this).attr('task-action'); 
                
                if(buttontask == 'delete') {
                    var alertTitle = "Are you sure?";
                    var alertText = "Once deleted, you will not be able to recover this data!";
                }
                swal({
                    title: alertTitle,
                    text: alertText,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willConfirm) => {
                    if (willConfirm) {              
                        $('input[name="task"]').val(buttontask);
                        $('#records-list-form').submit();
                    } else {
                    
                    }
                });
            
            } else {
            
                swal("Please select checkbox.");
                
            }        

        });
        
        
        $('#example2').DataTable({
          "paging": true,
          "pageLength": 200,
          "lengthChange": true,
          "lengthMenu": [ [200, 400, 800, -1], [200, 400, 800, "All"] ],
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
                url:'<?php echo base_url().'/admin/products_set/delete'?>',
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
                    window.location = "<?php echo base_url().'/admin/products_set'?>";
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
