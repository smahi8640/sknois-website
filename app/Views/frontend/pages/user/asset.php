
 <main>
        <section class="order__history--block">
            <div class="container">
                <div class="row justify-content-center mb-3">
                    <div class="col-md-12 text-center">
                        <h1>Order History</h1>
                    </div>
                </div>
                <?php foreach ($records AS $record) { 
                $status=$this->db->query("select o.title from ordersstatus_logs ol left join orderstatus o on o.id=ol.order_status where ol.order_id='".$record->id."' order by ol.id desc limit 1")->row();
                ?>
                <?php $order_details = json_decode($record->order_details); ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="order__history__list">
                            <div class="order__history__item">
                                <div class="order__tracking order__history__header d-flex align-items-center justify-content-between">
                                    <h3 class="order__no">Order: <?php echo $record->order_number; ?> <span class="order__date"><?php echo date('d F Y', strtotime($record->created_date)); ?></span></h3>
                                    <a class=" btn btn-primary btn-sm mt-2" href="#" data-toggle=""><?php echo $status->title; ?></a>
                                    <h5 class="order__total">Total: ₹<?php echo $record->total_amount; ?></h5>
                                </div>
                                <?php foreach ($order_details AS $order_detail) { ?>
                                <?php if($order_detail->options->product_size){    
                                    $product_detail=$this->db->query("select  * from product_details where id='".$order_detail->options->product_size."'")->row(); }?>
                                <div class="order__history__body">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="order__details__main d-flex">
                                                <div class="order__img" style="background-image: url(<?php echo base_url('media/source/'.$order_detail->img); ?>)"></div>
                                                <div class="order__details__des">
                                                    <div class="order__details">
                                                        <h4 class="order__product__name"><?php echo htmlspecialchars_decode($order_detail->name); ?></h4>
                                                        <h5><?php echo $product_detail->description; ?></h5>
                                                        <p class="order__product__price">Price: <strong>₹<?php echo $order_detail->price; ?></strong></p>
                                                        <p class="order__product__qty">Quantity: <strong>1</strong></p>
                                                        <?php if($product_detail->size!="" && $product_detail->size!="0"){    
                                                              //$product_detail=$this->db->query("select  * from product_details where id='".$order_detail->options->product_size."'")->row(); ?>
                                                        <p class="order__product__size">Size: <strong><?php echo $product_detail->size; ?></strong></p>
                                                        <?php }if($order_detail->options->product_gold){ 
                                                              $product_gold=$this->db->query("select  * from product_gold where id='".$order_detail->options->product_gold."'")->row();?>
                                                        <p class="order__product__metal">Metal: <strong><?php echo $product_gold->metal; ?></strong></p>
                                                        <?php }if($order_detail->options->product_diamond){ 
                                                              $product_diamond=$this->db->query("select  *,`color|clarity` as cc from product_diamond where id='".$order_detail->options->product_diamond."'")->row();?>
                                                        <p class="order__product__diamond">Diamond: <strong><?php echo $product_diamond->cc; ?></strong></p>
                                                        <?php }if($order_detail->options->product_stone){ 
                                                              $product_stone=$this->db->query("select  * from product_stone where id='".$order_detail->options->product_stone."'")->row(); ?>
                                                        <p class="order__product__metal">Stone: <strong><?php echo $product_stone->stone; ?></strong></p>
                                                        <?php }?>
                                                    </div>
                             
                                                    <div class="order__details__btn">
                                                        <a href="#" class="btn effect__btn">Buy Back</a>
                                                        <a href="#" class="btn effect__btn" data-toggle="modal" data-target="#reviewModal" data-orderid="<?php echo $record->id; ?>" data-ordernumber="<?php echo $record->order_number; ?>">Review</a>
                                                        
                                                    </div>
                                                    
                                                     <div class="accordion" id="accordionExample">                        
                                <div class="card pricebreakupcard">
                                <div class="card-header collapsed" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <h5 class="mb-0">
                                    Asset Value
                                </h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>img/minus.svg" class="accordion__icon minus" alt="Minus">
                                </div>
                                <div id="collapseFive" class="collapse pricebreakupcollapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="pricebreakup-table table table-borderless table-striped table-hover" width="100%">
                                        <tr>
                                            <th>Component</th>
                                            <th>Rate</th>
                                            <th>Approx. Weight</th>
                                            <th>Value</th>
                                            <th>Discount</th>
                                            <th>Final value</th>
                                        </tr>
                                        <?php if($order_detail->options->product_gold){  ?>
                                        <tr class="goldrow">
                                            <td>Gold (<?php echo $product_gold->purity.' '.$product_gold->metal; ?>)</td>
                                            <td><?php echo $product_gold->gold_rate;?> / g</td>
                                            <td><?php if($product_gold->weight!=""){ echo $product_gold->weight.' '.$product_gold->unit;}else{ echo "-";}?></td>
                                            <td class="amount">₹ <?php echo $product_gold->price;?></td>
                                            <td><?php //if($product_gold->discount!=""){echo $product_gold->discount."%";}else{ echo "";}?></td>
                                            <td class="finalamount">₹ <?php echo $product_gold->final_price;?></td>
                                        </tr>
                                        <?php }?>
                                        <?php if($order_detail->options->product_diamond){ ?>
                                        <tr class="diamondrow">
                                            <td>Diamond (<?php echo $product_diamond->cc.' - '.$product_diamond->count; ?>)</td>
                                            <td></td>
                                            <td><?php if($product_diamond->weight!=""){ echo $product_diamond->weight.' '.$product_diamond->unit;}else{ echo "";}?></td>
                                            <td class="amount">₹ <?php echo $product_diamond->price;?></td>
                                            <td><?php if($product_diamond->discount!=""){echo $product_diamond->discount."%";}else{ echo "";}?></td>
                                            <td class="finalamount">₹ <?php echo $product_diamond->final_price;?></td>
                                        </tr>
                                        <?php }?>
                                        <?php if($order_detail->options->product_stone){  ?>
                                        <tr class="stonerow">
                                            <td>Stone (<?php echo $product_stone->stone.'-'.$product_stone->count; ?>)</td>
                                            <td></td>
                                            <td><?php if($product_stone->weight!=""){ echo $product_stone->weight.' '.$product_stone->unit;}else{ echo "";}?></td>
                                            <td class="amount">₹ <?php echo $product_stone->price;?></td>
                                            <td><?php if($product_stone->discount!=""){echo $product_stone->discount."%";}else{ echo "";}?></td>
                                            <td class="finalamount">₹ <?php echo $product_stone->final_price;?></td>
                                        </tr>
                                        <?php }?>
                                        
                                        <tr class="subtotalrow">
                                            <td>Sub Total (Asset Value)?</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="amount">₹ <?php echo $product_detail->sub_total-$product_detail->making_charge_net_amount-$product_detail->other_charge_net_amount;?></td>
                                        </tr>
                                        
                                    </table>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="order__shipping__info">
                                                    <!--<div class="tracking__detail__box bg-secondary p-4 text-dark text-center"><span class="mr-2">Status:</span><?php echo $status->title; ?></div>-->
                                                <!--<div class="order__tracking steps steps-body">    
                                                    <div class="step"><span class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg></span><?php echo $status->title; ?></div>
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <?php }?>
                               
                            </div>
                        </div>

                        <!--<div class="order__tracking">
                            <div class="row mb-3">
                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="tracking__detail__box bg-secondary p-4 text-dark text-center"><span class="mr-2">Shipped via:</span>UPS Ground</div>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="tracking__detail__box bg-secondary p-4 text-dark text-center"><span class="mr-2">Status:</span>Quality check</div>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="tracking__detail__box bg-secondary p-4 text-dark text-center"><span class="mr-2">Expected date:</span>June 17, 2019</div>
                                </div>
                            </div>
                            <div class="steps">
                                <div class="steps-header">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="steps-body">
                                    <div class="step step-completed"><span class="step-indicator"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></span><span class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></span>Order confirmed</div>
                                    <div class="step step-completed"><span class="step-indicator"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></span><span class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></span>Processing order</div>
                                    <div class="step step-active"><span class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg></span>Quality check</div>
                                    <div class="step"><span class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg></span>Product dispatched</div>
                                    <div class="step"><span class="step-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></span>Product delivered</div>
                                </div>
                            </div>
                            <div class="d-sm-flex flex-wrap justify-content-between align-items-center text-center pt-4">
                                <div class="custom-control custom-checkbox mt-2 mr-3">
                                    <input class="custom-control-input" type="checkbox" id="notify-me" checked="">
                                    <label class="custom-control-label" for="notify-me">Notify me when order is delivered</label>
                                </div><a class="btn btn-primary btn-sm mt-2" href="#order-details" data-toggle="modal">View Order Details</a>
                            </div>
                        </div>-->
                    </div>
                </div>
                <?php } ?>
                
            </div>
        </section>
                
                
                
	
	
	
	<!-- Modal -->
	<div class="modal reviewModal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	  	<form action="<?php echo site_url('insertorderreviews'); ?>" method="post" class="w-100">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="reviewModalLabel">Review<span></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
			  	<div class="form-group">
					<label>Rating</label>
					<div id="rating"></div>
				</div>
				<div class="form-group">
					<label>Comment</label>
					<textarea class="form-control" name="comment"></textarea>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			  </div>
			</div>
			<input type="hidden" name="user_id" value="<?php echo $this->ion_auth->user()->row()->id; ?> " />
			<input type="hidden" name="order_id" />
			<input type="hidden" name="rating" id="rating_input" />
			<input type="hidden" name="return_url" value="orders" />
		</form>
	  </div>
	</div>

<script>

	$('#reviewModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var orderid = button.data('orderid') // Extract info from data-* attributes
		var ordernumber = button.data('ordernumber')
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('.modal-title span').text(' : ' + ordernumber)
		modal.find('.modal-dialog input[name="order_id"]').val(orderid)
	})

</script>