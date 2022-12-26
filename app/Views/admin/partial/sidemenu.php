<?php

$request = \Config\Services::request();

$controller  = $request->uri->getSegment(2);

$method = $request->uri->getSegment(3);


$dashboard="";
$media="";
$articles="";
$coupons="";
$style="";
$menu="";
$nav="";

$pincode="";
$orders="";
$category="";
$products="";
$productgrid="";
$product="";
$productsetgrid="";
$productset="";
$products_set="";
$inventory="";
$cart="";

$istyle="";
$imenu="";
$inav="";

$pstyle="";
$pmenu="";
$pnav="";

$psstyle="";
$psmenu="";
$psnav="";

if($controller == 'dashboard') {
    $dashboard="active";
}
if($controller == 'media') {
    $media = "active";
} 
if($controller == 'articles') {
    $articles="active";
}
if($controller == 'coupons') {
    $coupons="active";
}
if($controller == 'pincode') {
    $pincode="active";
    $style='style="display:block;"';
    $menu = "menu-is-opening menu-open";
    $nav="active";
}
if($controller == 'categories') {
    $category="active";
    $style='style="display:block;"';
    $menu = "menu-is-opening menu-open";
    $nav="active";
}
if($controller == 'products') {
    $products="active";
    $style='style="display:block;"';
    $menu = "menu-is-opening menu-open";
    $nav="active";
}
if($controller == 'productgrid' && $method=='') {
    $product="active";
    $pstyle='style="display:block;"';
    $pmenu = "menu-is-opening menu-open";
    $pnav="active";
}
if($controller == 'productgrid' && $method=='index_grid') {
    $productgrid="active";
    $pstyle='style="display:block;"';
    $pmenu = "menu-is-opening menu-open";
    $pnav="active";
}
if($controller == 'productsetgrid' && $method=='') {
    $productset="active";
    $psstyle='style="display:block;"';
    $psmenu = "menu-is-opening menu-open";
    $psnav="active";
}
if($controller == 'productsetgrid' && $method=='index_grid') {
    $productsetgrid="active";
    $psstyle='style="display:block;"';
    $psmenu = "menu-is-opening menu-open";
    $psnav="active";
}
if($controller == 'products_set') {
    $products_set="active";
    $style='style="display:block;"';
    $menu = "menu-is-opening menu-open";
    $nav="active";
}
if($controller == 'inventory') {
    $inventory="active";
    $style='style="display:block;"';
    $menu = "menu-is-opening menu-open";
    $nav="active";
}
if($controller == 'orders') {
    $orders="active";
    $style='style="display:block;"';
    $menu = "menu-is-opening menu-open";
    $nav="active";
}
if($controller == 'cart') {
    $cart="active";
    $style='style="display:block;"';
    $menu = "menu-is-opening menu-open";
    $nav="active";
}
if($controller == 'forms') {
if($method == 'help') {
    $help="active";
}
if($method == 'ringsize') {
    $ringsize="active";
}
if($method == 'notifyme') {
    $notifyme="active";
}
if($method == 'contact') {
    $contact="active";
}
if($method == 'madetoorder') {
    $madetoorder="active";
}
if($method == 'videocall') {
    $videocall="active";
}
if($method == 'subscribers') {
    $subscribers="active";
}
    $istyle='style="display:block;"';
    $imenu = "menu-is-opening menu-open";
    $inav="active";
}
$siteconfiguration="";
if($controller == 'siteconfiguration') {
    $siteconfiguration="active";
    $s_style='style="display:block;"';
    $s_menu = "menu-is-opening menu-open";
    $s_nav="active";
}
if($controller == 'homeslider') {
    $homesliders="active";
    $s_style='style="display:block;"';
    $s_menu = "menu-is-opening menu-open";
    $s_nav="active";
}
if($controller == 'orderstatus') {
    $orderstatus="active";
    $s_style='style="display:block;"';
    $s_menu = "menu-is-opening menu-open";
    $s_nav="active";
}

/*if($controller == 'homesliders') {

    $homesliders="active";

    $s_style='style="display:block;"';

    $s_menu = "menu-is-opening menu-open";

    $s_nav="active";

}

if($controller == 'orderstatus') {

    $orderstatus="active";

    $s_style='style="display:block;"';

    $s_menu = "menu-is-opening menu-open";

    $s_nav="active";

}*/

?>

<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('admin'); ?>" class="brand-link d-block">
      <img src="<?php echo base_url('media/source/joyari-logo.png'); ?>" alt="" class="brand-image float-none d-block mx-auto img-circle- elevation-3-">
      <span class="brand-text font-weight-light"></span>
    </a>


    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link <?php echo @$dashboard; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('admin/media'); ?>" class="nav-link <?php echo @$media; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Media Manager
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          
          <li class="nav-item <?php echo @$menu; ?>">
            <a href="#" class="nav-link <?php echo @$nav; ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Shop
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" <?php echo @$style;  ?>>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/categories'); ?>" class="nav-link <?php echo @$category; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/products'); ?>" class="nav-link <?php echo @$products; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/products_set'); ?>" class="nav-link <?php echo @$products_set; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products Set</p>
                </a>
              </li>
             
              <li class="nav-item d-none">
                <a href="<?php echo base_url('admin/inventory'); ?>" class="nav-link <?php echo @$inventory; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/orders'); ?>" class="nav-link <?php echo @$orders; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Orders</p>
                </a>
              </li>
              <li class="nav-item d-none">
                <a href="<?php echo base_url('admin/cart'); ?>" class="nav-link <?php echo @$cart; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cart</p>
                </a>
              </li>
              <li class="nav-item d-none">
                <a href="<?php echo base_url('admin/pincode'); ?>" class="nav-link <?php echo @$pincode; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pincode</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item <?php echo @$pmenu; ?>">
            <a href="#" class="nav-link <?php echo @$pnav; ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Arrange Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" <?php echo @$pstyle;  ?>>
               <li class="nav-item">
                <a href="<?php echo base_url('admin/productgrid'); ?>" class="nav-link <?php echo @$product; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List View</p>
                  </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/productgrid/index_grid'); ?>" class="nav-link <?php echo @$productgrid; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Grid View</p>
                </a>
              </li>
            </ul>
          </li>  
          
          <li class="nav-item <?php echo @$psmenu; ?>">
            <a href="#" class="nav-link <?php echo @$psnav; ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
               Arrange Products Set
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" <?php echo @$psstyle;  ?>>
               <li class="nav-item">
                <a href="<?php echo base_url('admin/productsetgrid'); ?>" class="nav-link <?php echo @$productset; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List View</p>
                  </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/productsetgrid/index_grid'); ?>" class="nav-link <?php echo @$productsetgrid; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Grid View</p>
                </a>
              </li>
            </ul>
          </li>  
         
          <li class="nav-item">
            <a href="<?php echo base_url('admin/articles'); ?>" class="nav-link <?php echo @$articles; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Blog
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          
          <li class="nav-item d-none">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item d-none">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Groups</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/user'); ?>" class="nav-link <?php echo @$user; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
            </ul>
          </li>    
          
          <li class="nav-item <?php echo @$imenu; ?>">
            <a href="#" class="nav-link <?php echo @$inav; ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Inquiry List
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview <?php echo $istyle;  ?>">
              <li class="nav-item">
                <a href="<?php echo site_url('admin/forms/subscribers'); ?>" class="nav-link <?php echo @$subscribers; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subscribers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('admin/forms/contact'); ?>" class="nav-link <?php echo @$contact; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contacts</p>
                </a>
              </li>
              <li class="nav-item d-none">
                <a href="<?php echo site_url('admin/forms/ringsize'); ?>" class="nav-link <?php echo @$ringsize; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ring Size</p>
                </a>
              </li>
              <li class="nav-item d-none">
                <a href="<?php echo site_url('admin/forms/videocall'); ?>" class="nav-link <?php echo @$videocall; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Video Call</p>
                </a>
              </li>
              <li class="nav-item d-none">
                <a href="<?php echo site_url('admin/forms/notifyme'); ?>" class="nav-link <?php echo @$notifyme; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notify Me</p>
                </a>
              </li>
              <li class="nav-item d-none">
                <a href="<?php echo site_url('admin/forms/help'); ?>" class="nav-link <?php echo @$help; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Help</p>
                </a>
              </li>
              <li class="nav-item d-none">
                <a href="<?php echo site_url('admin/forms/madetoorder'); ?>" class="nav-link <?php echo @$madetoorder; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Made to order</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item d-none">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Labels
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          
          <li class="nav-item d-none">
            <a href="<?php echo base_url('admin/coupons'); ?>" class="nav-link <?php echo @$coupons ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Coupons
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          
          <li class="nav-item <?php echo @$s_menu; ?>">
            <a href="#" class="nav-link <?php echo @$s_nav; ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview <?php echo @$s_style;  ?>">
              <li class="nav-item">
                <a href="<?php echo base_url('admin/homeslider'); ?>" class="nav-link <?php echo @$homesliders; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Home Slider</p>
                </a>
              </li>
              <li class="nav-item d-none">
                <a href="<?php echo base_url('admin/orderstatus'); ?>" class="nav-link <?php echo @$orderstatus; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Status</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/siteconfiguration'); ?>" class="nav-link <?php echo @$siteconfiguration; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Site Configuration</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="<?php echo base_url('admin/siteconfiguration/backup'); ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Backup
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>