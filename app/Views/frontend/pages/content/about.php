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
            <div class="about__page__header" style="background-image: url(<?php echo base_url('assets/frontend/'); ?>/img/about_bg.jpg)">
                <div class="container">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="about__header__des">
                                <h1>Luxury For All</h1>
                                <p>Incepted to provide distinct and appealing jewelry, Joyari is a name that spells – ‘luxury for all’. At Joyari, we think about ‘you’ and the reasons behind your purchase – thus we design exclusive and timeless pieces that match your expectations – be it an affordable daily wear or an occasion wear.</p>
                                <p>We have more than 2000 designs that cater to your various needs – thereby earning the reputation among our patrons as a design house that believes in fulfilling the varied expectations and needs by giving utmost importance to quality.</p>
                                <p>At Joyari, we have a team of master craftmen – dedicated to creating keepsakes and precious pieces while continuously improving our offerings and craft. With an eye for detail complimented with hopping onto changing technology, we make sure that we offer only but exceptional offerings and nothing less.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about__page__content">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="about__image__column col-lg-6 p-0">
                        <div class="about__page__image" style="background-image: url(<?php echo base_url('assets/frontend/'); ?>/img/about1a.jpg)"></div>
                    </div>
                    <div class="about__text__column col-lg-6 p-0">
                        <div class="about__page__text">
                            <h4>Our story has only three parts to it – love, love and love.</h4>
                            <p>Joyari is modern yet old school, and believes – that only when one has love within – that it can create and give out love. And from there – we ooze out limitless creativity, with relentless passion and honestly to give out quality creations.</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="about__text__column col-lg-6 p-0">
                        <div class="about__page__text">
                            <h4>Luxe living is no longer trapped in an Ivory Tower.</h4>
                            <p>At Joyari, we stand for “Luxury for all.” Our high-quality jewelries are made keeping in mind your varied taste, moods as well as budget – from an everyday wear to an event where you need to be your stunning best – we are there for you.</p>
                        </div>
                    </div>
                    <div class="about__image__column col-lg-6 p-0">
                        <div class="about__page__image" style="background-image: url(<?php echo base_url('assets/frontend/'); ?>/img/about2a.jpg)"></div>
                    </div>                    
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="about__image__column col-lg-6 p-0">
                        <div class="about__page__image" style="background-image: url(<?php echo base_url('assets/frontend/'); ?>/img/about3a.jpg)"></div>
                    </div>
                    <div class="about__text__column col-lg-6 p-0">
                        <div class="about__page__text">
                            <h4>Love, laugh, cry, frown, go high and dry – wear your mood undeniably.</h4>
                            <p>For our collection is made keeping in mind the changing emotions. Be it a sunny afternoon in the shacks by the beachside or sitting by the bonfire on a high tide with a glass of red wine and surrounded by childhood friends, we have discovered every piece of stone and diamond that reflects the beauty in you in every scenario and mood. Wear us and live your emotion – be it happy face or grim face – let us face everyday together.</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <div class="about__text__column col-lg-6 p-0">
                        <div class="about__page__text">
                            <h4>Good things comes to those who allow.</h4>
                            <p>With us, be ‘you’tiful. Never stop chasing the real gem inside you. You can always approach us to help you find the best in you. We are here, to create timeless memories and build everlasting relationships for you.</p>
                        </div>
                    </div>
                    <div class="about__image__column col-lg-6 p-0">
                        <div class="about__page__image" style="background-image: url(<?php echo base_url('assets/frontend/'); ?>/img/about4a.jpg)"></div>
                    </div>                    
                </div>
            </div>
        </section>
<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>