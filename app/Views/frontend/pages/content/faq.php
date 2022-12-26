<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<?php 
$this->db = \Config\Database::connect();
$request = \Config\Services::request();
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
                        <li class="active"><?php echo $request->uri->getSegment(2); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="joyari__content--block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="accordion" id="faq__block">
                            <div class="card">
                              <div class="card-header" id="heading1" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                <h5 class="mb-0">Are these real diamond jewelry?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>                                  
                              <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>Yes, all diamonds used in Joyari jewelry are real diamonds with Superior Diamond Quality, which comes with our own Certification done followed by strict International Standards.</p>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header collapsed" id="heading2" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                <h5 class="mb-0">Is it real gold used in the jewelry?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>Yes, all jewelry is of real gold used in our products with currently of 18k / 14k purity, which comes with BIS hallmark sign (BIS hallmark indicates purity of gold as per Indian Govt. approval).</p>
                                </div>
                              </div>
                            </div>
                           
                            <div class="card">
                              <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse3">
                                <h5 class="mb-0">Do I get certificate of jewelry?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse4" class="collapse" aria-labelledby="heading3" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>Yes, certificate is provided along with every Joyari jewelry.</p>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse3">
                                <h5 class="mb-0">Why is jewelry certified?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse5" class="collapse" aria-labelledby="heading3" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>We certify the jewelry as to let our customers know about the purity of gold and quality of diamonds used in every product that we display on our Joyari website.</p>
                                </div>
                              </div>
                            </div>
                            
                            <div class="card">
                              <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse3">
                                <h5 class="mb-0">How come Joyari jewelry are budget friendly?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse6" class="collapse" aria-labelledby="heading3" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>All Joyari Diamond jewelry is manufactured in-house with all latest technology and infrastructure. Our second company namely Mira Gems manufactures diamonds for last three decades. Mira Gems has been sourcing diamonds from mines to cut and polish everything in house. Joyari uses Diamonds from only Mira Gems in all its jewelry. All these merits enable us to keep authenticity and budget of jewelry at its best for which we say “Luxury-For-All”.</p>
                                </div>
                              </div>
                            </div>
                            
                            <div class="card">
                              <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse3">
                                <h5 class="mb-0">Are Joyari jewelry be delivered in my country?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse7" class="collapse" aria-labelledby="heading3" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>We are offering our products to US territory only as of now.</p>
                                </div>
                              </div>
                            </div>
                            
                            <div class="card">
                              <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse3">
                                <h5 class="mb-0">How many days will I receive products upon placing order?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse8" class="collapse" aria-labelledby="heading3" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>In general, Joyari jewelry is shipped within 8-12 working days. We make our best efforts to deliver you before time limits mostly.</p>
                                </div>
                              </div>
                            </div>
                            
                            <div class="card">
                              <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse3">
                                <h5 class="mb-0">Can I return product if I don't like or for any other reason?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse9" class="collapse" aria-labelledby="heading3" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>We don't offer any option of Product Return as of now.</p>
                                </div>
                              </div>
                            </div>
                            
                            
                            <div class="card">
                              <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse14" aria-expanded="false" aria-controls="collapse3">
                                <h5 class="mb-0">What’s your shipping policy?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse14" class="collapse" aria-labelledby="heading3" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>All products are delivered with zero charges and along with it we also provide 100% insured shipment. Hence, any damage or jewelry being misplaced during the transit will be our responsibility.</p>
                                </div>
                              </div>
                            </div>
                            
                            <div class="card">
                              <div class="card-header collapsed" id="heading3" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse3">
                                <h5 class="mb-0">Can I order any product as per my design?</h5>
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/plus.svg" class="accordion__icon plus" alt="Plus">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/img/minus.svg" class="accordion__icon minus" alt="Minus">
                              </div>
                              <div id="collapse15" class="collapse" aria-labelledby="heading3" data-parent="#faq__block">
                                <div class="card-body">
                                    <p>We provide customization of jewelry if the value is USD 1000 and above.</p>
                                </div>
                              </div>
                            </div>
                            
                           
                            
                        </div>
                    </div>
                </div> 
            </div>
        </section>
        <?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>