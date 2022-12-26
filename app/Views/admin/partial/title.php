<div class="content-wrapper" style="min-height: 312px;">
    <div class="content-header">
      <div class="container-fluid">
        
        <?php $this->session = \Config\Services::session(); ?>

        <?php 
            if ($this->session->getFlashdata('notifications')) : 
            $notifications = $this->session->getFlashdata('notifications');
            if(!empty(trim($notifications['message']))) {
        ?>
        <div class="notifications-wrapper">
            <div class="alert alert-<?= $notifications['type']; ?> alert-dismissible fade show" role="alert">
                <?= $notifications['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>
        <?php } endif; ?>

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin1/dashboard');?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- Default box -->
            <div class="row">
                <div class="col-lg-12 col-12">    