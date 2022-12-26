<!DOCTYPE html>
<html lang="en">
<head>

  <?= $this->include('admin/partial/head') ?>

</head>
<body class="overlay-wrapper hold-transition sidebar-mini layout-fixed">
<div class="overlay" id="mab1" style="display:none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
<div class="wrapper">

  <?= $this->include('admin/partial/top') ?>

  <?= $this->include('admin/partial/sidemenu') ?>

  <?= $this->include('admin/partial/title') ?>
         
<div class="row">
              <!-- <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Enquiry</h3>
    	                    <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
    	               </div>
                        <div class="card-body">
                          <?php //echo $enquiry->counts; ?>                         </div>
                    </div>
              </div> -->
              
            <!--   <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Subscription</h3>
    	                    <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
    	               </div>
                        <div class="card-body">
                          <?php echo $subscription->counts; ?>                         </div>
                    </div>
              </div>
               -->
              <!-- <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Brands</h3>
    	                    <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
    	               </div>
                        <div class="card-body">
                         <?php //echo $brands->counts; ?>                        </div>
                    </div>
              </div> -->
              
              <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
    	                    <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
    	               </div>
                        <div class="card-body">
                         <?php echo $products->counts; ?>                             </div>
                    </div>
              </div>
              
              
        </div>
        <!--<div class="row">
	           <div class="col-lg-12 mb-4">
	               <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Latest Orders</h3>
    	                    <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
    	               </div>
                        <div class="card-body">
                        <?php if(!empty($orders)) { ?>
                          <table class="table table-bordered table-hover dataTable dtr-inline">
                            <thead class="py-2 bg-light text-semibold border-bottom">
                              <tr>
                                <th>Details</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Total</th>
                                <th class="text-right">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orders as $order){ 
                                $status=$this->db->query("select * from orderstatus where id='".$order->order_status."'")->row();
                                ?>
                              <tr>
                                
                                <td class="lo-stats__order-details">
                                  <span>#<?php echo $order->order_number; ?></span>
                                  <span><?php echo $order->created_date; ?></span>
                                </td>
                                <td class="lo-stats__status">
                                  <div class="d-table mx-auto">
                                     <?php if($order->order_status=="7"){?>
                                    <span class="badge badge-pill badge-success"><?php echo $status->title; ?></span>
                                    <?php } else if($order->order_status=="7") {?>
                                    <span class="badge badge-pill badge-danger"><?php echo $status->title; ?></span>
                                    <?php } else { ?>
                                     <span class="badge badge-pill badge-warning"><?php echo $status->title; ?></span>
                                     <?php }?>
                                  </div>
                                </td>
                                <td class="lo-stats__total text-center text-success"><?php $tot=$order->total_amount+$order->shipping; echo number_format($tot, 2); ?></td>
                                <td class="lo-stats__actions">
                                  <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                    <a href="<?php echo base_url('admin/orders/view/').$order->id; ?>" type="button" class="btn btn-sm btn-white">View</a>
                                  </div>
                                </td>
                              </tr>
                              <?php }?>
                              
                            </tbody>
                          </table>
                          <?php }else{ ?>
                              <div class="alert alert-info alert-dismissible">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                  <h5><i class="icon fas fa-info"></i> Alert!</h5>
                                  No Records Found
                                </div>
                          <?php }?>
                        </div>
                        <div class="card-footer">
                            <a href="#">View all orders →</a>
                        </div>
                    </div>
               </div>
               
            </div>        -->
  
  <?= $this->include('admin/partial/footer') ?>

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>

<?= $this->include('admin/partial/js') ?>
	  
</body>
</html>