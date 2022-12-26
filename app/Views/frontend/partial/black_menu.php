<?php
$request = \Config\Services::request();
$controller  = $request->uri->getSegment(1);
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
//$cart = cart();
//$totalItems = $cart->totalItems();
$cart = cart();
$totalItems = $cart->contents();
$this->db = \Config\Database::connect();
$settings=$this->db->query("select * from settings_siteconfiguration")->getRowArray();
$categories = $this->db->query("select * from categories where parent_id='0'")->getResultArray();
?>
<header class="header inner-page bg-dark">
		<div class="header__main">
			<div class="container">
				<div class="row" style="align-items: center;">
					<div class="logo col-lg-1 col-md-4">
						<div class="header__logo">
							<a href="<?php echo base_url();?>">
								<img src="<?php echo base_url('frontend/img/logo.svg')?>" alt="Be Baby">
							</a>
						</div>
					</div>
					<div class="main__menu col-lg-10">
						<div class="mobile_menu">
                            <span class="mobile_menu-icon"></span>
                        </div>
						<div class="header__menu">
							<div class="header__icon header--user d-xl-none mb-3">
								<div class="d-flex align-content-center" id="user__dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="far fa-user-circle"></i>
									<span>Login</span>
								</div>
								<div class="dropdown-menu" aria-labelledby="user__dropdown">
									<a class="dropdown-item" href="#">Profile</a>
									<a class="dropdown-item" href="#">Order History</a>
									<a class="dropdown-item" href="#">Logout</a>
								</div>
							</div>
							<ul class="nav p-0">
							  	<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url();?>">Home</a>
								</li>
								<?php foreach($categories as $category) {
									$subcategories = $this->db->query("SELECT * from categories where parent_id=".$category['id'])->getResultArray();
									$child = "";
									$fas_down = "";
									if(!empty($subcategories)){
										$child = "has__child";
										$fas_down = '<i class="fas fa-chevron-down"></i>';
									}
									?>
										<li class="nav-item <?php echo $child; ?>">
											<a class="nav-link" href="<?php echo base_url('categories/'.$category['alias'])?>"><?php echo $category['title']; ?><?php echo $fas_down;?></a>


											<?php 
												if($subcategories){
													?>
													<a href="javascript:void(0)" class="submenu__expant">
					                                        <i class="fas fa-plus plus"></i>
					                                        <i class="fas fa-minus minus"></i>
					                                    </a>
												    	<div class="header__submenu">
												    		<ul>
												  			<?php 
												  			
												  				foreach($subcategories as $subcat => $subcategory) {
												  					?>
												  					<li class="nav-item">
																    	<a class="nav-link" href="<?php echo base_url('categories/'.$subcategory['alias'])?>"><?php echo ' -'.$subcategory['title']; ?></a>
																  	</li>
																  	<?php
														  		}
												  			
												  			?>
												    		</ul>
												    	</div>
													<?php 
												}
											?>
											
										</li>
									<?php 
								}
								?>
								
							    <li class="nav-item">
									<a class="nav-link" href="<?php echo base_url('about')?>">About</a>
							  	</li>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url('contact')?>">Contact us</a>
							  	</li>
							  	<li class="nav-item">
									<a class="nav-link" href="<?php echo base_url('storelocator')?>">Stores</a>
							  	</li>
							</ul>
							<div class="social__icons d-xl-none mt-3">
								<ul class="d-flex align-content-center">
									<li>
										<a href="#">
											<i class="fab fa-facebook-f"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fab fa-twitter"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fab fa-instagram"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fab fa-linkedin-in"></i>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fab fa-youtube"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="header__icons col-lg-1 col-md-6">
						<div class="header__top__icons d-flex align-content-center justify-content-end">
							<div class="header__icon header--search">
								<div class="header__search__icon">
									<i class="fas fa-search"></i>
								</div>
								<div class="header__search" style="display: none;">
		                            <form action="<?php echo base_url('search')?>" method="post">
		                                <input class="form-control" type="text" id="header-search" name="search" value="" placeholder="Search" aria-label="Search">
		                                <button class="search__btn" type="submit">
		                                	<i class="fas fa-search"></i>
		                                </button>
		                            </form>
		                        </div>
							</div>
							<div class="header__icon header--cart">
								<div class="header__cart__icon">
									<a href="<?php echo base_url('products/enquirylist')?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="cart-count"><?php echo count($totalItems); ?></span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>  	