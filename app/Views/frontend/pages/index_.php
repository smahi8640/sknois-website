<!DOCTYPE html>

<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>

</head>

<body>
<?= $this->include('frontend/partial/home') ?>
	<?//= $this->include('frontend/partial/menu') ?>

	<main>
        <section class="diamond__category--block pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="diamond__category grown__diamond">
                            <div class="diamond__category--head">
                                <h3>LAB-GROWN DIAMONDS</h3>
                                <p class="mb-0">SMART AND RESPONSIBLE CHOICE</p>
                            </div>
                            <div class="diamond__category--img">
                                <a href="<?php echo base_url('categories/index/lab-grown'); ?>">
                                    <img src="<?php echo base_url('frontend'); ?>/img/collection1.png" alt="">
                                </a>
                            </div>
                            <div class="diamond__category--filter">
                                <div class="category__filter">
                                    <form action="#" method="post">
                                        <div class="form-group">
                                            <div class="custom__select">
                                                <select name="" class="form-control">
                                                    <option value="">Select Jewelery</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary effect__btn">Go</button>
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <a href="#" class="search__icon"><i class="fal fa-search"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="diamond__category natural__diamond">
                            <div class="diamond__category--head">
                                <h3>NATURAL DIAMONDS</h3>
                                <p class="mb-0">SMART AND RESPONSIBLE CHOICE</p>
                            </div>
                            <div class="diamond__category--img">
                                <a href="<?php echo base_url('categories/index/natural'); ?>">
                                    <img src="<?php echo base_url('frontend'); ?>/img/collection3.png" alt="">
                                </a>
                            </div>
                            <div class="diamond__category--filter">
                                <div class="category__filter">
                                    <form action="#" method="post">
                                        <div class="form-group">
                                            <div class="custom__select">
                                                <select name="" class="form-control">
                                                    <option value="">Select Jewelery</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary effect__btn">Go</button>
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <a href="#" class="search__icon"><i class="fal fa-search"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="why__us--block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main__title">
                            <h1>why Joyari</h1>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('frontend'); ?>/img/why1.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>Safe, Secure & Reliadble</h3>
                                <p>Payment Option</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('frontend'); ?>/img/why2.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>Ready-to-ship</h3>
                                <p>For Quick And Timely Delivery</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="why__us__item">
                            <div class="why__us__img">
                                <img class="in__svg" src="<?php echo base_url('frontend'); ?>/img/why3.svg" alt="Icon">
                            </div>
                            <div class="why__us__des">
                                <h3>Actual Products on Display</h3>
                                <p>What You See is What Your Get</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="servies__list d-flex align-items-center justify-content-center">
                            <div class="servie__item">
                                <img src="<?php echo base_url('frontend'); ?>/img/services/service1.png" alt="services">
                            </div>
                            <div class="servie__item">
                                <img src="<?php echo base_url('frontend'); ?>/img/services/service2.png" alt="services">
                            </div>
                            <div class="servie__item">
                                <img src="<?php echo base_url('frontend'); ?>/img/services/service3.png" alt="services">
                            </div>
                            <div class="servie__item">
                                <img src="<?php echo base_url('frontend'); ?>/img/services/service4.png" alt="services">
                            </div>
                            <div class="servie__item">
                                <img src="<?php echo base_url('frontend'); ?>/img/services/service5.png" alt="services">
                            </div>
                            <div class="servie__item">
                                <img src="<?php echo base_url('frontend'); ?>/img/services/service6.png" alt="services">
                            </div>
                            <div class="servie__item">
                                <img src="<?php echo base_url('frontend'); ?>/img/services/service7.png" alt="services">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

	

	 <?= $this->include('frontend/partial/footer') ?>

	 

    </main>
 <?= $this->include('frontend/partial/js') ?>
</body>

</html>