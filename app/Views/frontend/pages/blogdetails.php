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
        <section class="banner--block blog--banner">
            <div class="home__banner inner__banner">
                <div class="banner__item">
                    <div class="banner__img" style="background-image: url(<?php echo base_url('assets/frontend/');?>/img/blog-banner.jpg)">
                        <h1><?php echo $blogarticles[0]->title; ?></h1>
                    </div>                    
                </div>
            </div>
        </section>
        <section class="blog--block">
            <div class="container">
                <?php if(!empty($blogarticles)) { ?>
                <div class="row">
                    <?php $i = 1; foreach ($blogarticles AS $article) { ?>
                    <div class="col-lg-12">
                        <div class="blog__single">
                            <div class="blog__single__img">
                                <img src="<?php echo base_url(); ?>/media/source/<?= $article->image;?>" alt="Blog">
                               
                            </div>
                            <div class="blog__single__content">
                                <span class="blog__date">by Admin on <?php echo date("d-M-Y", strtotime($article->created_date)); ?></span>
                                <h2><?php echo $article->title; ?></h2>
                                <?php echo $article->description; ?>
                                </div>
                        </div>
                    </div>
                    <?php $i++; } ?>
                </div> 
                <?php }?>
            </div>
        </section>
   <?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>