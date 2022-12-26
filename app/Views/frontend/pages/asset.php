
 <main>
        <section class="order__history--block">
            <div class="container">
                <div class="row justify-content-center mb-3">
                    <div class="col-md-12 search__main">
                        <div class="header__search">
                            <form action="<?php echo site_url('asset/search'); ?>" method="post">
                                <div class="row">
                                <div class="col">
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <input class="form-control" type="text" id="header-search" name="search_sku" value="<?php echo @$search_sku; ?>" placeholder="Search by sku" aria-label="Search by sku">
                                        </div>
                                        <div class="form-group col-md-1">
                                          <label class="form-control text-center" style="border:0px;">OR</label> 
                                        </div>   
                                        <div class="form-group col-md-5"> 
                                            <input class="form-control" type="text" id="header-search"  name="search_cert" value="<?php echo @$search_cert; ?>" placeholder="Search by certificate no." aria-label="Search by certificate no.">
                                        </div>
                                        <div class="form-group col-md-1">    
                                       <button class="btn btn-submit btn-warning" type="submit"> <img src="http://resel.co.in/joyari/assets/frontend/img/search.svg" alt="Search">
                                            </button>
                                        </div>
                                        </div>
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-12 text-center">
                        <h1>Asset Value</h1>
                    </div>
                </div>
                <?php 
                if(!empty($records)){
                foreach ($records AS $record) { 
                 ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="order__history__list">
                            <div class="order__history__item">
                               
                                <?php 
                                $products=$this->db->query("select * from products where id='".$record->product_id."'")->row();?>
                                
                                <div class="order__history__body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="order__details__main d-flex">
                                                <img class="order__img" src="<?php echo base_url('media/source/'.$products->intro_image); ?>"></img>
                                                <div class="order__details__des col-md-10">
                                                    <div class="order__details ">
                                                        <h4 class="order__product__name"><?php echo htmlspecialchars_decode($products->title); ?></h4>
                                                        <h5><?php echo $products->description; ?></h5>
                                                        <p class="order__product__price">Price: <strong>₹<?php echo $record->final_price; ?></strong></p>
                                                        
                                                        <?php if($record->size!="" && $record->size!="0"){    
                                                              //$product_detail=$this->db->query("select  * from product_details where id='".$order_detail->options->product_size."'")->row(); ?>
                                                        <p class="order__product__size">Size: <strong><?php echo $record->size; ?></strong></p>
                                                        <?php }
                                                            $product_gold=$this->db->query("select  * from product_gold where product_details_id='".$record->id."'")->row();
                                                            if($product_gold){
                                                            ?>
                                                            
                                                        <p class="order__product__metal">Metal: <strong><?php echo $product_gold->metal; ?></strong></p>
                                                        <?php }
                                                              $product_diamond= $this->db->query("select `count`,unit,`color|clarity` as cc,sum(final_price) as final_price,sum(weight) as weight,sum(price) as price from product_diamond where product_details_id='".$record->id."'")->row();
                                                              if($product_diamond){ 
                                                              ?>
                                                        <p class="order__product__diamond">Diamond: <strong><?php echo $product_diamond->cc; ?></strong></p>
                                                        <?php } 
                                                              $product_stone=$this->db->query("select  * from product_stone where product_details_id='".$record->id."'")->row(); 
                                                              if($product_stone){
                                                              ?>
                                                        <p class="order__product__metal">Stone: <strong><?php echo $product_stone->stone; ?></strong></p>
                                                        <?php }?>
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
                                        <?php if($product_gold){  ?>
                                        <tr class="goldrow">
                                            <td>Gold (<?php echo $product_gold->purity.' '.$product_gold->metal; ?>)</td>
                                            <td><?php echo $product_gold->gold_rate;?> / g</td>
                                            <td><?php if($product_gold->weight!=""){ echo $product_gold->weight.' '.$product_gold->unit;}else{ echo "-";}?></td>
                                            <td class="amount">₹ <?php echo round($product_gold->price,2);?></td>
                                            <td><?php //if($product_gold->discount!=""){echo $product_gold->discount."%";}else{ echo "";}?></td>
                                            <td class="finalamount">₹ <?php echo round($product_gold->final_price,2);?></td>
                                        </tr>
                                        <?php }?>
                                        <?php if($product_diamond){ ?>
                                        <tr class="diamondrow">
                                            <td>Diamond (<?php echo $product_diamond->cc.' - '.$product_diamond->count; ?>)</td>
                                            <td></td>
                                            <td><?php if($product_diamond->weight!=""){ echo round($product_diamond->weight,2).' '.$product_diamond->unit;}else{ echo "";}?></td>
                                            <td class="amount">₹ <?php echo round($product_diamond->price,2);?></td>
                                            <td><?php if($product_diamond->discount!=""){echo $product_diamond->discount."%";}else{ echo "";}?></td>
                                            <td class="finalamount">₹ <?php echo round($product_diamond->final_price,2);?></td>
                                        </tr>
                                        <?php }?>
                                        <?php if($product_stone){  ?>
                                        <tr class="stonerow">
                                            <td>Stone (<?php echo $product_stone->stone.'-'.$product_stone->count; ?>)</td>
                                            <td></td>
                                            <td><?php if($product_stone->weight!=""){ echo $product_stone->weight.' '.$product_stone->unit;}else{ echo "";}?></td>
                                            <td class="amount">₹ <?php echo round($product_stone->price,2);?></td>
                                            <td><?php if($product_stone->discount!=""){echo $product_stone->discount."%";}else{ echo "";}?></td>
                                            <td class="finalamount">₹ <?php echo round($product_stone->final_price,2);?></td>
                                        </tr>
                                        <?php }?>
                                        
                                        <tr class="subtotalrow">
                                            <td>Sub Total (Asset Value)?</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="amount">₹ <?php echo $record->sub_total-$record->making_charge_net_amount-$record->other_charge_net_amount;?></td>
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
                                        
                                    </div>
                                    
                                </div>
                                
                               
                            </div>
                        </div>
                        
                    </div>
                </div>
                <?php } }else{ ?>
                <div class="col-md-12 text-center alert alert-info">No data found.</div>
                <?php }?>
                
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