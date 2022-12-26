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
        <div class="card-body">
            <?php if(!empty($records)) { ?>
	            <table id="example2" class="table table-bordered table-hover datalist-table" >
                    <thead>
	                <tr>
	                                 
	                  <th width="1%" hidden scope="col" class="border-0 text-center">ID</th>
	                  <th scope="col" class="border-0">Coupon Code</th>
	                  <th scope="col" class="border-0">Order Number</th>
	                  <th scope="col" class="border-0">Coupon Amount</th>
	                </tr>
	              </thead>
	              <tbody>
	              	<?php $i = 1; foreach($records as $data) { ?>
	                <tr>
	                  
					  <td hidden class="text-center"><?php echo $data->id; ?></td>
                      <td>
                            <?php echo $data->coupon_code; ?>
                      </td>
					  <td>
                            <?php echo $data->order_number; ?>
                      </td>
                       <td>
                            <?php echo $data->coupon_amount; ?>
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

</body>
</html>