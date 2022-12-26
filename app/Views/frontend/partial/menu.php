<?php
$request = \Config\Services::request();
$controller  = $request->uri->getSegment(1);
$ionAuth = new \IonAuth\Libraries\IonAuth();
//$method = $request->uri->getSegment(2);
$home="";
$media="";
$projects="";
$news="";

$contact="";
$services="";
$about="";
$categories1="";
$brands1="";

$search="";
if($controller == 'home' || $controller == '') {
    $home="active";
}
if($controller == 'categories') {
    $categories1="active";
}

if($controller == 'category') {
    $categories1="active";
}

if($controller == 'brands') {
    $brands1="active";
}
if($controller == 'brand') {
    $brands1="active";
}
$cart = vc_getcartitems();
$cart_count = count($cart);
$this->db = \Config\Database::connect();
$settings=$this->db->query("select * from settings_siteconfiguration")->getRowArray();
$categories = $this->db->query("select * from categories where status='1' AND parent_id='0'")->getResultArray();
?>
<header>
    <div class="header__top">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="social__icon">
                        <ul class="d-flex">
                            <li>
                                <a href="<?php echo $settings['site_facebook_url']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/')?>/img/facebook.svg" alt="Facebook"></a>
                            </li>
                            <li>
                                <a href="<?php echo $settings['site_twitter_url']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/')?>/img/twitter.svg" alt="Twitter"></a>
                            </li>
                            <li>
                                <a href="<?php echo $settings['site_instagram_url']; ?>" target="_blank"><img class="in__svg" src="<?php echo base_url('assets/frontend/')?>/img/instagram.svg" alt="Instagram"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="logo text-center">
                        <a href="<?php echo BASE;?>">
                            <img src="<?php echo base_url('media/source/'.'/'.$settings['site_logo']); ?>" alt="Joyari">
                        </a>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="top__nav">
                        <!--<div class="call__us text-right">
                            <a href="#">CALL FREE <?php //echo $settings['site_contact_number']; ?></a>
                        </div>-->
                        <div class="top__menu">
                            <ul class="nav justify-content-end">
                                <!--<li class="nav-item">
                                    <a href="#" class="nav-link">CALL FREE <?php //echo $settings['site_contact_number']; ?></a>
                                </li>-->
                                <li class="nav-item">
                                    <div class="select__country" data-input-name="country2" data-selected-country="US"></div>
                                </li>
                                <li class="nav-item">
                                    <select class="custom-select border-0">
                                        <option selected> $ USD</option>
                                    </select>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <?php if($ionAuth->loggedIn()) { ?>
                                        <a class="dropdown-item" href="<?php echo BASE.'users/profile'; ?>">Profile</a>
										<a class="dropdown-item" href="<?php echo BASE.'users/myorders'; ?>">My Orders</a>
										<!--<a class="dropdown-item" href="<?php //echo base_url('asset'); ?>">Asset Value</a>-->
                                        <a class="dropdown-item" href="<?php echo BASE.'users/logout'; ?>">Logout</a>
                                        <?php } else { ?>
                                        <a class="dropdown-item" href="<?php echo BASE.'users/login'; ?>">Login</a>
                                        <a class="dropdown-item" href="<?php echo BASE.'users/register'; ?>">Register</a>
                                        <?php }?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header--block">
        <div class="container">
            <div class="main__header row align-items-center">
                <div class="col-lg-7 col-sm-1">
                    <div class="mobile_menu">
                        <span class="mobile_menu-icon"></span>
                    </div>
                    <div class="main__menu">
                        <ul class="nav">
                            <?php foreach ($categories as $category) { 
                             $subcategories =    $this->db->query("select * from categories where status='1' and parent_id='".$category['id']."'")->getResultArray(); 
                            if(!empty($subcategories)){ $has_child="has__child";}else{ $has_child="";}?>
                            <li class="nav-item <?php echo $has_child;  ?>">
                                <a class="nav-link" href="<?php echo BASE.'jewelry/'.$category['alias']; ?>"><?php echo $category['title']; ?></a>
                                
                                <?php if(!empty($subcategories)){  
                                $len = count($subcategories);
                                if($len<5){
                                ?>
                                    <div class="mega__menu has__two__col">
                                <?php }else if($len>4 && $len<9){
                                ?>
                                    <div class="mega__menu">
                                <?php }else if($len>8){
                                ?>
                                    <div class="mega__menu has__four__col">
                                <?php }?>        
                                    

                                    <?php 
                                        $i = 0;
                                        $j = 0;
                                        $len = count($subcategories);
                                        foreach ($subcategories as $m => $subcategory) {
                                            $i++;
                                            if($i=='1'){
                                                echo '<div class="mega__menu__column"><ul>';
                                            }
                                            ?>
                                            <li>
                                                <a href="<?php echo BASE.'jewelry/'.$subcategory['alias']; ?>"><?php echo $subcategory['title']; ?></a>
                                            </li>

                                            <?php     
                                            if($i=='4'){
                                                $i = 0;
                                                ?>
                                                </ul></div>
                                                <?php
                                            }else if($m == $len-1){
                                                ?>
                                                </ul></div>
                                                <?php
                                            }
                                        }
                                    ?>
                                    
                                    <div class="mega__menu__column menu__banner">
                                        <img src="<?php echo base_url('media/source/').'/'.$category['image']; ?>" alt="Category Banner">
                                    
                                   </div>
                                   </div>
                                 <?php } ?>
                            </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE.'products_set'; ?>">Sets</a>
                            </li>    
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 search__main">
                    <div class="header__search">
                        <form action="<?php echo BASE; ?>products/getsearchedproducts" method="post">
                            <input class="form-control" type="text" id="header-search" name="search" value="<?php echo @$search; ?>" placeholder="Search" aria-label="Search">
                            <button class="search__btn" type="submit"><img src="<?php echo base_url('assets/frontend/')?>/img/search.svg" alt="Search"></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-1 col-sm-5">
                    <div class="cart__icon d-flex align-items-center justify-content-end">
                        <!--<div class="nav-item dropdown mobile__my__account">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if($ionAuth->loggedIn()) { ?>
                                <a class="dropdown-item" href="<?php echo BASE.'profile'; ?>">Profile</a>
								<a class="dropdown-item" href="<?php echo BASE.'orders'; ?>">My Orders</a>
								<a class="dropdown-item" href="<?php echo BASE.'asset'; ?>">Asset Value</a>
                                <a class="dropdown-item" href="<?php echo BASE.'logout'; ?>">Logout</a>
                                <?php } else { ?>
                                <a class="dropdown-item" href="<?php echo BASE.'login'; ?>">Login</a>
                                <a class="dropdown-item" href="<?php echo BASE.'register'; ?>">Register</a>
                                <?php }?>
                            </div>
                        </div>-->
                        <div class="search__bar">
                            <img src="<?php echo base_url('assets/frontend/')?>/img/search.svg" alt="Search">
                        </div>
                        <!--<div class="whistlist">
                            <a href="<?php //echo base_url('wishlist'); ?>">
                                <img class="in__svg" src="<?php //echo base_url('assets/frontend/')?>/img/whishlist.svg" alt="whistlist">
                                <span class="cart__count"><?php //echo $wishlist_count; ?>0</span>
                            </a>
                        </div>-->
                        <div class="shopping__cart">
                            <a href="<?php echo BASE.'cart'; ?>">
                                <img  class="in__svg" src="<?php echo base_url('assets/frontend/')?>/img/shopping-cart.svg" alt="Shopping Cart">
                                <span class="cart__count"><?php echo $cart_count; ?></span>
                            </a>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>  
</header>
 