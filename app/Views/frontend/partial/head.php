<?php 
$this->db = \Config\Database::connect();
$this->session       = \Config\Services::session();
$settings=$this->db->query("select * from settings_siteconfiguration")->getRowArray(); 
$session = session();
if(empty($session->has('diamondtype'))){
    $session->set('diamondtype', 'lab-grown');
}
if(empty($session->has('currency'))){
    $session->set('currency', 'dollar');
}
if(empty($session->has('country'))){
    $session->set('country', 'usa');
}
?>
<meta charset="UTF-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" content="<?php echo @$title; ?>">
	<meta name="keywords" content="<?php echo @$record->meta_tags; ?>">	
    <meta name="description" content="<?php echo @$record->meta_description; ?>">
    <meta name="google-site-verification" content="aGcN6ZvLX_JxyPBtmp_RaaAsofe__unByhY6MIo0adg" />
    <title><?php echo @$title; ?></title>
    <link rel="shortcut icon" sizes="32x32" href="<?php echo base_url('assets/frontend/')?>/img/favicon.png" type="image/x-icon">
    <!--<link rel="shortcut icon" sizes="32x32" href="<?php echo site_url('media/source/'.$settings['site_logo']); ?>" type="image/x-icon">-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/')?>/css/slick.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/')?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>	
    <link rel="stylesheet" href="https://www.jqueryscript.net/demo/jQuery-Plugin-For-Country-Selecter-with-Flags-flagstrap/dist/css/flags.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/')?>/css/lightbox.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/')?>/css/select2.min.css">	
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/')?>/css/main.css">
    
	<script src="<?php echo base_url()?>/assets/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url()?>/assets/frontend/js/sweetalert.min.js"></script>
	
	<script src="<?php echo base_url('assets/frontend/')?>/js/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/frontend/')?>/js/popper.min.js"></script>
    <script src="<?php echo base_url('assets/frontend/')?>/js/bootstrap.min.js"></script>
   
    <script>
    function myFunction() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
    </script>

    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
    </script>
    
    
    <script>
     jQuery(document).ready(function () {
        jQuery('.refreshCaptcha').on('click', function(){
            jQuery.get('<?php echo base_url().'admin/user/login/refresh'; ?>', function(data){
                jQuery('#captImg').html(data.captcha);
            });
        });
    });
    </script>
    <style>
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader.gif") center no-repeat;
}
/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}
</style>