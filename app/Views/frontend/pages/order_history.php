<?php 
$this->db = \Config\Database::connect();
$request = \Config\Services::request();
?>
<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<main>
        <section class="order__history--block">
            <div class="container">
                <div class="row justify-content-center mb-3">
                    
                    <div class="col-md-12 text-center">
                        <h1>Order History</h1>
                    </div>
                </div>
                <?php foreach ($orders AS $record) { 
                $status=$this->db->query("select o.title from ordersstatus_logs ol left join orderstatus o on o.id=ol.order_status where ol.order_id='".$record->id."' order by ol.id desc limit 1")->getRow();
                ?>
                <?php $order_details = json_decode($record->order_details); ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="order__history__list">
                            <div class="order__history__item mb-3">
                                <div class="order__tracking order__history__header d-flex align-items-center justify-content-between">
                                    <h3 class="order__no">Order: <?php echo $record->order_number; ?> <span class="order__date"><?php echo date('d F Y', strtotime($record->created_date)); ?></span></h3>
                                    <label class=" btn btn-primary btn-sm mt-2" style="cursor: default;"><?php echo $status->title; ?></label>
                                    <?php if($status->title=="Delivered" || $status->title=="Cancelled" || $status->title=="Cancellation Approved" || $status->title=="Cancelled by Admin"){}else{?>
                                    
                                    <button name="delete" type="button" id="delete" class=" btn1 btn-warning btn-sm mt-2 d-none" style="color:white;"  onclick="cancelOrder('<?php echo base_url("orders/cancel_order/").$record->id ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancel Order">Cancel Order</button>
                                    <?php }?>
                                    <h5 class="order__total">Total: $<?php echo $record->total_amount; ?></h5>
                                </div>
                                <?php foreach ($order_details AS $order_detail) { 
                                    
                                ?>
                                
                                <div class="order__history__body">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="order__details__main d-flex">
                                                <div class="order__img" style="background-image: url(<?php echo base_url('media/source/'.$order_detail->image); ?>)"></div>
                                                <div class="order__details__des">
                                                    <div class="order__details">
                                                        <h4 class="order__product__name"><?php echo htmlspecialchars_decode($order_detail->title); ?></h4>
                                                        <p class="order__product__price">Price: <strong>$<?php echo $order_detail->price; ?></strong></p>
                                                        <p class="order__product__qty">Quantity: <strong>1</strong></p>
                                                        
                                                        <?php if($order_detail->types!='3'){ ?>
                                                        
                                                        <?php if($order_detail->size!="" && $order_detail->size!="0"){    
                                                              //$product_detail=$this->db->query("select  * from product_details where id='".$order_detail->options->product_size."'")->row(); ?>
                                                        <p class="order__product__size">Size: <strong><?php echo $order_detail->size; ?></strong></p>
                                                        <?php }if($order_detail->color){ 
                                                             ?>
                                                        <p class="order__product__metal">Metal: <strong><?php echo $order_detail->color; ?></strong></p>
                                                        <?php }?>
                                                        
                                                        <?php }else{
                                                            $productset=json_decode($order_detail->set_product_json);
                                                             foreach($productset as $l){ ?>
                                                                <br/>
                                                                <p class="order__product__metal">Name: <strong><?php echo $l->name; ?></strong></p>
                                                                <p class="order__product__metal">Sku: <strong><?php echo $l->sku; ?></strong></p>
                                                        <?php } }?>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div>
                                                    <span style="color:#f05a89">For any queries kindly mail us at connect@joyari.com</span>
                                                </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                             <?php }?>  
                            </div>
                        </div>

                    </div>
                </div>
                <?php } ?>
                
            </div>
        </section>
                
     
	
<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>		      