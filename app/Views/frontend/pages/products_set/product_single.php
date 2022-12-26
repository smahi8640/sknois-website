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

<?php 
    $products=explode(",",$record['product_id']);
    $price="0";
    $mrp="0";
    $stock_id="";
    foreach($products as $l){ 
        $product= $this->db->query("select * from  products left join product_stock on products.id=product_stock.product_id where products.id='".$l."' and product_stock.country_code='231'")->getRowArray();
        $price=$product['price_default']+$price;
        $mrp=$product['mrp_default']+$mrp;
        $stock_id=$product['stock_id_default'].','.$stock_id;
    }
    
?>
                        
<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>
<script>
    $(document).ready(function(){
        $('input[type=checkbox]').prop('checked',true);
    });
</script>
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
                            </div>
                            
                            <div class="row align-items-end">
                                <div class="col-md-9">
                                    <h4 id="description"><?php 
                                    echo nl2br($record['product_short_description']); ?></h4>
                                </div>    
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
                                    
                                    <?= ($price!=$mrp)?'<h2 class="p_final_price">$ '.$price.' <span class="offer">$ '.$mrp.'</span></h2>':'<h2 class="p_final_price">$ '.$price.'</h2>'; ?>
                                </div>     
                                <p id="delivery" class="text-danger" >price may change as per selection </p>
                                
                            </div>
                            <form class="mb-0" action="<?php // echo base_url('addtocart'); ?>" method="post" id="addtocart-form">
                                
                                <div class="form-group order__btns mb-5" style="margin-top:60px;">
                                    <input type="hidden" value="<?= $price ?>" id="tot_price"/>
                                    <input type="hidden" value="<?= $mrp ?>" id="tot_mrp"/>
                                    <input type="hidden" value="<?= $stock_id ?>" id="product_stock_id"/>
                                    <input type="hidden" id="stock_id" />
                                    <a id="addcart" class="btn btn__notify effect__btn d-none">Add to cart</a>
                                    <a class="btn btn__notify effect__btn d-none" data-toggle="modal" data-target="#notify__me">Notify Me</a>
                                    <a class="btn btn__notify effect__btn " id="madetoorder" data-toggle="modal" data-target="#made__order">Made to Order</a>
                                    <p id="delivery" class="mb-0 mt-1 text-danger" >Get it delivered in 21 business days!</p>
                                </div>
        						
                             </form>
                        </div>
                    </div>    
                    <div class="row mt-3">    
                        <div class="col-md-12 col-sm-12">
                            <div class="servies__list d-flex align-items-center justify-content-center">
                                <div class="servie__item mr-5">
                                   <a href="#" data-toggle="modal" data-target="#modal__s1"> <img src="<?php echo base_url('assets/frontend/')?>/img/services/service3.png" alt="services"></a>
                                </div>
                                <div class="servie__item mr-5">
                                    <a href="#" data-toggle="modal" data-target="#modal__s2"> <img src="<?php echo base_url('assets/frontend/')?>/img/services/service5.png" alt="services"></a>
                                </div>
                                <div class="servie__item mr-5">
                                   <a href="#" data-toggle="modal" data-target="#modal__s3">  <img src="<?php echo base_url('assets/frontend/')?>/img/services/service6.png" alt="services"></a>
                                </div>
                                <div class="servie__item ">
                                   <a href="#" data-toggle="modal" data-target="#modal__s4">  <img src="<?php echo base_url('assets/frontend/')?>/img/services/service7.png" alt="services"></a>
                                </div>
                            </div>    
                        </div>       
                    </div>
                </div>
            </div>    
        </div>  
        <div id="about__products" class="row mt-5">
            <div class="col-lg-12">
                <div class="combo__product">
                    <div class="row">
                        
                        <?php 
                        $products=explode(",",$record['product_id']);
                        foreach($products as $l){ 
                            $product= $this->db->query("select products.*,product_stock.price_default,product_stock.mrp_default,product_stock.color_default,product_stock.size_default,product_stock.purity_default,product_stock.stock_default,product_stock.sku_default,product_stock.stock_id_default from  products left join product_stock on products.id=product_stock.product_id where products.id='".$l."' and product_stock.country_code='231'")->getRowArray();
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-6" id="fade_<?= $product['id']?>">
                            <div class="combo__item product__item">
                                <div class="remove__product">
                                    <input type="checkbox" autocomplete="off" name="product_set[]" value="<?= $product['id']?>"/>
                                </div>
                                <div class="product__img">
                                    <a href="<?php echo base_url('/products/'.$product['alias'].'-'.$product['style_no']); ?> " tabindex="0">
                                        <?php 
                    					    $img = base_url('media/source/').'/'.$product['intro_image'];
                    					?>
                                        <img src="<?php echo $img; ?>" alt="" id="img_<?= $product['id']?>">
                                    </a>
                                </div>
                                <div class="combo__details">
                                    <h4><?php echo $product['title']; ?></h4>
                                    <h5 class="price" id="p_price_<?= $product['id']?>">
                                        <?= ($product['price_default']!=$product['mrp_default'])?'<span class="p_final_price">$ '.$product['price_default'].' <span class="offer">$ '.$product['mrp_default'].'</span></span>':'<span class="p_final_price">$ '.$product['price_default'].'</span>'; ?>
                                    </h5>
                                    <input type="hidden" value="<?= $product['price_default'] ?>" id="tot_price_<?= $product['id']?>"/>
                                    <input type="hidden" value="<?= $product['mrp_default'] ?>" id="tot_mrp_<?= $product['id']?>"/>
                                    <input type="hidden" value="<?= $product['stock_id_default'] ?>" id="product_stock_id_<?= $product['id']?>"/>
                                    <form action="" method="post" id="addtocart-form">
                                        <div class="addtocart__option">
                                            <div class="row">
                                                <?php if($product['is_size']=='1'){ ?>
                                                    <div class="form-group col-md-6" id="size_<?= $product['id'] ?>">
                                                    <label for="">Size:</label>
                                                    <div class="custom__dropdown">
                                                        <select class="form-control " id="product_size_<?= $product['id']?>" name="product_size_<?= $product['id']?>" >
                                                            <?php  
                                                            foreach($size as $i){ ?>
                                                                <option value="<?php echo $i->size;?>" <?= ($product['size_default']==$i->size)? "selected" : "" ;?>><?php echo $i->size;?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <div class="form-group col-md-6 " id="metals">
                                                 <label for="">Metal:</label>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" class="custom-control-input" id="14K_<?= $product['id']?>" value="14K" <?= ($product['purity_default']=='14K')? "checked" : "" ;?> name="purity_<?= $product['id']?>">
                                                        <label class="custom-control-label" for="14K_<?= $product['id']?>">14K</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" class="custom-control-input" id="18K_<?= $product['id']?>" value="18K" <?= ($product['purity_default']=='18K')? "checked" : "" ;?> name="purity_<?= $product['id']?>">
                                                        <label class="custom-control-label" for="18K_<?= $product['id']?>">18K</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12" id="diamonds_<?= $product['id']?>">
                                                <label for="">Color:</label>
                                                <div class="product__colors d-flex align-content-center">
                                                    <div class="product__color">
                                                        <input type="radio" id="white_<?= $product['id']?>" name="colors_<?= $product['id']?>" <?= ($product['color_default']=='White')? "checked" : "" ;?> class="custom__input" checked="" value="White">
                                                        <label class="custom__label mb-0" for="white_<?= $product['id']?>">
                                                            <img src="https://www.treasta.com/assets1/frontend/img/g_white.png" alt="Color">
                                                        </label>
                                                        <span>White</span>
                                                    </div>
                                                    <div class="product__color">
                                                        <input type="radio" id="yellow_<?= $product['id']?>" name="colors_<?= $product['id']?>" class="custom__input" <?= ($product['color_default']=='Yellow')? "checked" : "" ;?> value="Yellow">
                                                        <label class="custom__label mb-0" for="yellow_<?= $product['id']?>">
                                                            <img src="https://www.treasta.com/assets1/frontend/img/g_yellow.png" alt="Color">
                                                        </label>
                                                        <span>Yellow</span>
                                                    </div>
                                                    <div class="product__color">
                                                        <input type="radio" id="pink_<?= $product['id']?>" name="colors_<?= $product['id']?>" class="custom__input" <?= ($product['color_default']=='Pink')? "checked" : "" ;?> value="Pink">
                                                        <label class="custom__label mb-0" for="pink_<?= $product['id']?>">
                                                            <img src="https://www.treasta.com/assets1/frontend/img/g_pink.png" alt="Color">
                                                        </label>
                                                        <span>Pink</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="accordion" id="comboAccordion-1_<?= $product['id']?>">
                                        <div class="card productdetailscard">
                                          <div class="card-header collapsed" id="heading-11_<?= $product['id']?>" data-toggle="collapse" data-target="#combo-11_<?= $product['id']?>" aria-expanded="true" aria-controls="combo-11_<?= $product['id']?>">
                                             <h5 class="mb-0">Product Details</h5>
                                             <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                             <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                                          </div>
                                          <div id="combo-11_<?= $product['id']?>" class="collapse" aria-labelledby="heading-11_<?= $product['id']?>" data-parent="#comboAccordion-1_<?= $product['id']?>">
                                             <div class="card-body" id="p_detail_<?= $product['id']?>">
                                                <?php $diamond_data = json_decode($product['diamond_data']); ?>
                                                <p><b>Product Code :</b> <?= $product['sku_default'] ?></p>
                                                <p><b>Total diamond weight :</b> <?= $diamond_data[0]->weight.' '.$diamond_data[0]->unit?></p>
                                                <p><b>Diamond origin :</b>  <?=($product['types']=="1")?"Natural":"Lab Grown"?></p>
                                                <p><b>Diamond color :</b> <?= $diamond_data[0]->color?></p>
                                                <p><b>Diamond clarity :</b> <?= $diamond_data[0]->clarity?></p>
                                                <p><b>Jewelry certified by :</b> <?= $product['lab_name']?></p>
                                             </div>
                                          </div>
                                        </div>
                                    </div>    
                                    <div class="accordion" id="comboAccordion-11_<?= $product['id']?>">    
                                        <div class="card goldcard">
                                          <div class="card-header collapsed" id="heading-12_<?= $product['id']?>" data-toggle="collapse" data-target="#combo-12_<?= $product['id']?>" aria-expanded="true" aria-controls="heading-12_<?= $product['id']?>">
                                             <h5 class="mb-0">
                                                Metal Details
                                             </h5>
                                             <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                             <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                                          </div>
                                          <div id="combo-12_<?= $product['id']?>" class="collapse goldcollapse" aria-labelledby="heading-12_<?= $product['id']?>" data-parent="#comboAccordion-11_<?= $product['id']?>">
                                             <div class="card-body" id="p_metal_<?= $product['id']?>">
                                                <p><b>Metal :</b> Gold </p>
                                                <p><b>Metal Color :</b> <?= $product['color_default'] ?></p>
                                                <p><b>Metal Purity :</b> <?= $product['purity_default'] ?> </p>
                                             </div>
                                          </div>
                                        </div>
                                        
                                        <div class="card chaincard d-none">
                                          <div class="card-header collapsed" id="heading-13_<?= $product['id']?>" data-toggle="collapse" data-target="#combo-13_<?= $product['id']?>" aria-expanded="true" aria-controls="heading-13_<?= $product['id']?>">
                                             <h5 class="mb-0">
                                                Chain Details
                                             </h5>
                                             <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                             <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                                          </div>
                                          <div id="combo-13_<?= $product['id']?>" class="collapse chaincollapse" aria-labelledby="heading-13_<?= $product['id']?>" data-parent="#comboAccordion-1_<?= $product['id']?>">
                                             <div class="card-body" id="p_chain_<?= $product['id']?>">
                                                
                                             </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
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
                                    $product_details = $this->db->query("SELECT * FROM `products_set` where status='1' and id='".$products."'")->getRowArray();
                                    
                            ?>    
                                <div class="product__item">
                                    <div class="product__head">
                                        <div class="product__img">
                                            <a href="<?php echo BASE ?>products/<?php echo $product_details['alias'].'-'.$product_details['style_no']; ?>">
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
                                           
                                        </div>
                                </div>
                            <?php }}?>    
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <div class="ring__size__popup modal fade" id="modal__s1" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
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
 <div class="ring__size__popup modal fade" id="modal__s2" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
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
    <div class="ring__size__popup modal fade" id="modal__s3" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
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
    <div class="ring__size__popup modal fade" id="modal__s4" tabindex="-1" role="dialog" aria-labelledby="ring__size__Title" aria-hidden="true">
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
                        <input type="hidden" name="is_set" value="1" />
                        <div class="ring__size__btns d-flex align-items-center justify-content-between">
                            <button class="btn submit__btn effect__btn">Submit</button>                            
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> 
<script>

    function getData(size,purity,color,id){
       $('#madetoorder').addClass('d-none');
       var s=size;
       if(size===null){
           s=0;
       }
        var html;
        var metalhtml;
        var producthtml;
        var chainhtml;
        var product_stock_id="";
        $.ajax({
            url:'<?php echo base_url().'/products/stockfilterajax'?>',
            method:"POST",
            data:{id:id,size:s,purity:purity,color:color},
            success(response){
                var obj =  JSON.parse(response);
                    if(obj.status=="1"){
                        if(obj.data.price!=obj.data.mrp){
                            
                            html='<span class="p_final_price">$ '+ obj.data.price +' <span class="offer">$ '+ obj.data.mrp +'</span></span>';
                        }else{
                            html='<span class="p_final_price">$ '+ obj.data.price +'</span>';  
                        }

                        $('#p_price_'+id).html(html);
                        $('#tot_price_'+id).val(obj.data.price);
                        $('#tot_mrp_'+id).val(obj.data.mrp);
                        $('#product_stock_id_'+id).val(obj.data.id)
                        <?php $diamond_data = json_decode($product['diamond_data']); ?>
                        producthtml='<p><b>Product Code :</b> '+obj.data.sku+'</p>';
                        producthtml+='<p><b>Total diamond weight :</b> <?= $diamond_data[0]->weight.' '.$diamond_data[0]->unit?></p>';
                        producthtml+='<p><b>Diamond origin :</b>  <?=($product['types']=="1")?"Natural":"Lab Grown"?></p>';
                        producthtml+='<p><b>Diamond color :</b> <?= $diamond_data[0]->color?></p>';
                        producthtml+='<p><b>Diamond clarity :</b> <?= $diamond_data[0]->clarity?></p>';
                        producthtml+='<p><b>Jewelry certified by :</b> <?= $product['lab_name']?></p>';
                        
                        metalhtml='<p><b>Metal :</b> Gold </p>';
                        metalhtml+='<p><b>Metal Color :</b> '+obj.data.color+'</p>';
                        metalhtml+='<p><b>Metal Purity :</b> '+obj.data.purity+' </p>';
                        
                        <?php $chain_data = json_decode($product['chain_data']); ?>
                        <?php if($chain_data[0]->weight){ ?>
                        chainhtml+='<p><b>Chain weight :</b> <?= $chain_data[0]->weight?></p>';
                        <?php }?>
                        <?php if($chain_data[0]->types){ ?>
                        chainhtml+='<p><b>Chain type :</b>  <?=  $chain_data[0]->types?></p>';
                        <?php }?>
                        <?php if($chain_data[0]->adjustable){ ?>
                        chainhtml+='<p><b>Adjustable :</b> <?= $chain_data[0]->adjustable?></p>';
                        <?php }?>
                        
                        $('#p_detail_'+id).html(producthtml);
                        $('#p_metal_'+id).html(metalhtml);
                        $('#p_chain_'+id).html(chainhtml+metalhtml);
                        $('#stock_id').val(obj.data.id);
                        
                       
                    }
            }
        })
        var mrp="0";
        var price="0";
        setTimeout( function() { 
            
            $('input[name="product_set[]"]:checked').each(function() {
               console.log(this.value);
            

        <?php 
        $products=explode(",",$record['product_id']);
        foreach($products as $l){ 
            $product= $this->db->query("select * from  products where id='".$l."'")->getRowArray();
        ?>
        var pval='<?= $product['id']?>';
            if(this.value==pval){
              price=  Number(price)+Number($('#tot_price_<?= $product['id']?>').val());
              mrp=  Number(mrp)+Number($('#tot_mrp_<?= $product['id']?>').val());
              product_stock_id=$('#product_stock_id_<?= $product['id']?>').val()+','+product_stock_id;
            }
        <?php }?>
            });
        if(price!=mrp){
                tothtml='<h2 class="p_final_price">$ '+ price +' <span class="offer">$ '+ mrp +'</span></h2>';
            }else{
                tothtml='<h2 class="p_final_price">$ '+ price +'</h2>';  
            }
            
            $('#tot_price').val(price);
            $('#tot_mrp').val(mrp);
            $('.price__main').html(tothtml);
            $('#product_stock_id').val(product_stock_id);
            $('#madetoorder').removeClass('d-none');
        }, 1000);
    }
    
  
    
    function getImages(color,white,yellow,pink,id){
        
        if(color=="White"){
           $("#img_"+id).attr("src",'<?php echo base_url('media/source/') ?>/'+white);
        }
        if(color=="Yellow"){
            $("#img_"+id).attr("src",'<?php echo base_url('media/source/') ?>/'+yellow);
        }
        if(color=="Pink"){
            $("#img_"+id).attr("src",'<?php echo base_url('media/source/') ?>/'+pink);
        }
        
    }
    
    
   
    
    $(document).ready( function() {
        
        //Again checked All the checkbox
       
        
        var product_stock_id="";
        
        <?php 
        $products=explode(",",$record['product_id']);
        foreach($products as $l){ 
            $product= $this->db->query("select * from  products where id='".$l."'")->getRowArray();
        ?>
        var id='<?= $product['id']?>';
        var html;
        var tothtml;
        var metalhtml;
        var producthtml;
        
        $.ajax({
            url:'<?php echo base_url().'/products/stockajax'?>',
            method:"POST",
            data:{id:id},
            success(response){
                var obj =  JSON.parse(response);
                    if(obj.status=="1"){
                        if(obj.data.size=='0'){
                            $('#size_<?= $product['id']?>').addClass('d-none');
                            $('#product_size_<?= $product['id']?>').val('');
                        }else{
                            $('#size_<?= $product['id']?>').removeClass('d-none');
                            $('#product_size_<?= $product['id']?>').val(obj.data.size);
                        }
                        //$('#product_size_<?= $product['id']?>').val(obj.data.size);
                        //$('#product_size').change();
                        
                        //$('#product_diamond').val(obj.data.center_diamond);
                        //$('#product_diamond').change();
                        
                        $("input[name=purity_<?= $product['id']?>]").val([obj.data.purity]);
                        $("input[name=colors_<?= $product['id']?>]").val([obj.data.color]);
                        
                        if(obj.data.price!=obj.data.mrp){
                            html='<span class="p_final_price">$ '+ obj.data.price +' <span class="offer">$ '+ obj.data.mrp +'</span></span>';
                        }else{
                            html='<span class="p_final_price">$ '+ obj.data.price +'</span>';  
                        }
                        $('#p_price_<?= $product['id']?>').html(html);
                       
                        $('#tot_price_<?= $product['id']?>').val(obj.data.price);
                        $('#tot_mrp_<?= $product['id']?>').val(obj.data.mrp);
                        $('#product_stock_id_<?= $product['id']?>').val(obj.data.id);
                        
                        product_stock_id=obj.data.id+','+product_stock_id;
                        
                        <?php $diamond_data = json_decode($product['diamond_data']); ?>
                        producthtml='<p><b>Product Code :</b> '+obj.data.sku+'</p>';
                        producthtml+='<p><b>Total diamond weight :</b> <?= $diamond_data[0]->weight.' '.$diamond_data[0]->unit?></p>';
                        producthtml+='<p><b>Diamond origin :</b>  <?=($product['types']=="1")?"Natural":"Lab Grown"?></p>';
                        producthtml+='<p><b>Diamond color :</b> <?= $diamond_data[0]->color?></p>';
                        producthtml+='<p><b>Diamond clarity :</b> <?= $diamond_data[0]->clarity?></p>';
                        producthtml+='<p><b>Jewelry certified by :</b> <?= $product['lab_name']?></p>';
                        
                        metalhtml='<p><b>Metal :</b> Gold </p>';
                        metalhtml+='<p><b>Metal Color :</b> '+obj.data.color+'</p>';
                        metalhtml+='<p><b>Metal Purity :</b> '+obj.data.purity+' </p>';
                        $('#p_detail_<?= $product['id']?>').html(producthtml);
                        $('#p_metal_<?= $product['id']?>').html(metalhtml);
                        
                        $('#stock_id').val(obj.data.id);
                        
                        getImages(obj.data.color,'<?= ($product['intro_image'])?$product['intro_image']:"0";?>','<?= ($product['yellow_image'])?$product['yellow_image']:"0";?>','<?= ($product['pink_image'])?$product['pink_image']:"0";?>',<?= $product['id']?>);
			
                    }
            }
        })
        <?php }?>
        
        
        
    }); 
    
     <?php 
        $products=explode(",",$record['product_id']);
        foreach($products as $l){ 
            $product= $this->db->query("select * from  products where id='".$l."'")->getRowArray();
        ?>
    $(document).on("change","#product_size_<?= $product['id']?>",function(){
        var size = $("#product_size_<?= $product['id']?>").val();
        //var diamond = $("#product_diamond").val();
		var purity=$('input[name="purity_<?= $product['id']?>"]:checked').val();
		var color=$('input[name="colors_<?= $product['id']?>"]:checked').val();
			getData(size,purity,color,<?= $product['id']?>);
			
            
       });
       
    $(document).on("change","#product_diamond",function(){
        var size = $("#product_size").val();
        //var diamond = $("#product_diamond").val();
		var purity=$('input[name="purity"]:checked').val();
		var color=$('input[name="colors"]:checked').val();
			getData(size,diamond,purity,color,<?= $product['id']?>);
			
       }); 
       
    $(document).on("change","input[type=radio][name=purity_<?= $product['id']?>]",function(){
        var size = $("#product_size_<?= $product['id']?>").val();
        //var diamond = $("#product_diamond").val();
		var purity=$('input[name="purity_<?= $product['id']?>"]:checked').val();
		var color=$('input[name="colors_<?= $product['id']?>"]:checked').val();
			getData(size,purity,color,<?= $product['id']?>);
			
       });    
       
    $(document).on("change","input[type=radio][name=colors_<?= $product['id']?>]",function(){
        var size = $("#product_size_<?= $product['id']?>").val();
        //var diamond = $("#product_diamond").val();
		var purity=$('input[name="purity_<?= $product['id']?>"]:checked').val();
		var color=$('input[name="colors_<?= $product['id']?>"]:checked').val();
			getData(size,purity,color,<?= $product['id']?>);
			
			getImages(color,'<?= ($product['intro_image'])?$product['intro_image']:"0";?>','<?= ($product['yellow_image'])?$product['yellow_image']:"0";?>','<?= ($product['pink_image'])?$product['pink_image']:"0";?>',<?= $product['id']?>);
			
       });
       
        
       

      <?php }?>
      
      $('#addcart').on('click',function(){
            
        var product_id = '<?= @$record['id'] ?>';
        var quantity = '1';
        var product_stock_id=$('#product_stock_id').val();
        var price=$('#tot_price').val();
        var mrp=$('#tot_mrp').val();
        var arr=[];
        $("input[name='product_set[]']").each( function () {
            if($(this).prop('checked') == true){
                arr.push($(this).val());
            }
       });
       if(arr.length>1){
        $.ajax({  
            url: '<?= base_url('cart/addtocartAjax1'); ?>',
            type: 'post',
            dataType:'json',
            data:{product_id: product_id,product_set:arr, quantity: quantity,product_stock_id:product_stock_id,price:price,mrp:mrp,type:'3'},
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
       }else{
           alert("please select atleast 2 product");
       }


    });  
    
    $('#madetoorder').on('click',function(){
            
        var product_id = '<?= @$record['id'] ?>';
        var quantity = '1';
        var product_stock_id=$('#product_stock_id').val();
        var price=$('#tot_price').val();
        var mrp=$('#tot_mrp').val();
        var arr=[];
        $("input[name='product_set[]']").each( function () {
            if($(this).prop('checked') == true){
                arr.push($(this).val());
            }
       });
       if(arr.length>1){
        $.ajax({  
            url: '<?= base_url('cart/addtocartAjax1'); ?>',
            type: 'post',
            dataType:'json',
            data:{product_id: product_id,product_set:arr, quantity: quantity,product_stock_id:product_stock_id,price:price,mrp:mrp,type:'3'},
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
       }else{
           alert("please select atleast 2 product");
       }

    });  
    
    $("input[name='product_set[]']").change(function() {
        var id=$(this).val();
        var price=$('#tot_price_'+id).val();
        var mrp=$('#tot_mrp_'+id).val();
        var fprice='0';
        var fmrp='0';
        
        let _14k_radiobutton = $(`#14K_${id}`);
        let _18k_radiobutton = $(`#18K_${id}`);
        
        let _white_radiobutton = $(`#white_${id}`);
        let _pink_radiobutton = $(`#pink_${id}`);
        let _yellow_radiobutton = $(`#yellow_${id}`);
        
        let _select_tag = $(`#product_size_${id}`);
        
        
        /* id="14K_<?= $product['id']?>"*/
        
        /*id="white_<?= $product['id']?>"*/
        
        /*id="product_size_<?= $product['id']?>"*/
        
        
        if(this.checked==true)
        {
            $(`#fade_${id}`).removeAttr('style');
            //enable all the buttons
            _14k_radiobutton.removeAttr('disabled');
            _18k_radiobutton.removeAttr('disabled');
            
            _white_radiobutton.removeAttr('disabled');
            _pink_radiobutton.removeAttr('disabled');
            _yellow_radiobutton.removeAttr('disabled');
            
            if(_select_tag.length!=0)
            {
                _select_tag.removeAttr('disabled');
            }
            
        }
        else
        {
            $(`#fade_${id}`).attr('style','opacity:0.3');
            
            //disable all the buttons
            _14k_radiobutton.attr('disabled',true);
            _18k_radiobutton.attr('disabled',true);
            
            _white_radiobutton.attr('disabled',true);
            _pink_radiobutton.attr('disabled',true);
            _yellow_radiobutton.attr('disabled',true);
            
            if(_select_tag.length!=0)
            {
                _select_tag.attr('disabled',true);
            }
        }
        
        
        
        if(this.checked) {
           fprice=parseFloat($('#tot_price').val())+parseFloat(price);
           fmrp=parseFloat($('#tot_mrp').val())+parseFloat(mrp);
           
        }else{
           fprice=parseFloat($('#tot_price').val())-parseFloat(price);
           fmrp=parseFloat($('#tot_mrp').val())-parseFloat(mrp);
        }
        
        console.log(this.checked);
        
        $('#tot_price').val(fprice);
        $('#tot_mrp').val(fmrp);
        if(fprice!=fmrp){
            tothtml='<h2 class="p_final_price">$ '+ fprice +' <span class="offer">$ '+ fmrp +'</span></h2>';
        }else{
            tothtml='<h2 class="p_final_price">$ '+ fprice +'</h2>';  
        }
        $('.price__main').html(tothtml);
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