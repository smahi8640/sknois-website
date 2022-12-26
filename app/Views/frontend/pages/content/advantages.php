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
            <div class="advantages__page__header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="advantages__header">
                                <h1>Joyari Advantages</h1>
                                <p>At Joyari, we belive in trust and honesty and thus customers satisfaction.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="advantages__page__content">
                <div class="container">
                    <div class="row flex-wrap">
                        <div class="advantages__column col-lg-4 col-md-6">
                            <div class="advantages__item">
                                <h4 class="text-center">Unique Designs</h4>
                                <p class="text-center">All our jewelry are designed in-house, keeping in mind the unique designs our customer would like to have it in their collections. With plenty of fresh designs time to time, we cater to all kind of moods.</p>
                                <div class="advantages__image">
                                    <img src="<?php echo base_url('assets/frontend/'); ?>/img/advantages1.png" alt="Unique Designs">
                                </div>
                            </div>
                        </div>
                        <div class="advantages__column col-lg-4 col-md-6">
                            <div class="advantages__item">
                                <h4 class="text-center">Jewelry Finish </h4>
                                <p class="text-center">All jewelry under a Multi-level of quality check. If the quality is not upto our standards or any damage, we make sure it again undergoes the manufacturing process.</p>
                                <div class="advantages__image">
                                    <img src="<?php echo base_url('assets/frontend/'); ?>/img/advantages2.png" alt="Finish jewelry">
                                </div>
                            </div>
                        </div>
                        <div class="advantages__column col-lg-4 col-md-6">
                            <div class="advantages__item">
                                <h4 class="text-center">Diamond Quality</h4>
                                <p class="text-center">We source all the diamonds directly from the manufacturers. Diamonds used are all Natural / Mined Diamonds with best of its specifies color(E-F) and clarity(VS-SI) or better.</p>
                                <div class="advantages__image">
                                    <img src="<?php echo base_url('assets/frontend/'); ?>/img/advantages3.png" alt="Diamond Quality">
                                </div>
                            </div>
                        </div>
                        <div class="advantages__column col-lg-4 col-md-6">
                            <div class="advantages__item">
                                <h4 class="text-center">Certification & Hallmark</h4>
                                <p class="text-center">All Joyari products comes with Certificate of Authentication and Hallmark. All jewelry are certified inhouse by Joyari.com under International quality protocol</p>
                                <div class="advantages__image"> 
                                    <img src="<?php echo base_url('assets/frontend/'); ?>/img/advantages4.png" alt="Certification & Hallmark">
                                </div>
                            </div>
                        </div>
                       
                         <div class="advantages__column col-lg-4 col-md-6">
                            <div class="advantages__item">
                                <h4 class="text-center">Free & Insured Shipping</h4>
                                <p class="text-center">Any jewelry you buy on Joyari.com during the transit all shipping is insured as well as Free Of Cost.</p>
                                <div class="advantages__image">
                                    <img src="<?php echo base_url('assets/frontend/'); ?>/img/advantages11.png" alt="Secured Payments Options">
                                </div>
                            </div>
                        </div>
                        <div class="advantages__column col-lg-4 col-md-6">
                            <div class="advantages__item">
                                <h4 class="text-center"> Secured Payments Options</h4>
                                <p class="text-center">You can choose various online payment options right from Credit Card, Debit Card, Netbanking and Wallet powered by Paypal.</p>
                                <div class="advantages__image">
                                    <img src="<?php echo base_url('assets/frontend/'); ?>/img/advantages10.png" alt="Secured Payments Options">
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