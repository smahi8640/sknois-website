<?php $refer= @$_SERVER['HTTP_REFERER']; ?>
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
 
 <?php require_once(APPPATH.'views/admin1/partial/title.php'); 

 $ordercart_details = json_decode($order_details->order_details);

 $query = $this->db->get('settings_siteconfiguration');
$siteconfiguration = $query->row();
//print_r("hi".$siteconfiguration1);exit;
 ?>
 
      
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-12">       
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        View Order : <?php echo $order_details->order_number; ?>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
              </div>
            <div class="card-body">
                    <h3 class="text-center mb-4">ORDER</h3>
                    <h6>Order No. : <b><?php echo $order_details->order_number; ?></b></h6> 
                    <h6>Order Date: <?php echo $order_details->created_date; ?></h6>
                    <?php if($order_details->tracking_id !="null"){ ?>
                    <h6>Tracker ID : <b><?php echo $order_details->tracking_id; ?></b></h6>
                    <?php } ?>
                    <?php if($order_details->bank_ref_no !="null"){ ?>
                    <h6>bank Ref No. : <b><?php echo $order_details->bank_ref_no; ?></b></h6>
                    <?php } ?>
                    <?php if($order_details->payment_mode !="null"){ ?>
                    <h6>Payment Mode : <b><?php echo $order_details->payment_mode; ?></b></h6>
                    <?php } ?>
                    <?php if($order_details->failure_message !=""){ ?>
                    <h6>Failure Msg : <b><?php echo $order_details->failure_message; ?></b></h6>
                    <?php } ?>
                    <div class="form-row">
                        <div class="col-md-6">
                            <h6><i>Company Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Treasta LLC</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $siteconfiguration->site_address; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $siteconfiguration->site_email; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $siteconfiguration->site_contact_number; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php 
                        if(empty($customer_details)){
                            
                            $customer_details=$this->db->get_where('customers', array('user_id' => $order_details->user_id))->result();
                        }
                        ?>
                        <div class="col-md-6">
                            <h6><i>Customer Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th><?php echo $customer_details[0]->customer_firstname; ?> <?php echo $customer_details[0]->customer_lastname; ?></th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $customer_details[0]->customer_address; ?> </br>
                                        <?php echo $customer_details[0]->customer_city; ?>-<?php echo $customer_details[0]->customer_pincode; ?><br/>
                                        <?php $this->db->select ('*');
                                    $this->db->where('id',$customer_details[0]->customer_state);
                                    $this->db->from('states');
                            		$sdata = $this->db->get()->row();
                            		
                            		$this->db->select ('*');
                                    $this->db->where('id',$customer_details[0]->customer_country);
                                    $this->db->from('countries');
                            		$cdata = $this->db->get()->row();
                            		?>
                                        <?php echo $sdata->name; ?>,<?php echo $cdata->name; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $customer_details[0]->customer_email; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $customer_details[0]->country_code." ".$customer_details[0]->customer_phonenumber; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <h6><i>Order Details</i></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Mrp</th>
                                <th>Discount</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php $grand_total = 0; $i = 1; foreach ($ordercart_details AS $order) { $grand_total =  $order->subtotal + $grand_total; 
                               
                                
                                ?>
                            <tr>
                                 <td><?php echo $i; ?></td>
                                <td><?php 
            					 if(file_exists(FCPATH."media/source/".$order->image)) { 
            							$img = base_url('media/source/').$order->image;
            						} else { 
            							$img = base_url('media/source/joyari-logo.png');
            						}
            					 ?>
            					     <img src="<?php echo $img;?>" height="160px" />
            					</td>
                               
                                <td>
                                    <?php echo $order->title; ?>
                                            <h6 class="mb-0 text-small"><small> 
                                            <?php  
                                                 
                                                 echo "SKU: ".$order->sku."<br/>"; 
                                                 //echo "Certificate Number: ".$product_detail->certificate_no."<br/>";
                                                 //echo "Lab Name: ".$product_detail->lab_name."<br/>";
                                                 
                                                 echo "Color: ".$order->color;
                                                 if(!empty($order->size) && $order->size!="-"){ 
                                                 echo " / "." Size: ".$order->size; 
                                                 }
                                                 if($order->type=="2"){
                                                     echo "<br/><span class='text-danger'><b>Made to order</b></span>";
                                                 }
                                                 
                                                 ?>
                                                 
                                                 </small></h6>
                                     
                                </td>
                                <td><?php echo $order->qty; ?></td>
                                <td><?php echo number_format($order->mrp, 2); ?></td>
                                <td><?php echo number_format($order->mrp-$order->price, 2); ?></td>
                                <td><?php echo number_format($order->price, 2); ?></td>
                                <td class="text-right"><?php echo number_format($order->qty*$order->price, 2); ?></td>
                                <td>
                                    <a href="#" class="btn btn-primary"><?php $this->db->where('id',$order->order_item_status);
                                    $status = $this->db->get('orderstatus')->row(); 
                                    echo $status->title;
                                    ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-<?php echo $order->id;?>"><i class="fas fa-edit dlt-item11" data-id="<?php echo $order->id;?>"></i></a>            
                                </td>
                            </tr>
                            <?php $i++; } ?>
                            <tr>
                                <td class="text-right" colspan="9">Net Total</td>
                                <td class="text-right"><?php echo number_format($order_details->final_amount, 2); ?></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="9">Shipping Charge</td>
                                <td class="text-right"><?php echo number_format($order_details->shipping,2); ?></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="9">Tax</td>
                                <td class="text-right"><?php echo number_format($order_details->tax,2); ?></td>
                            </tr>
                            <?php if($order_details->coupon_amount!="0"){ ?>
                            <tr>
                                <td class="text-right" colspan="9">Coupon Amount</td>
                                <td class="text-right"><?php echo number_format($order_details->coupon_amount,2); ?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td class="text-right" colspan="9">Grand Total</td>
                                <td class="text-right"><?php echo number_format($order_details->total_amount, 2); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-row"><div class="form-group col-md-6">Payment Method : <?php echo $order_details->payment_method; ?></div></div>
                   
                     
                </div>
                <div class="card-footer">
            <input type="hidden" name="id" value="<?php echo @$order_details->id;?>" />
            <!-- <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp;&nbsp;SAVE DATA</button>
            <a class="btn btn-danger" href="<?php //echo $refer;?>"><i class="fas fa-times" aria-hidden="true"></i>&nbsp;&nbsp;CLOSE</a>
            <button class="btn btn-warning" type="reset"><i class="fas fa-redo" aria-hidden="true"></i>&nbsp;&nbsp;RESET</button>
            <a href="<?php //echo site_url('admin1/orders/print/').$order_details->id; ?>" target="_blank" class="btn btn-primary">Print</a> -->
            
        </div>
    </div>   

    <?php  foreach ($ordercart_details AS $order) { ?>  
        <div class="modal fade" id="modal-<?php echo $order->id;?>" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="post" id="orderstatus" accept-charset="utf-8" action="">  
                <div class="modal-header">
                <h4 class="modal-title"><?php echo $order->title; ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                            <div class="form-group col-md-6">

                                <?php echo form_label('Order Status','order_status'); ?>
                                <?php
                                $options = array();
                                foreach ($orderstatus AS $orderstat) {
                                    $options[$orderstat->id] = $orderstat->title;
                                }
                                echo form_dropdown('order_status', $options, set_value('order_status', $order->order_item_status), 'class="custom-select"');
                                ?>
                                <?php echo form_error('order_status', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>

                            </div>
                            <div class="form-group col-md-6 d-none">
                                <?php echo form_label('Remarks','remarks'); ?>
                                <?php echo form_input('remarks', set_value('remarks'),'class="form-control"'); ?>
                            </div>
                    </div>   
                    <div class="form-row">
                        <div class="col-md-12">
                            <h4>Order Item History</h4>
                            <table id="datalist-table" class="table table-bordered mb-0 datalist-table">
                                <thead class="bg-light">
                                <tr>
                                    <th>
                                        Order Status 
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <!-- <th>
                                        Remarks
                                    </th> -->
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $this->db->where('order_item_id',$order->id);
                                    $status = $this->db->get('order_item_statuslogs')->result();
                                    $i = 1; 
                                    foreach($status as $statuss) {
                                    ?>
                                    <tr>
                                    <td>
                                        <?php $this->db->where('id',$statuss->status);
                                                $stat = $this->db->get('orderstatus')->row();
                                        echo $stat->title; ?>
                                    </td>
                                    <td>
                                        <?php echo $statuss->created_at;?>
                                    </td>
                                    <!-- <td>
                                        <?php //echo $statuss->remarks;?>
                                    </td> -->
                                </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer justify-content-between">   
                    <input type="hidden" name="order_number" value="<?php echo @$order_details->order_number;?>" />
                    <input type="hidden" name="order_item_id" value="<?php echo @$order->id;?>" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    
    <?php }?>
 <?php require_once(APPPATH.'views/admin1/partial/footer.php'); ?>

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>

<?php require_once(APPPATH.'views/admin1/partial/js.php'); ?>

<script>
$(document).ready( function() {

  
  //TOAST
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });  
      
  //Form Submit 
 $(document).on("submit","#orderstatus",function(e){
     
	    	e.preventDefault();
	    	$.ajax({
	    		url:'<?php echo base_url('admin1/orders/updatestatus') ?>',
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
                       window.location = "<?php echo base_url().'admin1/orders/edit/'?>"+obj.order_id;
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
                        //window.location = "<?php //echo base_url().'admin1/category'?>";
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