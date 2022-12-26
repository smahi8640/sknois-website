<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<main>    
<?php if($records){
?>
        <section class="shopping__cart--block">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-8">
                        <div class="shopping__cart__list">
                            <div class="shopping__cart__total">
                                <p class="total__item">
								<?php // echo $this->session->userdata('global_cart_session');?>
								Total (<?php echo $cartcount['total_productcount']; ?> Items) : $ <?php echo $carttotal['total_price']; ?></p>
                            </div>
                            
                    <?php 
						//$cart_details = $this->cart->contents();
						//echo "<pre>"; print_r($cart_details); exit;
                        foreach($records as $cart){
                             if($cart->types!='3'){
                        ?>
                        
                            <div class="shopping__cart__item">
                                <div class="product__img">
									<?php 
										//if(file_exists(FCPATH."media/source/".$cart->image)) { 
											$img = base_url('media/source/').'/'.$cart->image;
										//} else { 
											//$img = base_url('media/source/joyari-logo.png');
										//}
									?>
                                    <a href="#"><img src="<?php echo $img; ?>" alt="Product"></a>
                                    <div class="product__actions mt-3">
                                        <div class="product__actions__list">
                                            <a href="<?php echo BASE.'cart/removecart/'.$cart->product_stock_id; ?>" class="btn__outline btn__remove">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product__des">
                                    <div class="title__header">
                                        <h4 class="product__name"><a href="<?php //echo base_url('')?>jewellery/products/<?php //echo $alias->alias.'-'.$product_details->sku; ?>"><?php echo $cart->title; ?></a></h4>
                                        <p class="cart__sku"><?php echo $cart->sku;?></p>
                                        <div class="cart__update__options d-flex align-items-center">
                                            <?php if($cart->size!="0"){?>
                                            <div class="product__size">
                                                <label for="">Size :  </label><?php echo $cart->size;?>
                                            </div>
                                            <?php }?>
                                            <div class="product__size">
                                                <label for="">Color : </label><?php echo $cart->color; ?>
                                            </div>
                                            <div class="product__size">
                                                <label for="">Purity : </label><?php echo $cart->purity; ?>
                                            </div>
                                        
                                            <div class="product__size">
                                                <label for="">Qty : </label><?php echo $cart->qty; ?>
                                            </div>
                                        </div>
                                        <?php if($cart->types=='2'){?>
                                            <div class="product__size">
                                                <label for="" class="text-danger">(Made to order)</label>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <div class="details__footer">
                                        <h5 class="product__price">$<?php echo $cart->price; ?>
                                        <?php if($cart->mrp=="0" || $cart->mrp==$cart->price){ }else{?>
                                        <span class="offer__line">$<?php echo $cart->mrp; ?></span>
                                        <span class="discountprice">Save $<?php echo $cart->mrp-$cart->price; ?></span>
                                        <?php }?>
                                        </h5>
                                    </div>
                                </div>

                            </div>
                        <?php }else{?>
                            
                            
                            <div class="shopping__cart__item">
                                <div class="product__img">
									<?php 
										//if(file_exists(FCPATH."media/source/".$cart->image)) { 
											$img = base_url('media/source/').'/'.$cart->image;
										//} else { 
											//$img = base_url('media/source/joyari-logo.png');
										//}
									?>
                                    <a href="#"><img src="<?php echo $img; ?>" alt="Product"></a>
                                    <div class="product__actions mt-3">
                                        <div class="product__actions__list">
                                            <a href="<?php echo BASE.'cart/removecart1/'.$cart->product_set_id; ?>" class="btn__outline btn__remove">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product__des">
                                    <div class="title__header d-flex flex-wrap">
                                        <h4 class="product__name"><a href="<?php //echo base_url('')?>jewellery/products/<?php //echo $alias->alias.'-'.$product_details->sku; ?>"><?php echo $cart->title; ?></a></h4>
                                        <label for="" class="text-danger">(Product Set)</label>
                                    </div>
                                    <div class="product__des--body d-flex flex-wrap">
                                       <?php $products=json_decode($cart->set_product_json);
                                       
                                        foreach($products as $l){ 
                                            
                                        ?>
                                        <?php 
    										//if(file_exists(FCPATH."media/source/".$l->image)) { 
    											$img = base_url('media/source/').'/'.$l->image;
    										//} else { 
    											//$img = base_url('media/source/joyari-logo.png');
    										//}
    									?>
    									
                                        <div class="cart__options--col">
                                            <div class="cart__update__options d-flex flex-wrap">
                                                <div class="cart__option--img">
                                                    <img src="<?php echo $img; ?>" alt="Product">
                                                </div>
                                                <div class="cart__option--des">
                                                    <div class="cart__option--item">
                                                        <label for="">Name: </label><?php echo $l->name;?>
                                                    </div>
                                                    <div class="cart__option--item">
                                                        <label for="">Sku: </label><?php echo $l->sku;?>
                                                    </div>
                                                    <?php if($l->size!="0"){?>
                                                    <div class="cart__option--item">
                                                        <label for="">Size: </label><?php echo $l->size;?>
                                                    </div>
                                                    <?php }?>
                                                    <div class="cart__option--item">
                                                        <label for="">Color: </label><?php echo $l->color; ?>
                                                    </div>
                                                    <div class="cart__option--item">
                                                        <label for="">Purity: </label><?php echo $l->purity; ?>
                                                    </div>
                                                    <div class="cart__option--item">
                                                        <label for="">Qty: </label>1
                                                    </div>
                                                    <div class="cart__option--item">
                                                        <label for="">Price: </label><?php echo $l->price; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="details__footer">
                                        <h5 class="product__price">$<?php echo $cart->price; ?>
                                        <?php if($cart->mrp=="0" || $cart->mrp==$cart->price){ }else{?>
                                        <span class="offer__line">$<?php echo $cart->mrp; ?></span>
                                        <span class="discountprice">Save $<?php echo $cart->mrp-$cart->price; ?></span>
                                        <?php }?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            
                        
                        <?php }}?>
                           
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="order__summary__main">
                            <div class="shopping__coupon">
                                <!--<button class="btn coupon__btn effect__btn" <?php //if(empty($cart)){ //echo 'disabled';} ?> data-toggle="modal" data-target="#video__call" <?php  //echo ($coupon_id)?'disabled':''; ?>>Apply Coupon <img class="in__svg" src="<?php //echo base_url('assets/frontend/') ?>img/down-arrow.svg" alt="Arrow"></button>-->
                            </div>
                            <?php
                            /*if($coupon_data){
                                if($coupon_data['type'] == 'amount'){
                                    $final_cost = $sum->gr - $coupon_data['value'];
                                    $final_cost = $final_cost;
                                    $discount = '$'.$coupon_data['value'].' <span class="remove_coupon" data-couponid="'.$coupon_id.'">&nbsp;<svg height="427pt" viewBox="-40 0 427 427.00131" width="427pt" xmlns="http://www.w3.org/2000/svg"><path d="m232.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/><path d="m114.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/><path d="m28.398438 127.121094v246.378906c0 14.5625 5.339843 28.238281 14.667968 38.050781 9.285156 9.839844 22.207032 15.425781 35.730469 15.449219h189.203125c13.527344-.023438 26.449219-5.609375 35.730469-15.449219 9.328125-9.8125 14.667969-23.488281 14.667969-38.050781v-246.378906c18.542968-4.921875 30.558593-22.835938 28.078124-41.863282-2.484374-19.023437-18.691406-33.253906-37.878906-33.257812h-51.199218v-12.5c.058593-10.511719-4.097657-20.605469-11.539063-28.03125-7.441406-7.421875-17.550781-11.5546875-28.0625-11.46875h-88.796875c-10.511719-.0859375-20.621094 4.046875-28.0625 11.46875-7.441406 7.425781-11.597656 17.519531-11.539062 28.03125v12.5h-51.199219c-19.1875.003906-35.394531 14.234375-37.878907 33.257812-2.480468 19.027344 9.535157 36.941407 28.078126 41.863282zm239.601562 279.878906h-189.203125c-17.097656 0-30.398437-14.6875-30.398437-33.5v-245.5h250v245.5c0 18.8125-13.300782 33.5-30.398438 33.5zm-158.601562-367.5c-.066407-5.207031 1.980468-10.21875 5.675781-13.894531 3.691406-3.675781 8.714843-5.695313 13.925781-5.605469h88.796875c5.210937-.089844 10.234375 1.929688 13.925781 5.605469 3.695313 3.671875 5.742188 8.6875 5.675782 13.894531v12.5h-128zm-71.199219 32.5h270.398437c9.941406 0 18 8.058594 18 18s-8.058594 18-18 18h-270.398437c-9.941407 0-18-8.058594-18-18s8.058593-18 18-18zm0 0"/><path d="m173.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/></svg></span>';
                                }
                                else{
                                    $discount = ($sum->gr * $coupon_data['value']) / 100;
                                    $final_cost = $sum->gr - $discount;
                                    $final_cost = $final_cost;
                                    $discount = '$'.$discount.' <span class="remove_coupon" data-couponid="'.$coupon_id.'">&nbsp;<svg height="427pt" viewBox="-40 0 427 427.00131" width="427pt" xmlns="http://www.w3.org/2000/svg"><path d="m232.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/><path d="m114.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/><path d="m28.398438 127.121094v246.378906c0 14.5625 5.339843 28.238281 14.667968 38.050781 9.285156 9.839844 22.207032 15.425781 35.730469 15.449219h189.203125c13.527344-.023438 26.449219-5.609375 35.730469-15.449219 9.328125-9.8125 14.667969-23.488281 14.667969-38.050781v-246.378906c18.542968-4.921875 30.558593-22.835938 28.078124-41.863282-2.484374-19.023437-18.691406-33.253906-37.878906-33.257812h-51.199218v-12.5c.058593-10.511719-4.097657-20.605469-11.539063-28.03125-7.441406-7.421875-17.550781-11.5546875-28.0625-11.46875h-88.796875c-10.511719-.0859375-20.621094 4.046875-28.0625 11.46875-7.441406 7.425781-11.597656 17.519531-11.539062 28.03125v12.5h-51.199219c-19.1875.003906-35.394531 14.234375-37.878907 33.257812-2.480468 19.027344 9.535157 36.941407 28.078126 41.863282zm239.601562 279.878906h-189.203125c-17.097656 0-30.398437-14.6875-30.398437-33.5v-245.5h250v245.5c0 18.8125-13.300782 33.5-30.398438 33.5zm-158.601562-367.5c-.066407-5.207031 1.980468-10.21875 5.675781-13.894531 3.691406-3.675781 8.714843-5.695313 13.925781-5.605469h88.796875c5.210937-.089844 10.234375 1.929688 13.925781 5.605469 3.695313 3.671875 5.742188 8.6875 5.675782 13.894531v12.5h-128zm-71.199219 32.5h270.398437c9.941406 0 18 8.058594 18 18s-8.058594 18-18 18h-270.398437c-9.941407 0-18-8.058594-18-18s8.058593-18 18-18zm0 0"/><path d="m173.398438 154.703125c-5.523438 0-10 4.476563-10 10v189c0 5.519531 4.476562 10 10 10 5.523437 0 10-4.480469 10-10v-189c0-5.523437-4.476563-10-10-10zm0 0"/></svg></span>';
                                }
                            }
                            else{
                                $final_cost = $sum->gr;
                                $discount = '-';
                            }*/
                            ?>
                            <h4>Order Summary</h4>
                            <div class="order__summary">
                                <p class="subtotal">Subtotal <span class="price-values">$<?php echo $carttotal['total_mrp']; ?></span></p>
                                <?php if($carttotal['total_mrp']=="0" || $carttotal['total_price']==$carttotal['total_mrp']){ }else{?>
                                <p class="discount">You Saved <span class="price-values">-$<?php echo $carttotal['total_mrp']-$carttotal['total_price']; ?></span></p>
                                <?php }?>
                                <p class="discount">Coupon Discount <span class="price-values"><a class="coupon_discount"><?php //echo $discount; ?></a></span></p>
                                <p class="shipping__charge">Delivery Charge (Standard) <span class="price-values"><span class="free">FREE</span></span></p>
                                <p class="price--breakup--final mb-0">Nett Amount <span class="price-values final_price">$<?php echo $carttotal['total_price']; ?></span></p>
                            </div>
                            <?php if(!empty($records)){?>
                            <div class="checkout__button">
                                <a href="<?php echo BASE.'checkout' ?>" class="btn effect__btn checkout__btn"><img class="in__svg" src="<?php echo base_url('assets/frontend/') ?>/img/lock.svg" alt="Lock"> Checkout Securely</a>
                                <br/><br/>
                                    <!--<a href="#" class="btn effect__btn checkout__btn" data-toggle="modal" data-target="#video__call1"><img class="in__svg" src="<?php //echo base_url('assets/frontend/'); ?>/img/video-camera-with-play-button.svg" alt=""> Arrange Video Call</a>-->
                               
                            </div>
                            <?php }?>
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
        <section class="why__us--block why__us__services">
            <div class="container">
               
                <div class="row">
                    <!--<div class="col-lg-3">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('assets/frontend/')?>img/why1.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>30 days money back</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('assets/frontend/')?>img/why2.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>GSI certified & BIS Hallmarked</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('assets/frontend/')?>img/why3.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>free & insured shipping</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('assets/frontend/')?>img/why1.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>Lifetime buyback at best price</h3>
                            </div>
                        </div>
                    </div>-->
                    <div class="col-lg-12">
                        <div class="servies__list d-flex align-items-center justify-content-center">
                            <!--<div class="servie__item">
                               <a href="#" data-toggle="modal" data-target="#modal__s1"> <img src="<?php //echo base_url('assets/frontend/')?>/img/services/service1.png" alt="services"></a>
                            </div>
                            <div class="servie__item">
                               <a href="#" data-toggle="modal" data-target="#modal__s2"> <img src="<?php //echo base_url('assets/frontend/')?>/img/services/service2.png" alt="services"></a>
                            </div>-->
                            <div class="servie__item">
                               <a href="#" data-toggle="modal" data-target="#modal__s3"> <img src="<?php echo base_url('assets/frontend/')?>/img/services/service3.png" alt="services"></a>
                            </div>
                            <!--<div class="servie__item">
                               <a href="#" data-toggle="modal" data-target="#modal__s4"> <img src="<?php echo base_url('assets/frontend/')?>img/services/service4.png" alt="services"></a>
                            </div>-->
                            <div class="servie__item">
                               <a href="#" data-toggle="modal" data-target="#modal__s5"> <img src="<?php echo base_url('assets/frontend/')?>/img/services/service5.png" alt="services"></a>
                            </div>
                            <div class="servie__item">
                               <a href="#" data-toggle="modal" data-target="#modal__s6"> <img src="<?php echo base_url('assets/frontend/')?>/img/services/service6.png" alt="services"></a>
                            </div>
                            <div class="servie__item">
                               <a href="#" data-toggle="modal" data-target="#modal__s7"> <img src="<?php echo base_url('assets/frontend/')?>/img/services/service7.png" alt="services"></a>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </section>
        
        <?php }else{ ?>
        <section class="shopping__cart--block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="shopping__cms text-center">
                            <div class="shopping__cms__img">
                                <img src="<?php echo base_url('assets/frontend/img/') ?>/empty-cart.svg" alt="Image">
                            </div>
                            <div class="shopping__cms__content">
                                <h3>Your cart is empty</h3>
                                <p>Looks like you heaven't made your choice yet...</p>
                                <!--<a href="#" class="btn cms__btn effect__btn">Shop now</a>-->
                            </div>
                        </div>
                    </div>    
                </div>
            </div>    
        </section>    
        <?php }?>
        <div class="modal fade" id="video__call" tabindex="-1" role="dialog" aria-labelledby="video__call__Title"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
                <div class="video__call__bg">
                    
                </div>
                <form id="applyCoupn">
                    <input type="hidden" name="total_cost" value="<?php echo $carttotal['total_price']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter your coupon">
                        <span class="mt-2 mb-0 text-danger coupon_code_error" style="display: none;"></span>
                    </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn schedule__btn effect__btn">Apply Coupon</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      
      <div class="video__call modal fade " id="video__call1" tabindex="-1" role="dialog" aria-labelledby="video__call__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
                <div class="video__call__bg">
                    <img src="<?php echo base_url('assets/frontend/'); ?>/img/video_call__bg.svg" class="in__svg" alt="Video Call">
                </div>
                <p>View our collection live, compare and shortlist, ask questions and make your choice ... all through a live video chat session at a convenient time.</p>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" name="fullname" value="<?php //echo $user->first_name.''.$user->last_name; ?>" id="fullname" placeholder="Enter your Full Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile" value="<?php //echo $user->phone; ?>" id="mobile" placeholder="Enter your mobile number">
                    </div>
                    <div class="form-group mb-0">
                        <a  id="videocall" class="btn schedule__btn effect__btn">Schedule Video Call</a>
                        
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>

<div class="ring__size__popup modal fade" id="modal__s1" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                        <center><img src="<?php echo base_url(); ?>/assets/frontend/img/advantages6.png" alt=""></center>
                    <h5 class="modal-title text-center">
                        30-DAY MONEY BACK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                        <div class="row text-center">
                            
                            If you dont like the jewellery you bought on joyari.com, with just one single step you can return the jewellery with 100% Money Back Guarantee. No Shipping Charges will be charged.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div> 
<div class="ring__size__popup modal fade" id="modal__s2" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                        <center><img src="<?php echo base_url(); ?>/assets/frontend/img/advantages7.png" alt=""></center>
                    <h5 class="modal-title text-center">
                        Lifetime Buyback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                        <div class="row text-center">
                            You can sell our jewellery back to us (Joyari) for which you can get upto 90% amount of the jewellery in the current value of the jewellery. Shipping charges of INR. 500 has to paid against the shipping.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div> 
    <div class="ring__size__popup modal fade" id="modal__s3" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center><img src="<?php echo base_url(); ?>/assets/frontend/img/advantages4.png" alt=""></center>
                    <h5 class="modal-title text-center">
                        
                        Certification & Hallmark</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                        <div class="row text-center">
                           All Joyari products comes with Certificate of Authentication and Hallmark. All jewelry are certified inhouse by Joyari.com under International quality protocol.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div>
    <div class="ring__size__popup modal fade" id="modal__s4" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center><img src="<?php echo base_url(); ?>/assets/frontend/img/advantages5.png" alt=""></center>
                    <h5 class="modal-title text-center">Ready to Ship</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                        <div class="row text-center">
                            What looks good as a design not necessary be good once manufactured. So we have manufactured all the jewellery just to make sure the designs are Practical & with Brilliant Finish, because of which all our jewellery are Ready-To-Ship.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div>
    <div class="ring__size__popup modal fade" id="modal__s5" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center><img src="<?php echo base_url(); ?>/assets/frontend/img/advantages10.png" alt=""></center>
                    <h5 class="modal-title text-center">Secured Payments Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                        <div class="row text-center">
                            You can choose various online payment options right from Credit Card, Debit Card, Netbanking and Wallet powered by Paypal.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div>
    <div class="ring__size__popup modal fade" id="modal__s6" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center><img src="<?php echo base_url(); ?>/assets/frontend/img/advantages9.png" alt=""></center>
                    <h5 class="modal-title text-center">
                        
                        Free and Insured Shipping</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                        <div class="row text-center">
                            Any jewelry you buy on Joyari.com during the transit all shipping is Insured as well as Free of Cost.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div> 
    <div class="ring__size__popup modal fade" id="modal__s7" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center><img src="<?php echo base_url(); ?>/assets/frontend/img/advantages3.png" alt=""></center>
                    <h5 class="modal-title text-center">Diamond Quality</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                        <div class="row text-center">
                            We source all the diamonds directly from the manufacturers. Diamonds used are all Natural / Mined Diamonds with best of its specified color(E-F) and clarity(VS-SI) or better.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div>
      
<script>
    $(document).on("submit","#applyCoupn",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'forms/applyCoupnCode'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
           
            success(response){
                var obj =  JSON.parse(response);
                if(obj.status){
                    $(".coupon_code_error").hide();
                    $(".coupon_code_error").html();
                    setTimeout(function(){
                        swal({
                            title: "Message!",
                            text: obj.message,
                            type: "success"
                        });
                    },1000); 
                    $("#video__call").modal('toggle');
                    $(".coupon__btn").attr('disabled', true);
                    $(".coupon_discount").html(obj.coupon_discount);
                    $(".final_price").html(obj.final_cost);
                }
                else{
                    $(".coupon_code_error").html(obj.message);
                    $(".coupon_code_error").show();
                }
            }
        })
    });
    
    
    
    $(document).on("click",'.remove_coupon', function(){
        var coupon_id = $(this).attr('data-couponid');
        $.ajax({
            url:'<?php echo base_url().'forms/removeCoupnCode'?>',
            method:"POST",
            data:{"coupon_id": coupon_id},
            contentType: false,
            cache: false,
            processData:false,
            success(response){
                var obj =  JSON.parse(response);
                if(obj.status){ 
                    $("#coupon_code").val('');  
                    $(".coupon__btn").attr('disabled', false);
                    $(".coupon_discount").html(obj.coupon_discount);
                    $(".final_price").html(obj.final_cost);
                }
            }
        })
    });
    
    
    $(document).on("click","#videocall",function(){
            var mobile = $("#mobile").val();
            var fullname = $("#fullname").val();
	    	var product_details_id = $("#product_id").val();
	    	$.ajax({
	    		url:'<?php echo base_url().'forms/videocall'?>',
	    		method:"POST",
	    		data: { mobile:mobile,fullname:fullname, product_details_id:product_details_id },
	    		dataType: 'json',
	    	})
			.done(function( response ) {
	    		if(response.status) {
	    			setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: response.message,
                        type: "success"
                    });
           
                },1000); 
	    				$("#video__call1").modal('toggle');
	    				//toastr.success('Sent successfully.');	
	    			}
	    	})
	    });  
</script>
<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>