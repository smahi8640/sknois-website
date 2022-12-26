<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>

</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<?php $ionAuth = new \IonAuth\Libraries\IonAuth(); ?>
    <main>
        <section class="banner--block">
            <div class="home__banner home__slider">
             <?php foreach ($homeslides AS $homeslide) { ?>   
                <div class="banner__item">
                    <div class="banner__img">
                        <img class="w-100" src="<?php echo base_url('media/source/').'/'.$homeslide['image']; ?>" alt="Banner">
                    </div>
                </div>
            <?php }?>    
            </div>
        </section>

        <section class="feature--block">
            <div class="container">
                <div class="row">
                   <?php $i=1; foreach ($categories AS $categorys) { 
                   ?>
                    <div class="col-lg-6">
                        <div class="feature__banner banner2">
                        <a href="<?php echo BASE.'jewelry/'.$categorys['alias']; ?>">    
                            <div class="feature__img" style="background-image: url(<?php echo base_url('media/source/').'/'.$categorys['image']; ?>)"></div>
                            </a>
                           
                        </div>
                    </div>
                    
                    <?php $i++;}?>
                    <div class="col-lg-6">
                        <div class="feature__banner banner2">
                        <a href="<?php echo BASE.'products_set'; ?>">    
                            <div class="feature__img" style="background-image: url(<?php echo base_url('media/source/ShopbySets.jpg'); ?>)"></div>
                            </a>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="category--block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12"> 
                    <div class="main__title">
                        <h1>Joyari - luxury for all...</h1>
                        <p>At Joyari Jewels, we stand for “Luxury for all.” Our high-quality jewelries are made keeping in mind your varied taste, moods as well as budget – from an everyday wear to an event where you need to be your stunning best – we are there for you.</p>
                    </div>
                    </div>
                </div>
                <div class="row">
                 <div class="col-lg-12">
                  <div class="category__slider">
                    <?php foreach($collections as $collection){ ?>
                    
                        <div class="category__item">
                            <div class="category__img">
                                <img src="<?php echo base_url('media/source/').'/'.$collection['image']; ?>" alt="Category">
                            </div>
                            <div class="category__des">
                                <h4><?php echo $collection['title']; ?></h4>
                                <a href="<?php if($collection['id']=="2"){$alias="fashion-rings";}else if($collection['id']=="3"){$alias="fashion-earrings";}else if($collection['id']=="4"){$alias="fashion-pendants";}  echo BASE.'jewelry/'.$alias; ?>">Shop Now</a>
                            </div>
                        </div>
                    
                    <?php }?>
                    
                   </div>
                  </div>
                </div>
            </div>
        </section>
        
        <section class="feature__product--block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    <div class="main__title">
                        <h1><?php echo $labels['title']; ?></h1>
                    </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product__slider">
                    <?php
                   $fproducts= $this->db->query("select * from products where status='1' and label_ids='".$labels['id']."'")->getResultArray();
                    foreach ($fproducts AS $product) {  
                        ?>
                        <div class="feature__product__item">
                            <div class="product__img">
                               <a href="<?php echo BASE.'products/'.$product['alias'].'-'.$product['style_no']; ?>"> 
                               <img src="<?php echo base_url('media/source/').'/'.$product['intro_image']; ?>" alt="Product"></a>
                            </div>
                            <div class="product__content">
                                <div class="product__whishlist">
                                    <img class="in__svg" src="<?php echo base_url('assets/frontend/')?>/img/filled_heart.svg" alt="">
                                </div>
                                
                                <div class="product__des">
                                    <h5><a href="<?php echo BASE.'products/'.$product['alias'].'-'.$product['style_no']; ?>"><?php echo $product['title']; ?></a></h5>
                                    <h4 class="add-to-card"><a href="<?php echo BASE.'products/'.$product['alias'].'-'.$product['style_no']; ?>">View</a></h4>
                                </div>
                            </div>
                        </div>
                        

                    <?php }?>
                    
                    </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <a href="<?php echo BASE.'products/all'; ?>" class="view__all effect__btn">View All</a>
                    </div>
                </div>
            </div>
        </section>
        
<section class="collection--block">
            <div class="container">
                <div class="row">
                <div class="col-md-12">    
                    <div class="main__title">
                        <h1>BECAUSE EVERY ONE IS PRECIOUS</h1>
                        <p>Yes, you are precious and the most influencer part of our business. At Joyari we are very much obsessed with the customer centric policy because we strongly believe that we are nothing without you all, our existence is just because of you and that makes you precious, isn’t it?</p>
                    </div>
                </div>    
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="collection__item">
                            <a href="<?php echo BASE.'products/all'; ?>">
                                <div class="collection__img">
                                    <img src="<?php echo base_url('media/source/Banner3.jpg')?>" alt="Banner" />
                                </div>
                            </a>
                            <div class="collection__des">
                                <h3><a href="<?php echo BASE.'products/all'; ?>">New Arrivals</a></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 d-none">
                        <div class="collection__item">
                            <a href="#" data-toggle="modal" data-target="#video__call">
                                <div class="collection__img">
                                    <img src="<?php echo base_url('assets/frontend/')?>/img/collection2.png" alt="Banner" />
                                </div>
                            </a>
                            <div class="collection__des">
                                <h3><a href="#" data-toggle="modal" data-target="#video__call">Our Video</a></h3>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
        <section class="why__us--block">
            <div class="container">
                <div class="row">
                <div class="col-md-12">     
                    <div class="main__title">
                        <h1>why Joyari</h1>
                        <p>At Joyari, we don’t have very big and glossy words to appeal, we just simply believe in to delivering things you ordered. At any of our workplaces, our most valued customer is only focused, either it’s
                            designing, crafting, diamond selection, mounting, packing or anything related to your order is just
                            the matter of concern for us and that’s reason we are the most admired brand to get our customers
                            back soon for their another order!</p>
                    </div>
                </div>    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('assets/frontend/')?>/img/why1.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>Safe, Secure & Reliable</h3>
                                <p>Payment Option</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('assets/frontend/')?>/img/why2.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>Hallmark Certification</h3>
                                <p>Hallmark and  Certified jewelry</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('assets/frontend/')?>/img/why3.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>High Quality Finish</h3>
                                <p>What You See is What Your Get</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="servies__list d-flex align-items-center justify-content-center">
                            <!--<div class="servie__item">
                                 <a href="#" data-toggle="modal" data-target="#modal__s1"><img src="<?php //echo base_url('assets/frontend/')?>/img/services/service1.png" alt="services"></a>
                            </div>
                            <div class="servie__item">
                                 <a href="#" data-toggle="modal" data-target="#modal__s2"><img src="<?php //echo base_url('assets/frontend/')?>/img/services/service2.png" alt="services"></a>
                            </div>-->
                            <div class="servie__item">
                                 <a href="#" data-toggle="modal" data-target="#modal__s3"><img src="<?php echo base_url('assets/frontend/')?>/img/services/service3.png" alt="services"></a>
                            </div>
                            <div class="servie__item">
                                 <a href="#" data-toggle="modal" data-target="#modal__s5"><img src="<?php echo base_url('assets/frontend/')?>/img/services/service5.png" alt="services"></a>
                            </div>
                            <div class="servie__item">
                                 <a href="#" data-toggle="modal" data-target="#modal__s6"><img src="<?php echo base_url('assets/frontend/')?>/img/services/service6.png" alt="services"></a>
                            </div>
                            <div class="servie__item">
                                 <a href="#" data-toggle="modal" data-target="#modal__s7"><img src="<?php echo base_url('assets/frontend/')?>/img/services/service7.png" alt="services"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


   <?php $user = $ionAuth->user()->row();?>
  <div class="video__call modal fade" id="video__call1" tabindex="-1" role="dialog" aria-labelledby="video__call__Title" aria-hidden="true">
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
                <form id="videocall">
                    <div class="form-group">
                        <input type="text" class="form-control" name="fullname" value="<?php echo @$user->first_name.''.@$user->last_name; ?>" id="fullname" placeholder="Enter your Full Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile" value="<?php echo @$user->phone; ?>" placeholder="Enter your mobile number">
                    </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn schedule__btn effect__btn">Schedule Video Call</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div> 
      
   <!-- <div class="ring__size__popup modal fade" id="modal__s1" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
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
                  
                        <div class="row">
                            
                            If you dont like the jewelry you bought on joyari.com, with just one single step you can return the jewelry with 100% Money Back Guarantee. No Shipping Charges will be charged.
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
                  
                        <div class="row">
                            You can sell our jewelry back to us (Joyari) for which you can get upto 90% amount of the jewelry in the current value of the jewelry. Shipping charges of INR. 500 has to paid against the shipping.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div> -->
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
                  
                        <div class="row">
                           All Joyari products comes with Certificate of Authentication and Hallmark. All jewelry are certified inhouse by Joyari.com under International quality protocol.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div>
   <!-- <div class="ring__size__popup modal fade" id="modal__s4" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
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
                  
                        <div class="row">
                            What looks good as a design not necessary be good once manufactured. So we have manufactured all the jewelry just to make sure the designs are Practical & with Brilliant Finish, because of which all our jewelry are Ready-To-Ship.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div>-->
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
                  
                        <div class="row">
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
                  
                        <div class="row">
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
                  
                        <div class="row">
                            We source all the diamonds directly from the manufacturers. Diamonds used are all Natural / Mined Diamonds with best of its specified color(E-F) and clarity(VS-SI) or better.
                        </div>
                        
                    
                </div>

            </div>
        </div>
    </div>
   <?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       <script type="text/javascript">

        jQuery(document).ready( function () {
    
        $(document).on("submit","#videocall",function(e){
	    	e.preventDefault();
	    	$.ajax({
	    		url:'<?php echo base_url().'forms/videocall'?>',
	    		method:"POST",
	    		data:new FormData(this),
	    		contentType: false,
	            cache: false,
	            processData:false,
	           
	    		success(response){
	    			var obj =  JSON.parse(response);
	    			if(obj.status){
	    				setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    });
           
                },1000); 
	    				$("#video__call").modal('toggle');
	    				//toastr.success('Sent successfully.');	
	    			}
	    		}
	    	})
	    })     
           
        });

    </script>

</body>

</html>
   