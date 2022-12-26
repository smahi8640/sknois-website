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


		<!--  INNERPAGE SECTION	-->
		<div class="innerpage-wrapper forgotpassword-page-wrapper">
		
		
			<!--  INNERBANNER SECTION	-->
			<section class="innerbanner-section">
				<div class="title text-center">Reset Password</div>
			</section>
			
			
			<!--  INNERCONTENT SECTION	-->
			<section class="innercontent-section">
				<div class="container">
				
					<div class="content-container forgotpassword-page-container py-5">

						
						<div class="col-lg-6 p-0 d-block mx-auto">
						<?php echo form_open('user/reset_password/' . $code,array('class'=>'forgotpassword-form'));?>
							
							<div class="form-group">
								<label for="new_password">New Password (at least 8 characters long):</label><br />
								<?php echo form_input($new_password, '', 'class="form-control"');?>
							</div>
						
							<div class="form-group">
								<label for="new_password">Confirm New Password :</label><br />
								<?php echo form_input($new_password_confirm, '', 'class="form-control"');?>
							</div>
						
							<?php echo form_input($user_id);?>
							<?php // echo form_hidden($csrf); ?>
						
							<?php echo form_submit('submit', 'Change', 'class="btn btn-block btn-red btn-forgotpassword"');?>
						
						<?php echo form_close();?>						
						</div>
						
					</div>
						
				
				</div>
			</section>
			
		</div>