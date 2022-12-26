<?php

/**
 *
 * @package     INDRA.Admin
 * @subpackage  INDRA
 * @version 	1.0.0
 * @since 		2019
 *
 * @copyright   Copyright (C) 2019 INDRA. All rights reserved.
 * @author 		GopiKumar Patel
 * @link 		gopipatel.ce@gmail.com
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');

?>
<?php $cat= $this->db->where('alias',$this->uri->segment(2))->get('categories')->row_array(); ?>
<style>
.loader{
    display:none;
}
.loader {
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #f05a89;
    width: 50px;
    height: 50px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
    margin: 0 auto;
}

/* Safari */
@-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<main>
            <section class="banner--block">
            <div class="home__banner inner__banner">
                <div class="banner__item">
                    <div class="banner__img" style="background-image: url(<?php echo base_url('media/source/').$cat['banner_image'] ?>)"></div>
                </div>
            </div>
        </section>

        <section class="breadcum--block category__page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcum__main">
                            <ul class="d-flex align-items-center">
                                <li>Home</li>
                                <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>img/down-arrow.svg" alt="Arrow"></li>
                                <li class="active"><?php echo $this->uri->segment(2); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="filter--block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
						<form action="" id="search-form" method="GET">
							<div class="filter__main d-flex align-items-center">
								<div class="custom__select">
									<select class="form-control" data-placeholder="Price Range" name="price" id="filter_price">
									    <option value="">Select Price</option>
										<option value="1">1000-5000</option>
										<option value="2">5001-10000</option>
										<option value="3">10001-15000</option>
										<option value="4">15001-20000</option>
									</select>
									  
								</div>
								<div class="custom__select">
									<select class="form-control" data-placeholder="Stock" name="stock" id="filter_stock">
									    <option value="">All</option>
										<option value="1">In Stock</option>
									</select>
									  
								</div>
								 <div class="custom__select">
									<select class="form-control select2" name="categories[]" data-placeholder="Categories" id="filter_category"  multiple="multiple">
										<?php
                                        foreach ($category as $key => $value) {
                                            echo '<option value="'.$value['id'].'">'.$value['title'].'</option>';
                                        }
                                        ?>
									</select>
								</div>
								<div class="custom__select">
									<select class="form-control select2" name="size[]" data-placeholder="Size" id="filter_size" multiple="multiple">
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
									</select>
								</div>
								 <div class="custom__select">
									<select class="form-control select2" name="lenght[]" data-placeholder="Lenght" id="filter_lenth" multiple="multiple">
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
									</select>
								</div>
								<div class="custom__select">
									<select class="form-control select2" name="gender[]" data-placeholder="Gender" id="filter_gender" multiple="multiple">
										<option value="1">Male</option>
										<option value="2">Female</option>
										<option value="3">Kids</option>
									</select>
								</div>
								<div class="custom__select">
									<select class="form-control" name="short_by" id="filter_short_by">
										<option value="">SORT BY Price</option>
										<option value="asc">Low to High</option>
										<option value="desc">High to Low</option>
									</select>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </section>

        <section class="products--block">
            <div class="container">
                <div class="loader"></div>
                <div class="product-list">
                    <?php echo $this->load->view('categories/product_filter'); ?>
                </div>  
            </div>
        </section>

    <script type="text/javascript">

    jQuery(document).ready( function () {


        jQuery('.add-to-cart').click( function() {

            var formId = jQuery(this).attr('data-formid');

            var quantity = 1;

            var attribute = {};
            var id = jQuery('#'+formId+' input[name="id"]').val();
            var img = jQuery('#'+formId+' input[name="img"]').val();
            var name = jQuery('#'+formId+' input[name="name"]').val();
            var price = jQuery('#'+formId+' input[name="price"]').val();
            var mrp = jQuery('#'+formId+' input[name="mrp"]').val();

            jQuery.ajax({
                url: '<?php echo base_url('addtocartAjax'); ?>',
                type: 'POST',
                /*data: {
                    id : '<?php echo $products->id;?>',
                        img : '<?php echo $products->intro_image;?>',
                        name : '<?php echo $products->title;?>',
                        price : '<?php echo $products->product_final_price;?>',
                        mrp : '<?php echo $products->product_price;?>',
                        qty : quantity,
                        attribute : attribute
                    },*/
                data: {
                    id : id,
                    img : img,
                    name : name,
                    price : price,
                    mrp : mrp,
                    qty : quantity,
                    attribute : attribute
                },
                dataType: 'json'
            }).done(function( response ) {
                if (response){
                    if(response.status == 200){
                        var cart_count = response.cart_count;
                        jQuery('.cart_acc .s_cart .cart_count').text(cart_count);
                        myFunction();
                    } else {
                        //error handler
                        //myFunction();
                        alert(response.msg);
                    }
                } else {
                    alert('Please try again.');
                }
            });

        });

        jQuery("#filter_price, #filter_stock, #filter_category, #filter_size, #filter_lenth, #filter_gender, #filter_short_by").on('change', function(){
            var formData = new FormData(jQuery("#search-form")[0]);
            $(".loader").show();
            $(".product-list").hide();
            $.ajax({
                url:'<?php echo base_url().'categories/filterproduct/'.$this->uri->segment(2); ?>',
                method:"POST",
                data:formData,
                contentType: false,
                cache: false,
                processData:false,
               
                success(response){
                    // var obj =  JSON.parse(response);
                    // if(obj.status){
                        $(".product-list").show();
                        $(".loader").hide();
                        $(".product-list").html(response);
                    // }
                }
            })
        });
        
       
		
		var page = 1;
		var total_pages = <?php print $count?>;
	 
		jQuery(window).scroll(function() {
			
			if (jQuery(window).scrollTop() == jQuery(document).height() - jQuery(window).height()) {
				page++;
				if(page < total_pages) {
					loadMoreProducts(page);
				}
			}
		});
	
	
		function loadMoreProducts(page){
		  
		  //console.log(page);
		  jQuery.ajax(
				{
					//url: '?page=' + page,
					url:'<?php echo base_url().'categories/filterproduct/'.$this->uri->segment(2); ?>?page=' + page,
					type: "GET",
					beforeSend: function()
					{
						//jQuery('.loader').show();
						swal({
						  title: "Wait",
						  text: "Loading.....",
						  icon: "warning",
						  button: false,
						  closeOnClickOutside: false
						});
					}
				})
				.done(function(data)
				{	           
					//jQuery('.loader').hide();
					jQuery("#ajax-post-container").append(data);
					swal.close();					
				});
		}
		
		
    });
	
	
	

</script>