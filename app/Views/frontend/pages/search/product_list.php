<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
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
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<?php 
$this->db = \Config\Database::connect();
$request = \Config\Services::request();
$controller  = $search;?>

<main>
        <section class="banner--block d-none">
            <div class="home__banner inner__banner">
                <div class="banner__item">
                    <div class="banner__img" style="background-image: url(<?php echo base_url('media/source/').'/' ?>)"></div>
                </div>
            </div>
        </section>

        <section class="breadcum--block category__page" style="margin-top:180px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcum__main">
                            <ul class="d-flex align-items-center">
                                <li>Home</li>
                                <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/down-arrow.svg" alt="Arrow"></li>
                                <li class="active">Search "<?php echo $controller; ?>"</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
      

        <section class="products--block">
            <div class="container">
                
                <div class="product-list">
                   
                </div>  
                <div class="loader"></div>
            </div>
        </section>

    <script type="text/javascript">

    jQuery(document).ready( function () {
        var alias='<?= $controller?>';
        $.ajax({
            url:'<?php echo base_url()."/products/searchajax/"; ?>'+alias,
            method:"GET",
            success(response){
                /*var obj =  JSON.parse(response);
                if(obj.status){*/
                    $(".product-list").html(response);
                /*}
                else{
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "error"
                    });
                }*/
            }
        }) 
            

        jQuery(document).on('click', '.add_to_wishlist', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url:'<?php echo base_url()."addwishlistproduct/"; ?>'+id,
                method:"GET",
                success(response){
                    var obj =  JSON.parse(response);
                    if(obj.status){
                        window.location = '<?php echo base_url()."wishlist"; ?>';
                    }
                    else{
                        swal({
                            title: "Message!",
                            text: obj.message,
                            type: "error"
                        });
                    }
                }
            }) 
        });

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
                    id : '<?php //echo $products['id'];?>',
                        img : '<?php //echo $products->intro_image;?>',
                        name : '<?php //echo $products->title;?>',
                        price : '<?php //echo $products->product_final_price;?>',
                        mrp : '<?php //echo $products->product_price;?>',
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
                url:'<?php echo base_url().'categories/filterproduct/'.$controller; ?>',
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
                        jQuery('img.in__svg').each(function(){
                            var oThis = jQuery(this);
                            if ( oThis.attr('src').indexOf('.svg') >= 1 ){
                                jQuery.get(oThis.attr('src'), function(data){
                                    var theSVG = jQuery(data).find('svg');
                                    theSVG = theSVG.attr('class', oThis.attr('class'));
                                    theSVG = theSVG.removeAttr('xmlns:a'); //Remove invalid XML tags
                                    oThis.replaceWith(theSVG);
                                }, 'xml');
                            }
                        });
                        page = 1;
                    // }
                }
            })
        });
        
       
		
		var page = 1;
		var total_pages = 10<?php //print $count?>;
	    
		/*jQuery(window).scroll(function() {
            if (!jQuery(".product-list").data("loading")) {
    			//if (jQuery(window).scrollTop() > jQuery(".product-list").height() - 100) {
    			if((jQuery(window).scrollTop() + jQuery(window).height()) > jQuery(".product-list").height()){
    			    page++;
    				if(page < total_pages) {
    					//loadMoreProducts(page);
    				}
    			}
            }
		});*/
	
	
		function loadMoreProducts(page){
		  $(".loader").show();
		  //$(".product-list").hide();
          $(".product-list").attr('loading',true);
          var formData = new FormData(jQuery("#search-form")[0]);
		  //console.log(page);
		  jQuery.ajax(
				{
					//url: '?page=' + page,
					url:'<?php echo base_url().'categories/filterproduct/'.$controller; ?>?page=' + page,
					method:"POST",
                    data:formData,
                    contentType: false,
                    async: false,
                    cache: false,
                    processData:false,
				})
				.done(function(data)
				{	           
                    $(".product-list").attr('loading',false);
					//jQuery('.loader').hide();
					jQuery("#ajax-post-container").append(data);
					//swal.close();
					$(".loader").hide();		
					//$(".product-list").show();
                    jQuery('img.in__svg').each(function(){
                        var oThis = jQuery(this);
                        if ( oThis.attr('src').indexOf('.svg') >= 1 ){
                            jQuery.get(oThis.attr('src'), function(data){
                                var theSVG = jQuery(data).find('svg');
                                theSVG = theSVG.attr('class', oThis.attr('class'));
                                theSVG = theSVG.removeAttr('xmlns:a'); //Remove invalid XML tags
                                oThis.replaceWith(theSVG);
                            }, 'xml');
                        }
                    });
				});
		}
		
		
    });
	
	
	

</script>

<div class="bottom__top__top">
            <svg id="top__arrow" enable-background="new 0 0 512.001 512.001" height="512" viewBox="0 0 512.001 512.001" width="512" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <path d="m380.597 140.648-106.253-131.693c-4.452-5.64-11.081-8.903-18.199-8.955-.058 0-.114 0-.171 0-7.06 0-13.669 3.176-18.162 8.737l-105.78 131.107c-6.257 7.096-7.795 17.286-3.906 26.056 3.856 8.696 12.07 14.099 21.436 14.099h16.427v307.003c0 13.785 11.215 25 25 25h130c13.785 0 25-11.215 25-25v-307.003h16.425.012c9.045 0 17.146-5.192 21.143-13.551 4.096-8.573 2.956-18.46-2.972-25.8zm-15.075 17.174c-.312.654-1.241 2.177-3.103 2.177-.001 0-.001 0-.002 0h-26.43c-5.522 0-10 4.477-10 10v317.003c0 2.71-2.29 5-5 5h-130c-2.71 0-5-2.29-5-5v-317.003c0-5.523-4.478-10-10-10h-26.427c-1.797 0-2.706-1.199-3.152-2.206-.281-.635-1.066-2.856.661-4.763.128-.141.252-.286.372-.435l105.932-131.294c.866-1.072 1.889-1.301 2.602-1.301h.024c.597.004 1.736.187 2.654 1.358.028.036.058.072.086.108l106.295 131.745c1.526 1.89.851 3.854.488 4.611z"/>
                        <path d="m263.771 79.491c-1.898-2.353-4.76-3.721-7.783-3.721s-5.885 1.368-7.783 3.721l-30 37.183c-1.435 1.778-2.217 3.994-2.217 6.279v119.527c0 5.523 4.478 10 10 10s10-4.477 10-10v-115.996l20-24.789 20 24.789v315.516h-40v-109.52c0-5.523-4.478-10-10-10s-10 4.477-10 10v119.52c0 5.523 4.478 10 10 10h60c5.522 0 10-4.477 10-10v-329.047c0-2.285-.782-4.501-2.217-6.279z"/>
                        <path d="m225.988 297.484c5.522 0 10-4.477 10-10v-.007c0-5.523-4.478-9.996-10-9.996s-10 4.48-10 10.003 4.478 10 10 10z"/>
                    </g>
                </g>
            </svg>
        </div>
<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>