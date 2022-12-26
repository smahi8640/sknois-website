<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<?php 
$this->db = \Config\Database::connect();
$request = \Config\Services::request();
$this->ionAuth    = new \IonAuth\Libraries\IonAuth();
?>

<main>

    <section class="breadcum--block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcum__main">
                    <ul class="d-flex align-items-center">
                        <li>Home</li>
                        <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/down-arrow.svg" alt="Arrow"></li>
                        <li class="active"><?php echo $request->uri->getSegment(1); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="joyari__content--block">
            
            <div class="contact__map--block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="contact__map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.54374639516!2d72.84806051493568!3d21.210276285900328!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDEyJzM3LjAiTiA3MsKwNTEnMDAuOSJF!5e0!3m2!1sen!2sin!4v1606483462917!5m2!1sen!2sin" width="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact__details--block">
                <div class="container">
                    <div class="row">
                        
                        <div class="col-lg-6">
                            <div class="contact__details">
                                <div class="contact__address">
                                    <p><?php echo $siteconfiguration->site_title; ?> <br />
                                       <?php echo $siteconfiguration->site_address; ?>
                                    </p>
                                </div>
                                <div class="contact__to">
                                    <p><a href="tel:<?php echo $siteconfiguration->site_contact_number; ?>"><?php echo $siteconfiguration->site_contact_number; ?></a></p>
                                    <p><a href="mailto:<?php echo $siteconfiguration->site_email; ?>"><?php echo $siteconfiguration->site_email; ?></a></p>
                                </div>
                                <div class="contact__branch">
                                    <p>Show Room HOURS: MON-FRI 9AM-5PM</p>
                                </div>
                            </div>
                        </div>
                        <?php $user = $this->ionAuth->user()->row();?>
                        <div class="col-lg-6">
                            
                            <div class="contact__from">
                                <form action="#" id ="contact" method="POST" class="contact-form">
                                    <div class="form-group">
                                        <input type="text" name="name" value="" required="" class="form-control" placeholder="Your Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" value="" required="" class="form-control" placeholder="Your Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="mobile" required="" value="" class="form-control" placeholder="Your Mobile">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="subject" required="" class="form-control" placeholder="Subject">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="description" id="" cols="30" rows="5" class="form-control" placeholder="Message"></textarea>
                                    </div>
                                    
                                    <div class="form-group mb-0">
                                        <button type="submit" value="Send Message" class="btn btn__send effect__btn">Send Message</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
    $(document).ready( function() {
         $(document).on("submit","#contact",function(e){
			e.preventDefault();
			$.ajax({
				url:'<?php echo base_url().'/contact/send'?>',
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
		
	
		
		
    });
</script> 
<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>