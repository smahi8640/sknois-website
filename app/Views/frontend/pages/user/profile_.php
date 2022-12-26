
        <section class="profile--block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="profile__left">
                            <div class="profile__details">
                                <img src="<?php echo base_url('media/source/').$user->photo; ?>" alt="User">
                            </div>
                            <div class="profile__user__name">
                                <h3><?php echo $user->first_name; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="profile__right">
                            <div class="profile__box">
                                <div class="profile__box__header d-flex align-items-center justify-content-between">
                                    <h4>Your Profile - <span class="profile__percent">30% Complete</span></h4>
                                    <a href="#" class="btn btn__edit effect__btn">Edit Profile</a>
                                </div>
                                <div class="profile__box__body">
                                    <div class="profile__item d-flex align-items-center">
                                        <h5>Name</h5>
                                        <p class="profile__name"><?php echo $user->first_name.' '.$user->last_name; ?></p>
                                    </div>
                                    <div class="profile__item d-flex align-items-center">
                                        <h5>Mobile No.</h5>
                                        <p><?php echo $user->phone; ?> <span class="no__verified text-danger">Not verified</span></p>
                                    </div>
                                    <div class="profile__item d-flex align-items-center">
                                        <h5>Pincode</h5>
                                        <p><?php echo $user->customer_pincode; ?></p>
                                    </div>
                                    <div class="profile__item d-flex align-items-center">
                                        <h5>Address</h5>
                                        <p><?php echo $user->customer_address; ?></p>
                                    </div>
                                    <!--<div class="profile__item d-flex align-items-center">
                                        <h5>Occuopation</h5>
                                        <p>-</p>
                                    </div>-->
                                    <a href="#" class="btn changepass__btn float-right">Change Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
 