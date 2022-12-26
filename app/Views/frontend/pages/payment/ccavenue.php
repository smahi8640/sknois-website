<?php
include(APPPATH.'third_party/Crypto.php');
?>

<!--  INNERPAGE SECTION	-->
<div class="innerpage-wrapper login-page-wrapper ccavenue-payment-page">

    <section class="ftco-section ftco-checkout">
        <div class="container">

            <?php
            $merchant_data='205142';
            $working_key='726543059097131263E8D0997E55AFE8';//Shared by CCAVENUES
            $access_code='AVDF82GA88BF48FDFB';//Shared by CCAVENUES
            foreach ($_POST as $key => $value)
            {
                $merchant_data.=$key.'='.urlencode($value).'&';
            }
            $encrypted_data=encrypt($merchant_data,$working_key); ?>
            <!--<form class="text-center" method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">-->
                 <form class="text-center" method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
                	
                <h1>Please Wait, redirecting to the payment gateway...</h1>
                <input type="hidden" name="encRequest" value="<?php echo $encrypted_data; ?>" />
                <input type="hidden" name="access_code" value="<?php echo $access_code; ?>" />
                <button type="submit" class="btn btn-primary add-to-cart">Redirecting...</button>
            </form>
            <script language='javascript'>document.redirect.submit()</script>

        </div>
    </section>

</div>