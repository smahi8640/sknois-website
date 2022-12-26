<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
   <?= $this->include('frontend/partial/menu1') ?>
     <section class="breadcum--block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcum__main">
                    
                </div>
            </div>
        </div>
    </div>
</section>
<section class="joyari__content--block">
    <div class="container">
        <h2>404 Page not found</h2>
        <hr>
        <a href="<?php echo base_url(); ?>">Go to Home</a>
    </div>
</section>
 <?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>