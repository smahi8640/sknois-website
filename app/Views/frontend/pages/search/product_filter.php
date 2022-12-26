
<div id="ajax-post-container" class="row">
  <?php
  $this->db = \Config\Database::connect();
  //print_r($products);
  if(!empty($products)) { ?>
    <?php foreach($products AS $record) { 
       /* if($record['size']!='size'){
        $details=$this->db->query("select * from product_stock where product_id='".$record['id']."' and country_code='231'")->getRowArray();
       $jsons1=json_decode($details['jsondata1']);
       $jsons2=json_decode($details['jsondata2']);
       $jsons3=json_decode($details['jsondata3']);
       $jsons4=json_decode($details['jsondata4']);
       $jsons5=json_decode($details['jsondata5']);
       $jsons6=json_decode($details['jsondata6']);
       
       $arr1=[];
        foreach($jsons1 as $key=>$json1){   
           $arr1[$key]['id']=$key;  
           $arr1[$key]['mrp']=$json1->mrp;
           $arr1[$key]['price']=$json1->price;
           $arr1[$key]['sku']=$json1->sku;
           $arr1[$key]['color']=$json1->color;
           $arr1[$key]['size']=$json1->size;
           $arr1[$key]['center_diamond']=$json1->center_diamond;
           $arr1[$key]['purity']=$json1->purity;
           $arr1[$key]['stock']=$json1->stock;
       }
       $arr2=[];
        foreach($jsons2 as $key=>$json2){   
           $arr2[$key]['id']=$key;   
           $arr2[$key]['mrp']=$json2->mrp;
           $arr2[$key]['price']=$json2->price;
           $arr2[$key]['sku']=$json2->sku;
           $arr2[$key]['color']=$json2->color;
           $arr2[$key]['size']=$json2->size;
           $arr2[$key]['center_diamond']=$json2->center_diamond;
           $arr2[$key]['purity']=$json2->purity;
           $arr2[$key]['stock']=$json2->stock;
       }
       $arr3=[];
        foreach($jsons3 as $key=>$json3){   
           $arr3[$key]['id']=$key;  
           $arr3[$key]['mrp']=$json3->mrp;
           $arr3[$key]['price']=$json3->price;
           $arr3[$key]['sku']=$json3->sku;
           $arr3[$key]['color']=$json3->color;
           $arr3[$key]['size']=$json3->size;
           $arr3[$key]['center_diamond']=$json3->center_diamond;
           $arr3[$key]['purity']=$json3->purity;
           $arr3[$key]['stock']=$json3->stock;
       }
       $arr4=[];
        foreach($jsons4 as $key=>$json4){   
           $arr4[$key]['id']=$key;   
           $arr4[$key]['mrp']=$json4->mrp;
           $arr4[$key]['price']=$json4->price;
           $arr4[$key]['sku']=$json4->sku;
           $arr4[$key]['color']=$json4->color;
           $arr4[$key]['size']=$json4->size;
           $arr4[$key]['center_diamond']=$json4->center_diamond;
           $arr4[$key]['purity']=$json4->purity;
           $arr4[$key]['stock']=$json4->stock;
       }
       $arr5=[];
        foreach($jsons5 as $key=>$json5){   
           $arr5[$key]['id']=$key;   
           $arr5[$key]['mrp']=$json5->mrp;
           $arr5[$key]['price']=$json5->price;
           $arr5[$key]['sku']=$json5->sku;
           $arr5[$key]['color']=$json5->color;
           $arr5[$key]['size']=$json5->size;
           $arr5[$key]['center_diamond']=$json5->center_diamond;
           $arr5[$key]['purity']=$json5->purity;
           $arr5[$key]['stock']=$json5->stock;
       }
       $arr6=[];
        foreach($jsons6 as $key=>$json6){   
           $arr6[$key]['id']=$key;  
           $arr6[$key]['mrp']=$json6->mrp;
           $arr6[$key]['price']=$json6->price;
           $arr6[$key]['sku']=$json6->sku;
           $arr6[$key]['color']=$json6->color;
           $arr6[$key]['size']=$json6->size;
           $arr6[$key]['center_diamond']=$json6->center_diamond;
           $arr6[$key]['purity']=$json6->purity;
           $arr6[$key]['stock']=$json6->stock;
       }
       
      $arrmerge= array_merge($arr1,$arr2,$arr3,$arr4,$arr5,$arr6);
      
      $price = array_column($arrmerge, 'price');
      array_multisort($price, SORT_DESC, $arrmerge);*/
    ?>  
    <div class="col-lg-3">
        <div class="product__item">
            <div class="product__head">
                <div class="product__img">
                    <a href="<?php echo base_url('')?>products/<?php echo $record['alias'].'-'.$record['style_no']; ?>">
						<?php 
						    $img = base_url('media/source/').'/'.$record['intro_image'];
						?>
                        <img src="<?php echo $img; ?>" alt="">
                    </a>
                </div>
              
                
            </div>
            <div class="product__content justify-content-center align-items-center">
             
                <div class="product__name">
                    <h4 class="name"><a href="<?php echo base_url('products/'.$record['alias'].'-'.$record['style_no']); ?>"><?php echo $record['title']; ?></a></h4>
                    <h4><?php echo $record['product_short_description']; ?></h4>
                </div>
                
            </div>
            <div class="price d-flex justify-content-center align-items-center">
                     <?php 
                            
                            //if(reset($arrmerge)['mrp']=="0" || reset($arrmerge)['mrp']==reset($arrmerge)['price']){?>
                       <!-- <h4>$ <?php //echo reset($arrmerge)['price']; ?></h4> 
                    <?php //}else{?> 
                        <h4>$ <?php //echo reset($arrmerge)['price']; ?> 
                        <span class="offer">$ <?php //echo reset($arrmerge)['mrp']; ?></span>
                        </h4>-->
                    <?php //}?>
                   
                   <?php 
                        if($record['price_default']=="0" || $record['price_default']==$record['mrp_default']){?>
                        <h4>$ <?php echo $record['price_default']; ?></h4> 
                    <?php }else{?> 
                        <h4>$ <?php echo $record['price_default']; ?> 
                        <span class="offer">$ <?php echo $record['mrp_default']; ?></span>
                        </h4>
                    <?php }?>
                </div>
        </div>
    </div>
    <?php }?>
    
    </div>
 
    <?php } 
    else{ ?>
            <div class="col-md-12 text-center alert alert-info">No related products.</div>
    <?php }?>

<script>
$(document).ready( function() {
    $(document).on("click","#addtowishlist-form",function(){
			var product_id = $(this).data("id");
			//alert(product_id);
			$.ajax({
				url: '<?php echo base_url('addwishlistproduct'); ?>',
				method: "POST",
				data: { product_id:product_id},
	    		dataType: 'json',
			})
			.done(function( response ) {
				$('.main__header .cart__icon .whistlist .cart__count').html(response.wishlist_count);
				swal({
					title: "Message!",
					text: response.message,
					type: response.message_type
				});
			});
		});
});
</script>