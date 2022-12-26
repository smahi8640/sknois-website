<?php 
$this->db = \Config\Database::connect();
$request = \Config\Services::request();
$controller  = $request->uri->getSegment(3);
//$product_reviews = $this->db->where('product_id', $record->id)->get('product_reviews')->result();

/*$max = 0;
$n = count($product_reviews); // get the count of comments
foreach ($product_reviews as $rate => $count) { // iterate through array
	$max = $max+$count->rating;
}
$rating_average = $max / $n;*/

//$product_details=$this->db->query("SELECT * FROM product_details WHERE final_price = ( SELECT final_price FROM product_details where product_id='".$product_details->id."' order by stock desc,final_price asc limit 1) and product_id='".$record->id."'")->row();
$category=explode(',',$record['category_ids']);

$categories= $this->db->query("select * from  categories where parent_id='0' and id='".$category[0]."' and status='1'")->getRow();


$siteconfiguration= $this->db->query("select * from  settings_siteconfiguration ")->getRow();
?>
<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<main>
<section class="breadcum--block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcum__main">
                    <ul class="d-flex align-items-center">
                        <li>Home</li>
                        <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/down-arrow.svg" alt="Arrow"></li>
                        <li>
                        <?= $categories->title?>
                        </li>
                        <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/down-arrow.svg" alt="Arrow"></li>
                        <li class="active"><?php echo $record['title']; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="single__product--block">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 left__column" id="image1">
                <div class="single__product">
                    <div class="large__image slider-for">
                        <?php 
                           $videos = json_decode($record['video']);
                            foreach($videos AS $video) { 
                            if($video->type=="white"){?>
                            <div class="large__image__item">
                                <a href="javascript: void(0);">
                                    <video width="100%" height="100%" loop="true" playsinline autoplay="autoplay" controls muted>
                                        <source src="<?php echo base_url('media/source/'.'/'.$video->video); ?>" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </a>
                            </div>    
                        <?php }}?>
                        <div class="large__image__item">
                            <a href="<?php echo base_url('media/source/'.'/'.$record['intro_zoom']); ?>"  data-lightbox="image-1">
								<?php  
									$img = base_url('media/source/').'/'.$record['intro_image'];
								?>
                                <img src="<?php echo $img; ?>" alt="Product">
                            </a>
                        </div>
                        <?php 
                        
                          if(@$record['white_multi_image'] != '') {
                            $white_multi_image = json_decode($record['white_multi_image']);
                          } else {
                            $white_multi_image = array();
                          }
                          foreach($white_multi_image AS $white_multi_img) { 
                             
                        ?>
                        <div class="large__image__item">
                            <a href="<?php echo base_url('media/source/'.'/'.$white_multi_img->zoom); ?>"  data-lightbox="image-1">
								<?php  
									$img = base_url('media/source/').'/'.$white_multi_img->image;
								?>
                                <img src="<?php echo $img; ?>" alt="Product">
                            </a>
                        </div>
                        <?php }?>
                    </div>
                    
                    <div class="small__image slider-nav">
                      <?php 
                           $videos = json_decode($record['video']);
                            foreach($videos AS $video) { 
                            if($video->type=="white"){?>
                             <div class="small__image__item video">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/video_thumb.png" alt="Video">
                            </div>  
                        <?php }}?>    
                        <div class="small__image__item">
							<?php 
								$img = base_url('media/source/').'/'.$record['intro_image'];
								
							?>                           
                            <img src="<?php echo $img; ?>" alt="Product">
                        </div>
                       <?php 
                        
                          if(@$record['white_multi_image'] != '') {
                            $white_multi_image = json_decode($record['white_multi_image']);
                          } else {
                            $white_multi_image = array();
                          }
                          foreach($white_multi_image AS $white_multi_img) { 
                             
                        ?>
                        <div class="small__image__item">
							<?php 
								$img = base_url('media/source/').'/'.$white_multi_img->image;
								
							?>                           
                            <img src="<?php echo $img; ?>" alt="Product">
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 right__column">
                <div class="product__details">
                    <div class="single__product__title">
                        <div class="single__main__title d-flex justify-content-between" style="margin-bottom:5px;">
                            <h3><?php echo $record['title']; ?></h3>
                            <a href="#" data-toggle="modal" id="help_"><span class="help">Help?</span></a>
                        </div>
                        <div class="single__sub__title">
                            <div class="row align-items-end"  style="margin-bottom:5px;">
                                <div class="col-md-6">
                                    <!--<a class="ref__to_details" href="#about__products">Product Details</a>-->
                                    <h6>Style No : <?php echo $record['style_no'];?></h6>
                                    
                                </div>
                                <!--<div class="col-md-6">
                                    <div class="product__sharing d-flex align-items-end justify-content-end" style="margin-bottom:7px;margin-right: 3px;">
                                        <div class="social__sharing d-flex align-items-center">
                                            <ul class="d-flex align-items-center">
                                                <li style="margin-left:35px;margin-right:0px;">
                                                    <a href="http://www.facebook.com/share.php?u=<?//= BASE.$request->uri->getPath();?>&title=<?php echo $record['title']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/facebook_icon.svg" alt="Facebook"></a>
                                                </li>
                                                <li style="margin-left:35px;margin-right:0px;">
                                                    <a href="https://twitter.com/intent/tweet?url=<?//= BASE.$request->uri->getPath();?>&text=<?php echo $record['title']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/twitter_icon.svg" alt="Twitter"></a>
                                                </li>
                                                <li style="margin-left:35px;margin-right:0px;">
                                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?//= BASE.$request->uri->getPath();?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/instagram_icon.svg" alt="Instagram"></a>
                                                </li>
                                                <li style="margin-left:35px;margin-right:0px;">
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                                
                            <div class="row align-items-end">
                                <div class="col-md-9">
                                    <!--<a class="ref__to_details" href="#about__products">Product Details</a>-->
                                    <!--<h5>Style No : <?php echo $record['style_no'];?></h5>-->
                                    <h4 id="description"><?php 
                                    echo nl2br($record['product_short_description']); ?></h4>
                                </div>
                                <!--<div class="col-md-6">
                                    <div class="product__sharing d-flex align-items-end justify-content-end mb-0">
                                        <div class="social__sharing d-flex align-items-center">
                                            <ul class="d-flex align-items-center">
                                                <li>
                                                    <a href="http://www.facebook.com/share.php?u=<?//= BASE.$request->uri->getPath();?>&title=<?php echo $record['title']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/facebook_icon.svg" alt="Facebook"></a>
                                                </li>
                                                <li>
                                                    <a href="https://twitter.com/intent/tweet?url=<?//= BASE.$request->uri->getPath();?>&text=<?php echo $record['title']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/twitter_icon.svg" alt="Twitter"></a>
                                                </li>
                                                <li>
                                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?//= BASE.$request->uri->getPath();?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/instagram_icon.svg" alt="Instagram"></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-sm-9"><hr style="margin-top:12px;"/></div>
                        <div class="col-md-3 col-sm-3">
                            <div class="product__sharing d-flex align-items-end justify-content-end" style="margin-bottom:7px;margin-right: 3px;">
                                        <div class="social__sharing d-flex align-items-center">
                                            <ul class="d-flex align-items-center">
                                                <li style="margin-left:0px;">
                                                    <a href="http://www.facebook.com/share.php?u=<?//= BASE.$request->uri->getPath();?>&title=<?php echo $record['title']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/facebook_icon.svg" alt="Facebook"></a>
                                                </li>
                                                <li>
                                                    <a href="https://twitter.com/intent/tweet?url=<?//= BASE.$request->uri->getPath();?>&text=<?php echo $record['title']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/twitter_icon.svg" alt="Twitter"></a>
                                                </li>
                                                <li>
                                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?//= BASE.$request->uri->getPath();?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/instagram_icon.svg" alt="Instagram"></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                        </div>
                            
                        <div class="col-md-9 col-sm-9">
                            <div class="single__product__price">
                                <div class="price__main">
                                    <?php if($record['price_default']=="0" || $record['mrp_default']==$record['price_default']){?>
                                        <h2 class="p_final_price">$ <?= $record['price_default'] ?> </h2>
                                        
                                    <?php }else{?>
                                        <h2 class="p_final_price">$ <?= $record['price_default'] ?> <span class="offer">$ <?= $record['mrp_default'] ?></span></h2>
                                    <?php }?>
                                </div>                                
                            </div>
                            <form class="mb-0" action="<?php // echo base_url('addtocart'); ?>" method="post" id="addtocart-form">
                                <div class="row">
                                    <?php if($record['is_size']=='1'){ ?>
                                    <div class="form-group col-md-6" id="size">
                                        <label for="">Size:</label>
                                        <a href="#" data-toggle="modal" data-target="#ring__size"><span class="suggetion float-right" style="margin-top: 3px;">Don't know your ring size?</span></a>
                                        <div class="custom__dropdown">
                                            <select class="form-control " id="product_size" name="product_size" id="product_size">
                                                <?php  
                                                foreach($size as $i){
                                                    $select="";
                                                    if($record['size_default']=="$i->size"){
                                                        $select="selected";
                                                    }
                                                ?>
                                                    <option value="<?php echo $i->size;?>" <?= $select ?>>US <?php echo $i->size;?></option>
                                                <?php }?>
                                            </select>
                                            
                                        </div>
                                        <p id="delivery" class="text-danger mb-0">price may change as per selection </p>
                                    </div>
                                    <?php }?>
                                    <!--<div class="form-group" id="diamonds">
                                        <label for="">Center Diamond:</label>
                                        <a href="#" id="dg" data-id='' data-toggle="modal" data-target="#diamond_guide" ><span class="suggetion float-right">know your diamond</span></a>
                                        <div class="custom__dropdown">
                                            <select class="form-control"   name="product_diamond" id="product_diamond">
                                                <?php  
                                                //for($i=1;$i<=5;$i++){ ?>
                                                    <option value="<?php //echo $i;?>"><?php //echo $i;?></option>
                                                <?php //}?>
                                            </select>
                                        </div>
                                    </div>-->
                                    <div class="form-group diamonds__purity custom-control-inline col-md-12">
                                        <label class="mr-3" for="">Purity:</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="14K" value="14K" name="purity" <?= ($record['purity_default']=="14K")?"checked":""; ?> >
                                            <label class="custom-control-label" for="14K">14K</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="18K" value="18K" name="purity" <?= ($record['purity_default']=="18K")?"checked":"";?>>
                                            <label class="custom-control-label" for="18K">18K</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="product__colors__options mb-4">
                                    <h4>available color options:</h4>
                                    <div class="product__colors d-flex align-content-center">
                                        <div class="product__color">
                                            <input type="radio" id="white" name="colors" class="custom__input" <?= ($record['color_default']=="White")?"checked":""?> value="White">
                                            <label class="custom__label mb-0" for="white">
                                                <img src="https://www.treasta.com/assets1/frontend/img/g_white.png" alt="Color">
                                            </label>
                                            <span>White</span>
                                        </div>
                                        <div class="product__color">
                                            <input type="radio" id="yellow" name="colors" class="custom__input" value="Yellow" <?= ($record['color_default']=="Yellow")?"checked":""?>>
                                            <label class="custom__label mb-0" for="yellow">
                                                <img src="https://www.treasta.com/assets1/frontend/img/g_yellow.png" alt="Color">
                                            </label>
                                            <span>Yellow</span>
                                        </div>
                                        <div class="product__color">
                                            <input type="radio" id="pink" name="colors" class="custom__input" value="Pink" <?= ($record['color_default']=="Pink")?"checked":""?>>
                                            <label class="custom__label mb-0" for="pink">
                                                <img src="https://www.treasta.com/assets1/frontend/img/g_pink.png" alt="Color">
                                            </label>
                                            <span>Pink</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group order__btns mb-0">
                                    <input type="hidden" id="stock_id" value="<?= $record['stock_id_default']?>"/>
                                    <a id="addcart" class="btn btn__notify effect__btn d-none">Add to cart</a>
                                    <a class="btn btn__notify effect__btn d-none" data-toggle="modal" data-target="#notify__me">Notify Me</a>
                                    <a class="btn btn__notify effect__btn " id="madetoorder" data-toggle="modal" data-target="#made__order">Made to Order</a>
                                    <p id="delivery" class="mb-0 mt-1 text-danger" >Get it delivered in 21 business days!</p>
                                </div>
                                <!--<div class="form-group order__btns col-md-6">
                                    <a href="#" class="btn btn__video__call effect__btn" data-toggle="modal" data-target="#video__call"><img class="in__svg" src="<?php //echo base_url('assets/frontend/'); ?>img/video-camera-with-play-button.svg" alt=""> Video Call</a>
                                </div>-->
        						
                             </form>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="servies__list bg-transparent p-0">
                                <div class="servie__item">
                                   <a href="#" data-toggle="modal" data-target="#modal__s3"> <img src="<?php echo base_url('assets/frontend/')?>/img/services/service3.png" alt="services"></a>
                                </div>
                                <div class="servie__item">
                                    <a href="#" data-toggle="modal" data-target="#modal__s5"> <img src="<?php echo base_url('assets/frontend/')?>/img/services/service5.png" alt="services"></a>
                                </div>
                                <div class="servie__item">
                                   <a href="#" data-toggle="modal" data-target="#modal__s6">  <img src="<?php echo base_url('assets/frontend/')?>/img/services/service6.png" alt="services"></a>
                                </div>
                                <div class="servie__item">
                                   <a href="#" data-toggle="modal" data-target="#modal__s7">  <img src="<?php echo base_url('assets/frontend/')?>/img/services/service7.png" alt="services"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 mt-5">
                <div id="about__products" class="about__products">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="about__products__item">
                                <h5>Product Details</h5>
                                <?php $diamond_data = json_decode($record['diamond_data']); ?>
                                <p><strong>Product Code: </strong><span id="sku"><?= $record['sku_default']?></span> </p>
                                <p><strong>Total diamond weight:</strong> <?= $diamond_data[0]->weight.' '.$diamond_data[0]->unit?></p>
                                <p><strong>Diamond origin:</strong> <?=($record['types']=="1")?"Natural":"Lab Grown"?></p>
                                <p><strong>Diamond color:</strong> <?= $diamond_data[0]->color?></p>
                                <p><strong>Diamond clarity:</strong> <?= $diamond_data[0]->clarity?></p>
                                <p><strong>Jewelry certified by:</strong> <?= $record['lab_name']?></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="about__products__item">
                                <h5>Metal Details</h5>
                                <p id="metaldata"><b>Metal : </b> Gold<br><b>Metal Color : </b>  <?= $record['color_default']?><br><b>Metal Purity : </b> <?= $record['purity_default']?></p>
                            </div>
                        </div>
                        <?php $chain_data = json_decode($record['chain_data']); 
                         if($chain_data[0]->types){
                        ?>
                        
                        <div class="col-md-4 col-sm-4">
                            <div class="about__products__item">
                                <h5>Chain Details</h5>
                                
                                <?php if($chain_data[0]->weight){ ?>
                                <p><strong>Chain weight:</strong> <?= $chain_data[0]->weight ?></p>
                                <?php }?>
                                <?php if($chain_data[0]->types){ ?>
                                <p><strong>Chain type:</strong> <?= $chain_data[0]->types?></p>
                                <?php }?>
                                <?php if($chain_data[0]->adjustable){ ?>
                                <p><strong>Adjustable:</strong> <?= $chain_data[0]->adjustable?></p>
                                <?php }?>
                                <p id="chaindata"></p>
                            </div>
                        </div>
                        <?php }?>
                        <div class="col-md-12">
                            <div class="about__products-des">
                                <p><?= nl2br($record['description'])?></p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>    
        </div>
    </div>
</section>



<section class="related__product--block">
            <div class="container">
                <div class="row">
                    <div class="related__product__title col-lg-12">
                        <h1>You may love to view this</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="related__product">
                            <div class="slider-nav">
                                
                            <?php 
                            if($record['related_product_ids']){
                                $rproducts=explode(',',$record['related_product_ids']);
                                
                                foreach($rproducts as $products){
                                    $product_details = $this->db->query("SELECT products.*,product_stock.price_default,product_stock.mrp_default,product_stock.color_default,product_stock.size_default,product_stock.purity_default,product_stock.stock_default,product_stock.sku_default,product_stock.stock_id_default FROM `products` left join product_stock on products.id= product_stock.product_id WHERE product_stock.country_code='231' and products.status='1' and products.id='".$products."'")->getRowArray();
                                    
                            ?>    
                                <div class="product__item">
                                    <div class="product__head">
                                        <div class="product__img">
                                            <a href="<?php echo BASE ?>/products/<?php echo $product_details['alias'].'-'.$product_details['style_no']; ?>">
                        						<?php 
                        						    $img = base_url('media/source/').'/'.$product_details['intro_image'];
                        						?>
                                                <img src="<?php echo $img; ?>" alt="">
                                            </a>
                                        </div>
                                      
                                        
                                    </div>
                                    <div class="product__content justify-content-center align-items-center">
                                     
                                        <div class="product__name">
                                            <h4 class="name"><a href="<?php echo BASE.'products/'.$product_details['alias'].'-'.$product_details['style_no']; ?>"><?php echo $product_details['title']; ?></a></h4>
                                            <h4><?php echo nl2br($product_details['product_short_description']); ?></h4>
                                        </div>
                                        
                                    </div>
                                    <div class="price d-flex justify-content-center align-items-center">
                                           
                                            <?php 
                                                 if($product_details['price_default']=="0" || $product_details['mrp_default']==$product_details['price_default']){?>
                                                <h4>$ <?php echo $product_details['price_default']; ?></h4> 
                                            <?php }else{?> 
                                                <h4>$ <?php echo $product_details['price_default']; ?> 
                                                <span class="offer">$ <?php echo $product_details['mrp_default']; ?></span>
                                                </h4>
                                            <?php }?>
                                        </div>
                                </div>
                            <?php }}?>    
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<div class="ring__size__popup modal fade " id="help__" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">NEED ASSISTANCE</h5>
                    <p>CALL US AT <?php echo $siteconfiguration->site_contact_number; ?></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="sendhelp" method="POST">
                         <div class="row">
                            <div class="form-group col-sm-6">
                                <input type="text" class="form-control" name="fullname" id="fullname" required="" placeholder="Enter your name">
                            </div>
                          
                            <div class="form-group col-sm-6">
                                <input type="email" class="form-control" name="email" id="email" required="" placeholder="Enter your email">
                            </div>
                            <div class="form-group col-sm-6">
                                <input type="number" class="form-control" name="mobile"  id="mobile" placeholder="Enter your mobile">
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="text" class="form-control" name="query" id="query" placeholder="Enter your query">
                            </div>
                            
                        </div>
                        <input type="hidden" name="help_id" value="<?php echo $record['id'];?>" />
                        <input type="hidden" name="is_set" value="0" />
                        <div class="ring__size__btns d-flex align-items-center justify-content-between">
                            <button class="btn submit__btn effect__btn">Submit</button>                            
                        </div>
                    </form>
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
                  
                        <div class="row">
                            All Joyari products comes with Certificate of Authentication and Hallmark. All jewelry are certified inhouse by Joyari.com under International quality protocol.
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
<script>
    function getData(size,purity,color){
       var id='<?= @$record['id'] ?>';
       var s=size;
       if(size===null){
           s=0;
       }
        var html;
        var metalhtml;
        $.ajax({
            url:'<?php echo base_url().'/products/stockfilterajax'?>',
            method:"POST",
            data:{id:id,size:s,purity:purity,color:color},
            success(response){
                var obj =  JSON.parse(response);
                    if(obj.status=="1"){
                        
                        if(obj.data.price!=obj.data.mrp){
                            html='<h2 class="p_final_price">$ '+ obj.data.price +' <span class="offer">$ '+ obj.data.mrp +'</span></h2>';
                        }else{
                            html='<h2 class="p_final_price">$ '+ obj.data.price +'</h2>';  
                        }
                        $('.price__main').html(html);
                        metalhtml='<b>Metal : </b> Gold<br><b>Metal Color : </b>  '+obj.data.color+'<br><b>Metal Purity : </b> '+obj.data.purity;
                        $('#metaldata').html(metalhtml);
                        <?php $chain_data = json_decode($record['chain_data']); 
                         if($chain_data[0]->metal){
                        ?>
                        $('#chaindata').html(metalhtml);
                        <?php }?>
                        $('#sku').html(obj.data.sku);
                        $('#stock_id').val(obj.data.id);
                        
                        if(obj.data.stock>0){
                            $('#addcart').removeClass('d-none');
                            $('#madetoorder').addClass('d-none');
                        }else{
                            $('#addcart').addClass('d-none');
                            $('#madetoorder').removeClass('d-none');
                        }
                    }
            }
        })
    }
    
    
    function getImages(color){
        
        if(color=="White"){
            var html='<div class="single__product">';
                html+='<div class="large__image slider-for">';
                
                <?php 
                $videos = json_decode($record['video']);
                foreach($videos AS $video) { 
                if($video->type=="white"){?>
                html+='<div class="large__image__item">';
                html+='<a href="javascript: void(0);">';
                html+='<video width="100%" height="100%" loop="true" autoplay="autoplay" playsinline controls muted ><source src="<?php echo base_url('media/source/'.'/'.$video->video); ?>" type="video/ogg">Your browser does not support the video tag.</video>';
                html+='</a>';
                html+='</div>';    
                <?php }}?>  
                
                html+='<div class="large__image__item">';
                html+='<a href="<?php echo base_url('media/source/'.'/'.$record['intro_zoom']); ?>"  data-lightbox="image-1">';
    						<?php  
    								$img = base_url('media/source/').'/'.$record['intro_image'];
    						
    						?>
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</a>';
                html+='</div>';
                    <?php 
                    
                      if(@$record['white_multi_image'] != '') {
                        $white_multi_image = json_decode($record['white_multi_image']);
                      } else {
                        $white_multi_image = array();
                      }
                      foreach($white_multi_image AS $white_multi_img) { 
                         
                    ?>
                html+='<div class="large__image__item">';
                html+='<a href="<?php echo base_url('media/source/'.'/'.$white_multi_img->zoom); ?>"  data-lightbox="image-1">';
    						<?php  
    								$img = base_url('media/source/').'/'.$white_multi_img->image;
    						
    						?>
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</a>';
                html+='</div>';
                    <?php }?>
                html+='</div>';
                
                html+='<div class="small__image slider-nav">';
                <?php 
                $videos = json_decode($record['video']);
                foreach($videos AS $video) { 
                if($video->type=="white"){?>
                html+='<div class="small__image__item video">';
                html+='<img src="<?php echo base_url('assets/frontend/'); ?>/img/video_thumb.png" alt="Video">';
                html+='</div>'; 
                <?php }}?>    
                html+='<div class="small__image__item">';
    						<?php 
    							$img = base_url('media/source/').'/'.$record['intro_image'];
    							
    						?>                           
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</div>';
                   <?php
                      if(@$record['white_multi_image'] != '') {
                        $white_multi_image = json_decode($record['white_multi_image']);
                      } else {
                        $white_multi_image = array();
                      }
                      foreach($white_multi_image AS $white_multi_img) { 
                         
                    ?>
                html+='<div class="small__image__item">';
    						<?php 
    							$img = base_url('media/source/').'/'.$white_multi_img->image;
    							
    						?>                           
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</div>';
                    <?php }?>
                html+='</div>';
                
                html+='</div>';
        }
        if(color=="Yellow"){
            var html='<div class="single__product">';
                html+='<div class="large__image slider-for">';
                
                <?php 
                $videos = json_decode($record['video']);
                foreach($videos AS $video) { 
                if($video->type=="yellow"){?>
                html+='<div class="large__image__item">';
                html+='<a href="javascript: void(0);">';
                html+='<video width="100%" height="100%" loop="true" autoplay="autoplay" playsinline controls muted ><source src="<?php echo base_url('media/source/'.'/'.$video->video); ?>" type="video/ogg">Your browser does not support the video tag.</video>';
                html+='</a>';
                html+='</div>';    
                <?php }}?>  
                
                html+='<div class="large__image__item">';
                html+='<a href="<?php echo base_url('media/source/'.'/'.$record['yellow_zoom']); ?>"  data-lightbox="image-1">';
    						<?php  
    								$img = base_url('media/source/').'/'.$record['yellow_image'];
    						
    						?>
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</a>';
                html+='</div>';
                    <?php 
                    
                      if(@$record['yellow_multi_image'] != '') {
                        $yellow_multi_image = json_decode($record['yellow_multi_image']);
                      } else {
                        $yellow_multi_image = array();
                      }
                      foreach($yellow_multi_image AS $yellow_multi_img) { 
                         
                    ?>
                html+='<div class="large__image__item">';
                html+='<a href="<?php echo base_url('media/source/'.'/'.$yellow_multi_img->zoom); ?>"  data-lightbox="image-1">';
    						<?php  
    								$img = base_url('media/source/').'/'.$yellow_multi_img->image;
    						
    						?>
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</a>';
                html+='</div>';
                    <?php }?>
                html+='</div>';
                
                html+='<div class="small__image slider-nav">';
                
                <?php 
                $videos = json_decode($record['video']);
                foreach($videos AS $video) { 
                if($video->type=="yellow"){?>
                html+='<div class="small__image__item video">';
                html+='<img src="<?php echo base_url('assets/frontend/'); ?>/img/video_thumb.png" alt="Video">';
                html+='</div>'; 
                <?php }}?> 
                
                html+='<div class="small__image__item">';
    						<?php 
    							$img = base_url('media/source/').'/'.$record['yellow_image'];
    							
    						?>                           
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</div>';
                   <?php
                      if(@$record['yellow_multi_image'] != '') {
                        $yellow_multi_image = json_decode($record['yellow_multi_image']);
                      } else {
                        $yellow_multi_image = array();
                      }
                      foreach($yellow_multi_image AS $yellow_multi_img) { 
                         
                    ?>
                html+='<div class="small__image__item">';
    						<?php 
    							$img = base_url('media/source/').'/'.$yellow_multi_img->image;
    							
    						?>                           
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</div>';
                    <?php }?>
                html+='</div>';
                
                html+='</div>';
        }
        if(color=="Pink"){
            var html='<div class="single__product">';
                html+='<div class="large__image slider-for">';
                <?php 
                $videos = json_decode($record['video']);
                foreach($videos AS $video) { 
                if($video->type=="pink"){?>
                html+='<div class="large__image__item">';
                html+='<a href="javascript: void(0);">';
                html+='<video width="100%" height="100%" loop="true" autoplay="autoplay" playsinline controls muted ><source src="<?php echo base_url('media/source/'.'/'.$video->video); ?>" type="video/ogg">Your browser does not support the video tag.</video>';
                html+='</a>';
                html+='</div>';    
                <?php }}?>  
                html+='<div class="large__image__item">';
                html+='<a href="<?php echo base_url('media/source/'.'/'.$record['pink_zoom']); ?>"  data-lightbox="image-1">';
    						<?php  
    								$img = base_url('media/source/').'/'.$record['pink_image'];
    						
    						?>
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</a>';
                html+='</div>';
                    <?php 
                    
                      if(@$record['pink_multi_image'] != '') {
                        $pink_multi_image = json_decode($record['pink_multi_image']);
                      } else {
                        $pink_multi_image = array();
                      }
                      foreach($pink_multi_image AS $pink_multi_img) { 
                         
                    ?>
                html+='<div class="large__image__item">';
                html+='<a href="<?php echo base_url('media/source/'.'/'.$pink_multi_img->zoom); ?>"  data-lightbox="image-1">';
    						<?php  
    								$img = base_url('media/source/').'/'.$pink_multi_img->image;
    						
    						?>
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</a>';
                html+='</div>';
                    <?php }?>
                html+='</div>';
                
                html+='<div class="small__image slider-nav">';
                
                <?php 
                $videos = json_decode($record['video']);
                foreach($videos AS $video) { 
                if($video->type=="pink"){?>
                html+='<div class="small__image__item video">';
                html+='<img src="<?php echo base_url('assets/frontend/'); ?>/img/video_thumb.png" alt="Video">';
                html+='</div>'; 
                <?php }}?> 
                
                html+='<div class="small__image__item">';
    						<?php 
    							$img = base_url('media/source/').'/'.$record['pink_image'];
    							
    						?>                           
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</div>';
                   <?php
                      if(@$record['pink_multi_image'] != '') {
                        $pink_multi_image = json_decode($record['pink_multi_image']);
                      } else {
                        $pink_multi_image = array();
                      }
                      foreach($pink_multi_image AS $pink_multi_img) { 
                         
                    ?>
                html+='<div class="small__image__item">';
    						<?php 
    							$img = base_url('media/source/').'/'.$pink_multi_img->image;
    							
    						?>                           
                html+='<img src="<?php echo $img; ?>" alt="Product">';
                html+='</div>';
                    <?php }?>
                html+='</div>';
                
                html+='</div>';
        }
        html+='<script src="<?php echo base_url('assets/frontend//js/main.js')?>"/>';   
        $('#image1').html(html);
    }
    
   
    $(document).on("change","#product_size",function(){
        var size = $("#product_size").val();
        //var diamond = $("#product_diamond").val();
		var purity=$('input[name="purity"]:checked').val();
		var color=$('input[name="colors"]:checked').val();
			getData(size,purity,color);
			
       });
       
   /* $(document).on("change","#product_diamond",function(){
        var size = $("#product_size").val();
        //var diamond = $("#product_diamond").val();
		var purity=$('input[name="purity"]:checked').val();
		var color=$('input[name="colors"]:checked').val();
			getData(size,diamond,purity,color);
			
       }); */
       
    $(document).on("change","input[type=radio][name=purity]",function(){
        var size = $("#product_size").val();
        //var diamond = $("#product_diamond").val();
		var purity=$('input[name="purity"]:checked').val();
		var color=$('input[name="colors"]:checked').val();
			getData(size,purity,color);
			
       });    
       
    $(document).on("change","input[type=radio][name=colors]",function(){
        var size = $("#product_size").val();
        //var diamond = $("#product_diamond").val();
		var purity=$('input[name="purity"]:checked').val();
		var color=$('input[name="colors"]:checked').val();
			getData(size,purity,color);
			
			getImages(color);
			
       });
       
      $('#addcart').on('click',function(){
            
        var product_id = '<?= @$record['id'] ?>';
        var quantity = '1';
        var stock_id=$('#stock_id').val();
        $.ajax({  
            url: '<?= base_url('cart/addtocartAjax'); ?>',
            type: 'post',
            dataType:'json',
            data:{product_id: product_id, quantity: quantity,stock_id:stock_id,type:'1'},
            success:function(response){
                
                console.log(response); 
                if(response.status=='1'){
                $('.cart__count').html(response.cart_count);
                alert('Product successfully added in cart.');
                }else{
                    alert(response.message);
                }

            }  
        });

    });  
    
    $('#madetoorder').on('click',function(){
            
        var product_id = '<?= @$record['id'] ?>';
        var quantity = '1';
        var stock_id=$('#stock_id').val();
        $.ajax({  
            url: '<?= base_url('cart/addtocartAjax'); ?>',
            type: 'post',
            dataType:'json',
            data:{product_id: product_id, quantity: quantity,stock_id:stock_id,type:'2'},
            success:function(response){
                
                console.log(response); 
                if(response.status=='1'){
                $('.cart__count').html(response.cart_count);
                    alert('Product successfully added in cart.');
                }else{
                    alert(response.message);
                }

            }  
        });

    });  
    
             $(document).on("click","#help_",function(){
                 
                $("#help__").modal('toggle');
            });
            
			 $(document).on("submit","#sendhelp",function(e){
            
        		e.preventDefault();
        		$.ajax({
        			url:'<?php echo base_url('forms/help'); ?>',
        			method:"POST",
        			data:new FormData(this),
        			contentType: false,
        			cache: false,
        			processData:false,
            		success(response){
        			    var obj =  JSON.parse(response);
            			
                            alert(obj.message);
                            $("#help__").modal('toggle');
                            //window.location.reload();
                              
            		}
        		})
        	});
</script>

<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>