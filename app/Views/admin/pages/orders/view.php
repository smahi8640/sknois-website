<?php $refer= @$_SERVER['HTTP_REFERER']; ?>
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
    
    $siteconfiguration=$this->db->query("select * from settings_siteconfiguration")->getRow();
    ?> 
 
  
    <form id="records-list-form" class="records-list-form" method="post" accept-charset="utf-8">
    
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-12">       
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        View Order : <?php echo $record->order_number; ?>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
              </div>
            <div class="card-body">
                    <h3 class="text-center mb-4">ORDER</h3>
                    <h6>
                    Status : 
                        <?php $status = $this->db->query("select * from orderstatus where id='".$record->order_status."'")->getRow(); ?>
                        <label class="text text-<?= ($status->title=='Approved')?"success":"danger"; ?>">
                           <?php  echo $status->title; ?>
                        </label>
                    </h6>
                    <h6>Order No. : <b><?php echo $record->order_number; ?></b></h6> 
                    <h6>Order Date: <?php echo $record->created_date; ?></h6>
                    <div class="form-row"><div class="form-group col-md-6">Payment Method : <?php echo $record->payment_method; ?></div></div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <h6><i>Company Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Joyari</th>
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
                            
                            $customer_details=$this->db->query("select * from  customers where user_id='".$record->user_id."'")->getResult();
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
                                        <?php 
                            		$sdata = $this->db->query("select * from  states where id='".$customer_details[0]->customer_state."'")->getRow();
                            		
                            		$cdata = $this->db->query("select * from  countries where id='".$customer_details[0]->customer_country."'")->getRow();
                            		
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
                            </tr>
                            <?php $grand_total = 0; $i = 1; 
                            $ordercart_details=json_decode($record->order_details);
                            foreach ($ordercart_details AS $order) { $grand_total =  $order->price + $grand_total; 
                                $product=$this->db->query("select * from products where id='".$order->product_id."'")->getRowArray();
                                ?>
                            <tr>
                                 <td><?php echo $i; ?></td>
                                <td><?php 
            					 if(file_exists(FCPATH."media/source/".$order->image)) { 
            							$img = base_url('media/source/').'/'.$order->image;
            						} else { 
            							$img = base_url('media/source/joyari-logo.png');
            						}
            					 ?>
            					     <img src="<?php echo $img;?>" height="160px" />
            					</td>
                               
                                <td>
                                    <?php echo $order->title; ?><br>
                                    Style : <?= $product['style_no']; ?>
                                            <h6 class="mb-0 text-small"><small> 
                                            <?php  
                                                 if($order->types!='3'){
                                                 echo "SKU: ".$order->sku."<br/>"; 
                                                 //echo "Certificate Number: ".$product_detail->certificate_no."<br/>";
                                                 //echo "Lab Name: ".$product_detail->lab_name."<br/>";
                                                 
                                                 echo "Color: ".$order->color;
                                                 if(!empty($order->size) && $order->size!="-"){ 
                                                 echo " / "." Size: ".$order->size; 
                                                 }
                                                 echo "/ Purity: ".$order->purity;
                                                 if($order->types=="2"){
                                                     echo "<br/><span class='text-danger'><b>Made to order</b></span>";
                                                 }
                                                 }else{
                                                     $productset=json_decode($order->set_product_json);
                                                     foreach($productset as $l){ 
                                                          echo "-----<br/>";
                                                         echo "Name: ".$l->name."<br/>";
                                                         echo "Sku: ".$l->sku."<br/> ";
                                                         echo "Color: ".$l->color." / ";
                                                         if(!empty($l->size) && $l->size!="-"){ 
                                                            echo "Size: ".$l->size." / ";
                                                         }
                                                         echo "Purity: ".$l->purity."<br/> ";
                                                         
                                                        
                                                     }
                                                      echo "<br/><span class='text-danger'><b>Made to order</b></span>";
                                                 }
                                                 ?>
                                                 
                                                 </small></h6>
                                     
                                </td>
                                <td><?php echo $order->qty; ?></td>
                                <td>$<?php echo number_format($order->mrp, 2); ?></td>
                                <td><?php echo number_format($order->mrp-$order->price, 2); ?></td>
                                <td>$<?php echo number_format($order->price, 2); ?></td>
                                <td class="text-right">$<?php echo number_format($order->qty*$order->price, 2); ?></td>
                            </tr>
                            <?php $i++; } ?>
                            <tr>
                                <td class="text-right" colspan="7">Net Total</td>
                                <td class="text-right">$<?php echo number_format($record->final_amount, 2); ?></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="7">Shipping Charge</td>
                                <td class="text-right">$<?php echo number_format($record->shipping,2); ?></td>
                            </tr>
                            <!--<tr>
                                <td class="text-right" colspan="7">Tax</td>
                                <td class="text-right"><?php //echo number_format($record->tax,2); ?></td>
                            </tr>-->
                            <?php if($record->coupon_amount!="0"){ ?>
                            <tr>
                                <td class="text-right" colspan="7">Coupon Amount</td>
                                <td class="text-right"><?php echo number_format($record->coupon_amount,2); ?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td class="text-right" colspan="7">Grand Total</td>
                                <td class="text-right">$<?php echo number_format($record->total_amount, 2); ?></td>
                            </tr>
                        </table>
                    </div>
                    
                     <div class="form-row d-none">
                        <div class="form-group col-md-6">

                            <?php echo form_label('Order Status','order_status'); ?>
                            <?php
                            $orderstatus=$this->db->query("select * from orderstatus")->getResult();
                            $options = array();
                            foreach ($orderstatus AS $orderstat) {
                                $options[$orderstat->id] = $orderstat->title;
                            }
                            echo form_dropdown('order_status', $options, set_value('order_status', $record->order_status), 'class="custom-select"');
                            ?>

                        </div>
                            <div class="form-group col-md-6">
                                <?php echo form_label('Remarks','remarks'); ?>
                                <?php echo form_input('remarks', set_value('remarks'),'class="form-control"'); ?>
                            </div>
                    </div>
                    <div class="form-row d-none">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo form_label('Message','order_message'); ?>
                                <?php echo form_textarea('order_message', set_value('order_message'),'class="form-control"'); ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-row d-none">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-1">
                                    <input type="checkbox" class="custom-control-input" name="notify_email" value="1" id="notify_email" />
                                    <label class="custom-control-label" for="notify_email">Notify by email</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-1">
                                    <input type="checkbox" class="custom-control-input" name="notify_sms" value="1" id="notify_sms" />
                                    <label class="custom-control-label" for="notify_sms">Notify by SMS</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                     <div class="form-row d-none">
                        <div class="col-md-12">
                            <h4>Order History</h4>
                            <table id="datalist-table" class="table table-bordered mb-0 datalist-table">
            	              <thead class="bg-light">
            	                <tr>
            	                    <th>
            	                       Order Status 
            	                    </th>
            	                    <th>
            	                       Date
            	                    </th>
            	                    <th>
            	                       Remarks
            	                    </th>
            	                </tr>
            	                </thead>
	                            <tbody>
	                                <?php 
                                    $status = $this->db->query("select * from ordersstatus_logs where order_id='".$record->id."'")->getResult();
                                    $i = 1; 
                                    foreach($status as $statuss) {
                                    ?>
            	                  <tr>
            	                    <td>
            	                        <?php 
                                              $stat = $this->db->query("select * from orderstatus where id='".$statuss->order_status."'")->getRow();
            	                        echo $stat->title; ?>
            	                    </td>
            	                    <td>
            	                       <?php echo $statuss->created_date;?>
            	                    </td>
            	                    <td>
            	                       <?php echo $statuss->remarks;?>
            	                    </td>
            	                </tr>
            	                <?php }?>
            	              </tbody>
            	            </table>
                        </div>
                    </div>  
                </div>
            <div class="card-footer">
            <input type="hidden" name="id" value="<?php echo @$record->id;?>" />
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp;&nbsp;SAVE DATA</button>
            <a class="btn btn-danger" href="<?php echo $refer;?>"><i class="fas fa-times" aria-hidden="true"></i>&nbsp;&nbsp;CLOSE</a>
            <button class="btn btn-warning" type="reset"><i class="fas fa-redo" aria-hidden="true"></i>&nbsp;&nbsp;RESET</button>
            <a href="<?php echo site_url('admin/orders/print/').$record->order_number; ?>" target="_blank" class="btn btn-primary">Print</a>
            
        </div>
    </div> 
    </div> 
    </div> 
    </form>

       

 
    

  <?= $this->include('admin/partial/footer') ?> 

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>
</div>
<?= $this->include('admin/partial/js') ?>

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
 $(document).on("submit","#records-list-form",function(e){
	    	e.preventDefault();
	    	$.ajax({
	    		url:'<?php echo base_url('admin1/orders/view') ?>',
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
                       //window.location = "<?php //echo base_url().'admin1/orders/view'?>";
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