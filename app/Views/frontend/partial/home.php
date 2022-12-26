<?php 
$this->db = \Config\Database::connect();
$settings=$this->db->query("select * from settings_siteconfiguration")->getRowArray();
?>
<header>
        <div class="header__top">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-4 col-md-12 col-sm-12 d-flex">
                        <div class="social__icon">
                            <ul class="d-flex">
                                <li>
                                    <a href="<?= $settings['site_facebook_url']?>" target="_blank"><img class="in__svg" src="<?php echo base_url('frontend'); ?>/img/facebook.svg" alt="Facebook"></a>
                                </li>
                                <li>
                                    <a href="<?= $settings['site_twitter_url']?>" target="_blank"><img class="in__svg" src="<?php echo base_url('frontend'); ?>/img/twitter.svg" alt="Twitter"></a>
                                </li>
                                <li>
                                    <a href="<?= $settings['site_instagram_url']?>" target="_blank"><img class="in__svg" src="<?php echo base_url('frontend'); ?>/img/instagram.svg" alt="Instagram"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="header__call ml-4">
                            <a href="tel: <?= $settings['site_contact_number']?>">CALL <?= $settings['site_contact_number']?></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="logo text-center">
                            <a href="#">
                                <img src="<?php echo base_url('frontend'); ?>/img/joyari-logo.png" alt="Joyari">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="top__nav">
                            <div class="top__menu">
                                <ul class="nav justify-content-end">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="country" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url('frontend'); ?>/img/usa.png" alt="USA"> USA</a>
                                        <div class="dropdown-menu" aria-labelledby="country">
                                            <a class="dropdown-item" href="#"><img src="<?php echo base_url('frontend'); ?>/img/usa.png" alt="USA"> USA</a>
                                            <a class="dropdown-item" href="#"><img src="<?php echo base_url('frontend'); ?>/img/india.png" alt="India"> India</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="currency" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Currency</a>
                                        <div class="dropdown-menu" aria-labelledby="currency">
                                            <a class="dropdown-item" href="#">INR</a>
                                            <a class="dropdown-item" href="#">Dollar</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="#">Login</a>
                                            <a class="dropdown-item" href="#">Register</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</header>
