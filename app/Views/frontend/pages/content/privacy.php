<html>

<head>

	 <?= $this->include('frontend/partial/head') ?>
</head>

<body>
    <?= $this->include('frontend/partial/menu') ?>
<?php 
$this->db = \Config\Database::connect();
$request = \Config\Services::request();
?>

<main>

    <section class="breadcum--block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcum__main">
                    <ul class="d-flex align-items-center">
                        <li>Home</li>
                        <li class="d-flex"><img class="in__svg" src="<?php echo base_url('assets/frontend/'); ?>/img/down-arrow.svg" alt="Arrow"></li>
                        <li class="active"><?php echo $request->uri->getSegment(2); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="joyari__content--block">
    <div class="container">
        <h2>Privacy Policy</h2>
        <hr>
      <h4>Personal Information that may be collected</h4> 
      <p>Mira Jewels and joyari.com shall collect and store any information that you provide on our website. To be a registered user on our website, we need to have your basic Personal Information. Apart from this, when you visit our site, our systems collect details about your computer's personal information like your IP address, the server from which you are accessing our website and native mobile applications, details of web browser and operating system used to access our website or native mobile applications, date, time and place of accessing of our website and native mobile applications etc. Please note that your IP address does not identify you personally.</p>
    <p>By visiting Joyari.com website, you signify your agreement to accepting this privacy policy and authorize Joyari.com website to collect, store and use of any information that you provide. We will only have information about you if you are willing to provide it. The information you provide is referred to as personal information. Please make sure you update your personal information if any of any changes in your data or details. The details you provide may include your name, email address, delivery address, and telephone number.</p>
    
    <h4>Use of Information</h4>
    <p>We will use this information to fulfill any order and to communicate with you when necessary. We may also use your personal information to contact you about our latest collections, promotions, news and offers that we think may interest you, or to tell you if we change anything important about how the website works, or the terms of use of the website. If you decide at any point that you no longer wish to receive messages of this nature, please contact us and send an email to let us know. Alternatively, click on ‘unsubscribe’ at the bottom of any of the emails you receive.</p>
    <p>Further, please note as under -<br/>
    1.	Mira Jewels owns all the information collected via Joyari.com website. As applicable, the information collected by Mira Jewels through Joyari.com website shall be used to contact you about the Website and Website related news and Services available on the Website; monitor and improve the Website; calculate the number of visitors to the Website and to know the geographical locations of the visitors; update you on all the special offers available on the Website and provide you with a better shopping experience.<br/>
2.	Please note that when you place an order, some of your Personal Information will be shared with others who shall need to have access to some Personal Information like courier companies, credit card processing companies, vendors etc. to enable them and Outhouse perform their duties and fulfill your order requirements. <br/>
3.	Mira Jewels does not allow any unauthorized persons or organization to use any information that we may collect from you through Joyari.com website.<br/>
4.	In the event Mira Jewels is required to respond to subpoenas, court orders or other legal process, your Personal Information may be disclosed pursuant to such subpoenas, court order or legal process, which may be without notice to you. <br/>
5.	Mira Jewels may share collective information such as demographics and website usage statistics with our sponsors, advertisers or other third parties (such third parties do not include Mira Jewels’ marketing partners and network providers). When this type of information is shared, such parties do not have access to your Personal Information.<br/>
6.	Joyari.com website may contain links, which may lead you to other Websites. Please note that once you leave our website you will be subjected to the Privacy Policy of the other website and this Privacy Policy will no longer apply.<br/>
7.	We also may disclose the information we collect from you where we believe it is necessary to investigate, prevent or take action regarding illegal activities, suspected fraud, situations involving potential threats to the safety of any person or violations of our Terms and Conditions or this Policy.<br/>
</p>
<p>We understand that privacy is important to you, and we promise to look after your personal information. We will not sell any information about you to any other party.</p>
 
 
     <h4>Will we share your personal information with anyone else?</h4>
    <p>We will never release your personal details to any outside company for mailing or marketing purposes.
Payments on the website are processed by a third party, which adheres to the privacy policy that is set out here. We have a non-disclosure agreement with such third parties, and they are certified by all the major card issuers to hold details securely.
</p>
    
     <h4>How long will we keep your information?</h4>
    <p>We will only keep your personal information for as long as necessary and consistent with the purpose for which you have given it to us. Except where needed to respond to a query from you or fulfill an order, we will delete your personal information on request by you.</p>
    
     <h4>What are 'Cookies' and how do we use them?</h4>
    <p>Cookies are small pieces of information saved by your browser onto your computer. Cookies are used to record various aspects of your visit and assist joyari.com to provide you with uninterrupted service. When you visit our Joyari.com website or view any products or search or various aspects of your actions place an order on the website and enter your name and details, you will become a recognized user, and we will send a cookie to your computer. A cookie is a small file that may be placed on your computer's hard disk for which can help you in your search requirement and for better shopping experience. Cookies do not contain any information that can personally identify you or your personal details including password/account details/identity etc. They help us to recognize your digital identity when you visit the website and make use of your digital identity whenever you login to avail service in future so that the service can be tailored to your needs. In no case cookies send to you will track your personal identity and or information. Use of cookies by our website is only for the preparation of customized page and information visitor of our webpage looking for.</p>

<p>We will also use cookies for the compilation of certain statistics (which do not identify you personally) relating to the use of the website. Such information may include the number of visits, average time spent, shopping trend, buyer’s choice and need and other statistics relating to the website. </p>

<p>You may see Mira Jewels / joyari.com adverts on other websites. For these adverts, we will be using software that may send a cookie to your browser. This software will allow us to monitor if you see our adverts, if you click on them and if you go on to buy from our website.</p>

    
     <h4>Fraudulent Transactions</h4>
    <p>Mira Jewels/ joyari.com reserves the right to recover the cost of goods, collection charges and lawyers’ fees from persons using the site fraudulently. Mira Jewels reserves the right to initiate legal proceedings against such persons for fraudulent use of the Site and any other unlawful acts or acts or omissions in breach of these Terms & Conditions.</p>
    <p>BY VISITING JOYARI.COM WEBSITE, YOU SIGNIFY YOUR AGREEMENT TO THE TERMS OF THIS PRIVACY POLICY. OUTHOUSE RESERVES THE RIGHT, IN OUR SOLE DISCRETION, TO CHANGE, MODIFY, ADD OR DELETE PORTIONS OF THE TERMS OF THIS PRIVACY POLICY AT ANY TIME.</p>
    <p>If you have any questions about this Privacy Policy, please feel free to contact us through our website or write to us at “connect@joyari.com”</p>
   
    </div>
</section>
 <?= $this->include('frontend/partial/footer') ?>
       <?= $this->include('frontend/partial/js') ?>
       </body>

</html>

