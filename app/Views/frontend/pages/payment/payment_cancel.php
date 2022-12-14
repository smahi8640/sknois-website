
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
                <svg width="512" height="512" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_107_2)">
                    <path d="M361.392 267.227L352.6 116.716H281.624V184.301H251.625V116.716H136.086V184.301H106.087V116.716H35.1105L19.3462 386.577C18.1192 407.589 25.3969 427.594 39.8393 442.904C54.2817 458.214 73.8268 466.646 94.8739 466.646H261.278C251.568 447.741 246.084 426.324 246.084 403.649C246.084 335.212 296.036 278.231 361.392 267.227V267.227Z" fill="black"/>
                    <path d="M136.086 87.7672C136.086 55.9136 162.001 29.9987 193.855 29.9987C225.708 29.9987 251.624 55.9136 251.624 87.7672V116.715H281.623V87.7672C281.623 39.3723 242.251 0 193.855 0C145.459 0 106.087 39.3723 106.087 87.7672V116.715H136.086V87.7672Z" fill="black"/>
                    <path d="M376 296C348.152 296 321.445 307.062 301.754 326.754C282.062 346.445 271 373.152 271 401C271 428.848 282.062 455.555 301.754 475.246C321.445 494.938 348.152 506 376 506C403.848 506 430.555 494.938 450.246 475.246C469.938 455.555 481 428.848 481 401C481 373.152 469.938 346.445 450.246 326.754C430.555 307.062 403.848 296 376 296V296ZM376 388.265L400.39 363.875C402.079 362.186 404.369 361.237 406.757 361.237C409.146 361.237 411.436 362.186 413.125 363.875C414.814 365.564 415.763 367.854 415.763 370.243C415.763 372.631 414.814 374.921 413.125 376.61L388.735 401L413.125 425.39C413.961 426.226 414.624 427.219 415.077 428.311C415.53 429.404 415.763 430.575 415.763 431.757C415.763 432.94 415.53 434.111 415.077 435.204C414.624 436.296 413.961 437.289 413.125 438.125C412.289 438.961 411.296 439.624 410.204 440.077C409.111 440.53 407.94 440.763 406.757 440.763C405.575 440.763 404.404 440.53 403.311 440.077C402.219 439.624 401.226 438.961 400.39 438.125L376 413.735L351.61 438.125C350.774 438.961 349.781 439.624 348.689 440.077C347.596 440.53 346.425 440.763 345.243 440.763C344.06 440.763 342.889 440.53 341.796 440.077C340.704 439.624 339.711 438.961 338.875 438.125C338.039 437.289 337.376 436.296 336.923 435.204C336.47 434.111 336.237 432.94 336.237 431.757C336.237 430.575 336.47 429.404 336.923 428.311C337.376 427.219 338.039 426.226 338.875 425.39L363.265 401L338.875 376.61C338.039 375.774 337.376 374.781 336.923 373.689C336.47 372.596 336.237 371.425 336.237 370.243C336.237 369.06 336.47 367.889 336.923 366.796C337.376 365.704 338.039 364.711 338.875 363.875C339.711 363.039 340.704 362.376 341.796 361.923C342.889 361.47 344.06 361.237 345.243 361.237C346.425 361.237 347.596 361.47 348.689 361.923C349.781 362.376 350.774 363.039 351.61 363.875L376 388.265Z" fill="black"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_107_2">
                    <rect width="512" height="512" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="thank__you__msg">
                <h1>Payment Failure!</h1>
                <p>Seems, something wrong...!!!</p>
                
		           <p><b>Ref. No:</b> <?php echo $order_number; ?></p>
		           <p><b>Message:</b> <?php echo $error; ?></p>
		      
			   
    				   
                <a href="<?php echo BASE;?>" class="btn thank__you__btn effect__btn">Continue Shopping</a>
                <a href="<?php echo BASE.'/users/myorders'; ?>">Go to Orders</a>
            </div>
        </section>
        

<?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>        