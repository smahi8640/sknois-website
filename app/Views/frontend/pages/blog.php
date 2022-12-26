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
                        <h1>Blog</h1>
                    </div>                    
                </div>
            </div>
        </section>
        <section class="blog--block">
            <div class="container">
                <?php if(!empty($blogarticles)) { ?>
                <div class="row">
                     <?php $i = 1; foreach ($blogarticles AS $article) { ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="blog__item">
                            <a href="<?php echo BASE.'/content/blogdetails/'.$article->alias ?>" >
                            <div class="blog__img" style="background-image: url(<?php echo base_url('/media/source/'.$article->image); ?>)">
                                <div class="blog__created__date">
                                    <span class="created__date"><?php echo date("d", strtotime($article->created_date)); ?></span>
                                    <span class="created__month"><?php echo date("M", strtotime($article->created_date)); ?></span>
                                </div>
                            </div>
                            </a>
                            <div class="blog__content">
                                <h3><a href="<?php echo BASE.'/content/blogdetails/'.$article->alias ?>" title="<?php echo $article->title; ?>"><?php echo $article->title; ?></a></h3>
                                <!--<p>Joyari is modern yet old school, and believes – that only when one has love within – that it can create and give out love. And from there – we ooze out limitless creativity, with relentless passion and honestly to give out quality creations.</p>
                                <a class="btn effect__btn" href="<?php echo base_url('/content/blogdetails/').'/'.$article->alias ?>">Read more</a>-->
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