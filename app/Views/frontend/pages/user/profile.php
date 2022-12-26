<?php 
$this->db = \Config\Database::connect();
$request = \Config\Services::request();
?>
<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
    <div class="overlay"></div>
    <?= $this->include('frontend/partial/menu') ?>
<main>
    
        <section class="profile--block">
            <div class="container">
                <div class="row">
                   
                    
                    <div class="col-lg-3">
                        <div class="profile__left">
                            <div class="profile__details">
                                <img src="<?php echo base_url('assets/frontend/') ?>/img/user.png" alt="User">
                            </div>
                            <div class="profile__user__name">
                                <h3><?php echo "Welcome, ".$user->first_name; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div id="profile" class="col-lg-9">
                        <div class="profile__right">
                            <div class="profile__box">
                                <div class="profile__box__header">
                                    <h4>Edit Profile <a href="#" id="edit"><i class="fa fa-edit"></i></a></h4>
                                </div>
                                <div class="profile__box__body">
                                        <div class="row">
                                            
                                            <div class="form-group profile__name col-md-12">
                                                <label for=""><?php echo $user->first_name;?> <?php echo $user->last_name;?></label>
                                            </div>
                                            <div class="form-group profile__name col-md-12">
                                                <label for=""><?php echo $user->email;?></label>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for=""><?php echo $user->phone;?></label>
                                                
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for=""><?php echo $user->customer_pincode;?></label>
                                            </div>
                                            
                                            <div class="form-group col-md-12">
                                                <label for=""><?php echo $user->customer_address;?></label>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="profile-edit" class="col-lg-9 d-none">
                        <div class="profile__right">
                            <div class="profile__box">
                                <div class="profile__box__header">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="profile__box__body">
                                    <?php echo form_open('users/profile',array('class'=>'profile-form formvalidate'));?>
                                        <div class="row">
                                            
                                            <div class="form-group profile__name col-md-4">
                                                <label for="">First Name *</label>
                                                <input class="form-control"  name="first_name" type="text"  value="<?php echo $user->first_name; ?>" required placeholder="First Name">
                                            </div>
                                            <div class="form-group profile__name col-md-4">
                                                <label for="">Last Name *</label>
                                               <input class="form-control"  name="last_name" type="text" value="<?php echo $user->last_name; ?>" required placeholder="Last Name">
                                            </div>
                                            <div class="form-group profile__name col-md-4">
                                                <label for="">Email *</label>
                                               <input class="form-control" readonly name="email" type="email"  value="<?php echo $user->email; ?>" required placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Mobile No.*</label>
                                                <input class="form-control"  name="phone" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?php echo $user->phone; ?>" required placeholder="Without country code (+1)">
			                    
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Zip Code *</label>
                                                <input class="form-control" name="customer_pincode" id="customer_pincode" type="text" value="<?php echo $user->customer_pincode; ?>" placeholder="Zip Code">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">City *</label>
                                              <input class="form-control" name="customer_city" id="city" type="text" value="<?php echo $user->customer_city; ?>" required="" placeholder="City">
                						
                						    </div>
                						    <div class="col-md-4">
                						        <label for="">Country *</label>
                                                   <?php
                                                      $countries = $this->db->query("select * from countries where id='231'")->getResult();
                                                      $options = array();
                                                      $options[''] = '---';
                                                      foreach ($countries AS $country) {
                                                          $options[$country->id] = $country->name;
                                                      }
                                                       if($user->country!=""){ echo form_dropdown('customer_country', $options, set_value('customer_country',   $user->country), 'class="form-control" id="customer_country"'); 
                                                      }else{ echo form_dropdown('customer_country', $options,  set_value('customer_country',   231), 'class="form-control" id="customer_country"');}
                                                      ?>
                    						  </div>
                    						  <div class="col-md-4">
                    						      <label for="">State *</label>
                                                  <?php
                    			                 echo form_dropdown('customer_state', "", $user->customer_state, 'class="form-control" id="customer_state" required');?>
                    						  </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Address *</label>
                                                <textarea name="customer_address" id="" rows="3" class="form-control" placeholder="Address"><?php echo $user->customer_address; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="action__buttons">
                                        <button class="btn changepass__btn" id="confirm">Save</button>
                                        <button type="reset" class="btn cancel__btn" onclick="window.location.href='<?php echo BASE;?>';">Cancel</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


	
<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
 <script>
 $(document).ready(function () {
     //preloader();
     $(document).on("click","#edit",function(){
             //alert("hi");
             $('#profile-edit').removeClass('d-none');
			 $('#profile').addClass('d-none');
         });
//Validation
	  $('.formvalidate').validate({
    rules: {
        email: {
        required: true,
        email: true,
      },
      first_name: {
        required: true,
      },
      last_name: {
        required: true,
      },
	  phone: {
        required: true,
      },
      customer_pincode: {
        required: true,
      },
      customer_country: {
        required: true,
      },
      customer_city: {
        required: true,
      },
      customer_state: {
        required: true,
      },
      customer_address: {
        required: true,
      }     
      
    },
    messages: {
        email: {
        required: "Please enter email",
        email: "Please enter a vaild email"
      },
      password: {
        required: "Please enter password",
      },
      first_name: {
        required: "Please enter first name",
      },
      last_name: {
        required: "Please enter last name",
      },
	  phone: {
        required: "Please enter mobile",
      },
	  customer_pincode: {
        required: "Please enter zipcode",
      },
      customer_city: {
        required: "Please enter city",
      },
      customer_state: {
        required: "Please select state",
      },
      customer_country: {
        required: "Please select country",
      },
	  customer_address: {
        required: "Please enter address",
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
});

function checkzip(zipcode){
    
    
	jQuery.ajax({
			method: "GET",
			url: "https://ziptasticapi.com/"+zipcode
			
		})
		.done(function( response ) {
		    
		    var obj =  JSON.parse(response);
			if(obj.country == "US") {
			    jQuery("#city").val(obj.city);
			    $("#customer_state option").each(function() {
                  if($(this).text().toUpperCase() == obj.city.toUpperCase()) {
                    $(this).attr('selected', true);            
                  }else{
                     $(this).attr('selected', false);      
                  }                        
                });
			    jQuery("#confirm").removeAttr("disabled");
				
			}else{
				alert("It seems we are not serving this zipcode!");
				jQuery("#confirm").attr("disabled","true");
			}
			$("body").removeClass("loading"); 
		});
	}	 
	
	function getstate(country_id) {

        jQuery.ajax({
            url: '<?php echo base_url('checkout/getstates'); ?>',
            method: 'POST',
            dataType: 'html',
            data: { country_id : country_id },
            success: function(data) {
                jQuery('#customer_state').html( data );
            }
        });

    }


    jQuery(document).ready( function() {
        getstate(231);
        <?php if(empty($user->customer_state)){?>
        setTimeout( function() { 
        checkzip(jQuery('#customer_pincode').val());   
        }, 1000);
       <?php }
         ?>
    	
	jQuery("#customer_pincode").on("change", function() {
	    $("body").addClass("loading"); 
	    getstate(231);
	    setTimeout( function() { 
	    checkzip(jQuery('#customer_pincode').val());   
	    }, 1000);
	});	
	
    
       

        jQuery('#customer_country').change( function () {

            var customer_country = jQuery(this).val();
            getstate(customer_country);

        });
        
    });
});
</script> 
       </body>

</html>		      