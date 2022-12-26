<?php 

/**
 * 
 * @package     INDRA.Admin
 * @subpackage  INDRA
 * @version 	1.0.0
 * @since 		2019
 * 
 * @copyright   Copyright (C) 2019 INDRA. All rights reserved.
 * @author 		GopiKumar Patel
 * @link 		gopipatel.ce@gmail.com
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');

?>
<main>
    <section class="breadcum--block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcum__main">
                    <ul class="d-flex align-items-center">
                        <li>Home</li>
                        <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>img/down-arrow.svg" alt="Arrow"></li>
                        <li class="active"><?php echo $this->uri->segment(1); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="products--block">
    	<div class="container">
    		<h2>About Us</h2>
            <hr>
            <?php echo $siteconfiguration->about_us; ?>
    	</div>
    </section>


