<?php
$ordercart_details = json_decode($order_details->order_details);
?>
<h3  style="text-align:center">ORDER</h3>
<table class="table table-bordered" width="100%">
    <tr>
                    <td align="left">Order No. : <b><?php echo $order_details->order_number; ?></b></td>
                    
                    <td align="right">Order Date: <b><?php echo $order_details->created_date; ?></b></td>
                    </tr>
                    <!--<tr>
                    <?php if($order_details->tracking_id !="null"){ ?>
                    <td>Tracker ID : <b><?php echo $order_details->tracking_id; ?></b></td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php if($order_details->bank_ref_no !="null"){ ?>
                    <td>bank Ref No. : <b><?php echo $order_details->bank_ref_no; ?></b></td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php if($order_details->payment_mode !="null"){ ?>
                    <td>Payment Mode : <b><?php echo $order_details->payment_mode; ?></b></td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php if($order_details->failure_message !=""){ ?>
                    <td>Failure Msg : <b><?php echo $order_details->failure_message; ?></b></td>
                    <?php } ?>
                    </tr>-->
                </table>  <hr>
                    <table class="table table-bordered"  width="100%">
                        <tr>
                        <td style="vertical-align:top" width="50%">
                            <table class="table table-bordered" width="100%">
                                <tr>
                                    <td><i>Company Details</i></td>
                                </tr>
                                    <tr>
                                        <td><b><?php echo $siteconfiguration->site_title; ?></b></td>
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
                           
                        </td>
                        <td width="50%">
                            <?php 
                        if(empty($customer_details)){
                            
                            $customer_details=$this->db->get_where('customers', array('order_id' => $order_details->order_id))->result();
                        }
                        ?>
                            <table class="table table-bordered" width="100%">
                                <tr>
                                <td><i>Customer Details</i></td>
                                </tr>
                                    <tr>
                                        <td><b><?php echo $customer_details[0]->customer_firstname; ?> <?php echo $customer_details[0]->customer_lastname; ?></b></td>
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
                            </td>
                            </tr>
                            </table><hr>
                        <b><i>Order Details</i></b>
                        <table class="table table-bordered" style="border-collapse: collapse;" border="1" width="100%">
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
                            <?php $grand_total = 0; $i = 1; foreach ($ordercart_details AS $order) { $grand_total =  $order->subtotal + $grand_total; ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php 
            					 if(file_exists(FCPATH."media/source/".$order->img)) { 
            							$img = base_url('media/source/').$order->img;
            						} else { 
            							$img = base_url('media/source/joyari-logo.png');
            						}
            					 ?>
            					     <img src="<?php echo $img;?>" height="100px" />
            					</td>
                                <td>
                                    <?php echo $order->name; ?>
                                    <h6 class="mb-0 text-small"><small> 
                                            <?php if($order->options->product_size){    
                                                 $product_detail=$this->db->query("select  * from product_details where id='".$order->options->product_size."'")->row();
                                                 echo "SKU: ".$product_detail->sku."<br/>";
                                                 echo "Certificate Number: ".$product_detail->certificate_no."<br/>";
                                                 echo "Lab Name: ".$product_detail->lab_name."<br/>";
                                                 if($product_detail->size!="" && $product_detail->size!="0"){  
                                                 echo "Size: ".$product_detail->size." / "; 
                                                 }
                                                 echo "Gross Wt: ".$product_detail->weight." gms<br/>";
                                                 }
                                                 ?>
                                                 <?php if($order->options->product_gold){    
                                                 $product_gold=$this->db->query("select  * from product_gold where id='".$order->options->product_gold."'")->row();
                                                 echo "Gold Metal:".$product_gold->purity." kt ".$product_gold->metal." / "; 
                                                 echo "Wt: ".$product_gold->weight." ".$product_gold->unit."<br/>";
                                                 }?>
                                                 <?php if($order->options->product_diamond){    
                                                 $product_diamond=$this->db->query("select  *,`color|clarity` as cc from product_diamond where id='".$order->options->product_diamond."'")->row();
                                                 echo "Diamond Color|Clarity:".$product_diamond->cc." / "; 
                                                 echo "Wt: ".$product_diamond->weight." ".$product_diamond->unit."<br/>";
                                                 }?>
                                                 <?php if($order->options->product_stone){    
                                                 $product_stone=$this->db->query("select  * from product_stone where id='".$order->options->product_stone."'")->row();
                                                 echo "Stone:".$product_stone->stone." / "; 
                                                 }?>
                                                 </small></h6>
                                </td>
                                <td><?php echo $order->qty; ?></td>
                                <td><?php echo number_format($order->product_mrp, 2); ?></td>
                                <td><?php echo number_format($order->product_mrp-$order->price, 2); ?></td>
                                <td><?php echo number_format($order->price, 2); ?></td>
                                <td style="text-align:right"><?php echo number_format($order->subtotal, 2); ?></td>
                            </tr>
                            <?php $i++; } ?>
                            <tr>
                                <td style="text-align:right" colspan="7">Net Total</td>
                                <td style="text-align:right"><?php echo number_format($order_details->final_amount, 2); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right" colspan="7">Shipping Charge</td>
                                <td style="text-align:right"><?php echo number_format($order_details->shipping,2); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right" colspan="7">Tax</td>
                                <td style="text-align:right"><?php echo number_format($order_details->tax,2); ?></td>
                            </tr>
                            <?php if($order_details->coupon_amount!="0"){ ?>
                            <tr>
                                <td style="text-align:right" colspan="7">Coupon Amount</td>
                                <td style="text-align:right"><?php echo number_format($order_details->coupon_amount,2); ?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td style="text-align:right" colspan="7">Grand Total</td>
                                <td style="text-align:right"><b><?php echo number_format($order_details->total_amount, 2); ?></b></td>
                            </tr>
                        </table>
                  <br/>
                 Amt in words <b><?php echo getIndianCurrency($order_details->total_amount) ?> only</b><br/>
                    Payment Method : <?php echo $order_details->payment_method; ?>
                    