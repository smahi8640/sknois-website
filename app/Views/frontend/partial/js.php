<!--<script src="<?php //echo base_url('assets/frontend/')?>/js/jquery.min.js"></script>
    <script src="<?php //echo base_url('assets/frontend/')?>/js/popper.min.js"></script>
    <script src="<?php //echo base_url('assets/frontend/')?>/js/bootstrap.min.js"></script>-->
    <script src="<?php echo base_url('assets/frontend/')?>/js/select2.full.min.js"></script>
    <script src="<?php echo base_url('assets/frontend/')?>/js/slick.min.js"></script>
	<script src="<?php echo base_url('assets/frontend/')?>/js/rating.js"></script>
	<script src="<?php echo base_url('assets/frontend/')?>/js/lightbox.js"></script>
	<script src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-Country-Selecter-with-Flags-flagstrap/dist/js/jquery.flagstrap.js"></script>
    <script src="<?php echo base_url('assets/frontend/')?>/js/main.js"></script>
    	  <script src="<?php echo base_url('assets/'); ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>/plugins/jquery-validation/additional-methods.min.js"></script>
    <script>
  
   

        $(document).ready( function() {
             $(document).on("submit","#newsletter",function(e){
    			e.preventDefault();
    			$.ajax({
    				url:'<?php echo base_url().'/contact/subscribe'?>',
    				method:"POST",
    				data:new FormData(this),
    				contentType: false,
    				cache: false,
    				processData:false,
    				success(response){
    				    var obj =  JSON.parse(response);
    				    if(obj.status=="1"){
    							swal(obj.message, {
    								icon: "success",
    							});
    						  }else{
    						      swal(obj.message, {
    								icon: "error",
    							});
    						  }
    				}
    			})
    		})
    		
    		$("#rating").rating({
    			"click": function (e) {
    				console.log(e);
    				$("#rating_input").val(e.stars);
    			}
    		});
    		
    		
    		
        });
    </script> 

 <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2({
                width: '100%'
            })
        })
    </script>
<!--<script type="text/javascript">
    var x = $(window).innerWidth() <= 414;
    if(x == true){
        jQuery(".product_name").each(function () {
            len = jQuery(this).text().length;
            str = jQuery(this).text().substr(0,15);
            lastIndexOf = str.lastIndexOf(""); 
            if(len>15) {
                jQuery(this).text(str.substr(0, lastIndexOf) + '…');
            }
        });
    }
    else{
        jQuery(".product_name").each(function () {
        len = jQuery(this).text().length;
        str = jQuery(this).text().substr(0,19);
        lastIndexOf = str.lastIndexOf(""); 
        if(len>19) {
            jQuery(this).text(str.substr(0, lastIndexOf) + '…');
        }
    });
    }

</script>

<script type="text/javascript">
    var x = $(window).innerWidth() <= 414;
    if(x == true){
        jQuery(".product_breadcum").each(function () {
            len = jQuery(this).text().length;
            str = jQuery(this).text().substr(0,30);
            lastIndexOf = str.lastIndexOf(""); 
            if(len>30) {
                jQuery(this).text(str.substr(0, lastIndexOf) + '…');
            }
        });
    }
    else{
        jQuery(".product_breadcum").each(function () {
        len = jQuery(this).text().length;
        str = jQuery(this).text().substr(0,30);
        lastIndexOf = str.lastIndexOf(""); 
        if(len>30) {
            jQuery(this).text(str.substr(0, lastIndexOf) + '…');
        }
    });
    }

</script>-->
<script>
    $('.select__country').flagStrap({
        countries: {
            "US": "USA"
        }
    });
    
   
    
</script>
 