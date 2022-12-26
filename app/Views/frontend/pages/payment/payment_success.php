

<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
	 

<script type="text/javascript">

    jQuery(document).ready( function() {

        function getstate(country_id) {

            jQuery.ajax({
                url: '<?php echo base_url('checkout/getstates'); ?>',
                method: 'POST',
                dataType: 'html',
                data: { country_id : country_id },
                success: function(data) {
                    jQuery('#customer_state').html( data );
                }
            });

        }

        getstate(101);

        jQuery('#customer_country').change( function () {

            var customer_country = jQuery(this).val();
            getstate(customer_country);

        });


    });

</script>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
    <?php
    $this->db = \Config\Database::connect();
    $request = \Config\Services::request();
    ?>
<main>

<section class="thank__you--block">
            <div class="thank__you__img">
                <img src="<?php echo base_url('assets/frontend');?>/img/shopping-bag.svg" class="in__svg" alt="Check">
            </div>
            <div class="thank__you__msg">
                <h1>Thank You!</h1>
                <p>Your order has been confirmed. Check your email for details.</p>
                <a href="<?php echo BASE.'/users/myorders';?>" class="btn thank__you__btn effect__btn">View orders</a>
                <a href="<?php echo BASE; ?>">Continue Shopping</a>
            </div>
        </section>

<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>
