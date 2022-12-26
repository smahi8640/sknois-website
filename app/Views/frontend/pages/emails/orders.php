<?php
$this->db = \Config\Database::connect();
$order_details=$this->db->query("select * from orders where order_number='".$order_number."'")->getRow();


$ordercart_details = json_decode($order_details->order_details);

$customer_details=$this->db->query("Select * from customers where order_id='".$order_details->id."'")->getResult();

$ordercart_details = json_decode($order_details->order_details);

$siteconfiguration = $this->db->query("select * from settings_siteconfiguration")->getResult();

$sdata = $this->db->query("select * from states where id='".$customer_details[0]->customer_state."'")->getRow();
    		
$cdata =$this->db->query("select * from countries where id='".$customer_details[0]->customer_country."'")->getRow();
?>
				<html lang="en">
				    <head>
				        <style>
				            .col-md-6{
				                width: 50%;
				                float: left;
				            }
				            h3 { font-size: 32px; text-align: center; margin: 0 0 20px; }
				            h6 {
                                font-size: 16px;
                                color: #3d5170;
                                margin: 0;
                                font-weight: 400;
                            }
                            .table th { font-weight: bold; }
                            b { font-weight: 500; }
                            .table td, .table th {
                                padding: .75rem;
                                font-size: 15px;
                                color: #5a6169;
                            }
                            .table {
                                width: 100%;
                                margin-bottom: 16px;
                                
                                text-align: left;
                            }
				            .table-bordered td, .table-bordered th {
                                border: 1px solid #dee2e6;
                            }
                        </style>
				    </head>
					<body>
                    <table border='0' width="100%">
                      <tr>
                            <th align="center"><img src="<?php echo base_url('media/source/'.'/'.$siteconfiguration[0]->site_logo); ?>" /></th>
                        </tr>
                    </table>                
                        <h3 class="text-center mb-4">ORDER</h3>
                        <h6>
                            Status : 
                            <?php $status = $this->db->query("select * from orderstatus where id='".$order_details->order_status."'")->getRow(); ?>
                            <label class="text text-<?= ($status->title=='Approved')?"success":"danger"; ?>">
                               <?php  echo $status->title; ?>
                            </label>
                        </h6>
                    <h6>Order No. : <b><?php echo $order_details->order_number ?></b></h6>
                    <h6>Order Date: <?php echo $order_details->created_date?></h6>
                    <h6>Payment Method : <?php echo $order_details->payment_method ?></h6>
                    <div class="form-row">
                        <div class="col-md-6">
                            <h6><i>Company Details</i></h6>
                            <div class="table-responsive"> 
                                <table class="table table-bordered">
                                  <tr>
                                        <th>Joyari</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $siteconfiguration[0]->site_address ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $siteconfiguration[0]->site_email ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $siteconfiguration[0]->site_contact_number ?></td>
                                    </tr> 
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><i>Customer Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th><?php echo $customer_details[0]->customer_firstname.' '.$customer_details[0]->customer_lastname ?></th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $customer_details[0]->customer_address.'</br>
                                        '.$customer_details[0]->customer_city.'-'.$customer_details[0]->customer_pincode.'<br/>
                                        '.$sdata->name.','.$cdata->name ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $customer_details[0]->customer_email ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $customer_details[0]->customer_phonenumber ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <h6><i>Order Details</i></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th width="40%">Product</th>
                                <th>Qty</th>
                                <th>MRP</th>
                                <th>Disc.</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                             <?php $i = 1; foreach ($ordercart_details AS $order) {  
                                $product=$this->db->query("select * from products where id='".$order->product_id."'")->getRowArray();
                             ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php 
            					 
            							$img = base_url('media/source/').'/'.$order->image;
            						
            					 ?>
            					     <img src="<?php echo $img;?>" height="160px" />
            					</td>
                                <td width="40%">
                                    <?php echo "".$order->title; ?><br/>
                                    Style : <?= $product['style_no']; ?>
                                            <h6 class="mb-0 text-small"><small> 
                                            <?php  
                                                 if($order->types!='3'){
                                                 echo "SKU: ".$order->sku."<br/>"; 
                                                 //echo "Certificate Number: ".$product_detail->certificate_no."<br/>";
                                                 //echo "Lab Name: ".$product_detail->lab_name."<br/>";
                                                 
                                                 echo "Color: ".$order->color." / ";
                                                 if(!empty($order->size) && $order->size!="-"){ 
                                                 echo " Size: ".$order->size." / "; 
                                                 }
                                                 echo "Purity: ".$order->purity;
                                                 if($order->types=="2"){
                                                     echo "<br/><span style='color:red'><b>Made to order</b></span>";
                                                 }
                                                 }else{
                                                     $productset=json_decode($order->set_product_json);
                                                     foreach($productset as $l){ 
                                                          echo "-----<br/>";
                                                         echo "Item: ".$l->name."<br/>";
                                                         echo "Sku: ".$l->sku."<br/>";
                                                         echo "Color: ".$l->color." / ";
                                                         if(!empty($l->size) && $l->size!="-"){ 
                                                            echo "Size: ".$l->size." / ";
                                                         }
                                                         echo "Purity: ".$l->purity."<br/> ";
                                                        
                                                     }
                                                     echo "<br/><span style='color:red'><b>Made to order</b></span>";
                                                 }
                                                 
                                                 ?>
                                                 
                                                 </small></h6>
                                     
                                </td>
                                <td><?php echo $order->qty; ?></td>
                                <td>$<?php echo number_format($order->mrp, 2); ?></td>
                                <td><?php echo number_format($order->mrp-$order->price, 2); ?></td>
                                <td>$<?php echo number_format($order->price, 2); ?></td>
                                <td class="text-right">$<?php echo number_format($order->price*$order->qty, 2); ?></td>
                            </tr>
                         <?php  $i++; }?>
                            <tr>
                                <td class="text-right" colspan="7">Net Total</td>
                                <td class="text-right">$<?php echo number_format($order_details->final_amount, 2); ?></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="7">Shipping Charge</td>
                                <td class="text-right">$<?php echo number_format($order_details->shipping,2); ?></td>
                            </tr>
                           
                            <?php if($order_details->coupon_amount!="0"){ ?>
                            <tr>
                                <td class="text-right" colspan="7">Coupon Amount</td>
                                <td class="text-right"><?php echo number_format($order_details->coupon_amount,2); ?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td class="text-right" colspan="7">Grand Total</td>
                                <td class="text-right">$<?php echo number_format($order_details->total_amount, 2); ?></td>
                            </tr>
                        </table>
                    </div>
                    <hr/>
                    <h5>APPROX DELIVERY :- WITHIN 21 BUSINESS DAYS</h5>
                    </div>
        </body>
    </html>