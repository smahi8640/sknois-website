<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
         
        <li class="nav-item">
            <a class="nav-link"  href="<?php echo base_url(); ?>" role="button">
              <i class="fas fa-eye"></i>
            </a>
        </li>
      
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="<?php echo base_url('assets/frontend/')?>/img/favicon.png" class="user-image img-circle elevation-2" alt="User Image">
              <span class="d-none d-md-inline">Admin User</span>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
              <!-- User image -->
              <li class="user-header bg-white">
                <img src="<?php echo base_url('assets/frontend/')?>/img/favicon.png" class="img-circle elevation-2" alt="User Image">
    
                <p>
                  Admin User              <!-- <small>Member since Nov. 2012</small> -->
                </p>
              </li>
              <li class="user-footer">
                <!--<a href="javascript:;" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-update-profile">Profile</a>-->
                <a href="<?php echo base_url(''); ?>/admin/user/logout" class="btn btn-default btn-flat float-right">Sign out</a>
              </li>
            </ul>
        </li>   
        
        
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>-->
    </ul>
  </nav>