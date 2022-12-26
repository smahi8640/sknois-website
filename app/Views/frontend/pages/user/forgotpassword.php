
        <section class="authentication--block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="authentication__main">
                            <div class="left__column">
                                <h3>Reset Password</h3>
                                <p>Enter the e-mail that you used when signing and we'll send you a link to change your password.</p>
                             
                                <?php echo form_open('',array('class'=>'reset-password__form'));?>
                                    <div class="form-group">
                                        <label for="">Enter Email</label>
                                        <?php echo form_input('email',set_value('email'),'class="form-control" placeholder="Email Address"'); ?>
					                    <?php echo form_error('email', '<p class="mt-2 mb-0 text-danger">', '</p>');?>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button class="btn btn__login effect__btn">Reset Password</button>
                                    </div>
                                <?php echo form_close();?>
                            </div>
                            <div class="right__column">
                                <div class="joyari__logo">
                                    <img src="<?php echo base_url('assets/frontend/'); ?>img/joyari-logo.png" alt="Joyari">
                                </div>
                                <div class="joyari__content">
                                    <h3>Already have an account?</h3>
                                    <a href="<?php echo base_url('login'); ?>" class="btn effect__btn">Sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      