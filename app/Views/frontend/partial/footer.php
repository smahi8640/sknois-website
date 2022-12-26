<?php $this->db = \Config\Database::connect();
$settings=$this->db->query("select * from settings_siteconfiguration")->getRowArray();
?>

<section class="newsletter--block">
            <div class="container">
                <div class="row">
                    <div class="main__title">
                        <h1>Join our Newsletter</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="newsletter__form">
                            <form id="newsletter">
                                <input class="form-control" type="email" placeholder="Email Address" required name="email" aria-label="Search">
                                <button class="newsletter__btn effect__btn" type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<footer class="footer--block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="footer__logo">
                            <a href="<?php echo BASE;?>"><img src="<?php echo base_url('media/source/'.$settings['site_logo']); ?>" alt="<?php echo $settings['site_title']; ?>"></a>
                        </div>
                        
                    </div>
                    <div class="col-lg-4 footer__about__col col1">
                        <div class="footer__about__text text-center">
                            <h4>Jewelry that touches your soul- Buy Diamond Jewelry Online</h4>
                            <p>Jewelry not only adds up to your fashion quotient but is a must-have for that finishing touch to any outfit. Be it a lightweight piece for a casual yet elegant look or the lustrous ones to make your special occasions grander, jewelries never fail to portray your statement. When it comes to Jewelry, what can be more extravagant than a diamond? With Joyari.com, you are just a step away from buying the best diamonds online.</p>
                            <p>We are your best and trusted online diamond jewelry store in India who are here to look after all your styling needs. From alluring diamond rings to glittery <a href="<?= BASE ?>jewelry/diamond-pendants"><u>diamond pendants</u></a>, gorgeous <a href="<?= BASE ?>jewelry/diamond-nose-pin"><u>diamond nose pins</u></a> to graceful diamond earrings and more, our exquisite diamond collection is sure to leave you heads over heels. We proudly boast of our state-of-the-art craftsmanship that promises to deliver the best quality, certified, and perfectly finished piece of diamond jewelry.</p>
                            <p>So, if you are in search for online diamond shopping in India, then look no further and choose your sparkle from Joyari.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 footer__about__col">
                        <div class="footer__about__text  text-center">
                            <h4>Stylish Rings to suit your Persona- Buy Diamond Rings for Men & Women</h4>
                            <h4>Diamond Rings for Women</h4>
                            <p>Witness our elaborate and unique collection of diamond rings for women who love to flaunt it. From office wear diamond rings to party wear diamond rings, everyday diamond rings to wedding diamond rings, we are sure you'll find your perfect piece with us.</p>
                            <h4>Diamond Rings for Men</h4>
                            <p>Who said diamonds are a woman's best friend? Men can equally look at their best with the sparkle of a diamond to reflect their style statement. Why stop for only a <a href="<?= BASE ?>jewelry/diamond-rings"><u>wedding diamond ring?</u></a> Check out our masculine and sturdy designs of a handpicked collection of diamond rings for men that are perfect for any occasions.</p>
                            <h4>Earrings that speak your Aura - Buy Diamond Earrings Online</h4>
                            <p>Look your best with our elegant collection diamond studs for that casual coffee date or become the talk of the town with our attractive and large stone pieces. Be it diamond jhumka earrings, temple-style chandelier danglers or hoop earrings, you sure to get dazzled by our selection of diamond earring designs. </p>
                            <p>Our <a href="<?= BASE ?>jewelry/diamond-earrings"><u>diamond earring</u></a> price starts from just $180! So, go ahead, check out our store and we assure you that you'll find the one that suits your style and budget.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 footer__about__col">
                        <div class="footer__about__text text-center">
                            <h4>Enchanting Pendants that allures your senses- Buy Diamond Pendants Online</h4>
                            <p>Diamond pendants portray individuality and grace. With our assemblage of diamond pendants designs, you witness an amalgamation of artistry and passion. These pendants for women are intricately cut to perfection and crafted to adorn your inner beauty. Experience a variety of styles with --- that you can cherish and complement with any outfits.</p>
                            <h4>Nose pins to rejuvenate your look- Buy Diamond Nose pins Online</h4>
                            <p>Do you want to look flawless yet classy with our modern diamond nose pin designs? Or in search of a goddess-like traditional nath design? No matter what you seek for, with Joyari  you can stay rest assured of the quality and design delivered right to at your doorstep. Browse through our exhaustive selections and find the best one that suits your diamond nose pin price range.</p>
                            <h4>What makes us the best destination for online diamond jewelry shopping in USA?</h4>
                            <ul>
                                <li>Over three-decade of craftsmanship</li>
                                <li>Ethical and sustainable brand</li>
                                <li>Your certified jewelry partner</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="footer__nav">
                            <ul class="nav justify-content-center">
                                <li>
                                    <a href="<?php echo BASE.'content/about';?>">About us</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE.'contact';?>">Contact</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE.'content/advantages';?>">Advantages</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE.'content/privacy';?>">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE.'content/exchange';?>">Delivery & Returns</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE.'content/faqs';?>">FAQS</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE.'content/blog';?>">Blog</a>
                                </li>
                                <!--<li>
                                    <a href="#">T&C</a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="copyright"><?php echo $settings['site_title']; ?> Copyright 2020 All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </main>
