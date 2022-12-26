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
		<div class="innerpage-wrapper profile-page-wrapper">
		
		
			<!--  INNERBANNER SECTION	-->
			<section class="innerbanner-section">
				<div class="title text-center"><i class="fa fa-user" aria-hidden="true"></i> Profile</div>
			</section>
			
			
			<!--  INNERCONTENT SECTION	-->
			<section class="innercontent-section">
				<div class="container p-0">
				
					<div class="content-container profile-page-container">
	
						<?php echo form_open('',array('class'=>'profile-form'));?>
						<div class="profile-top-container py-5">
							
							<div class="col-lg-8 p-0 d-block mx-auto my-4">
								<div class="row">
									<div class="col-lg-6 mb-4">
										<?php // echo form_label('First name','first_name'); ?>
								        <?php echo form_input('first_name',set_value('first_name', $user->first_name),'class="form-control" placeholder="First name"'); ?>
								        <?php echo form_error('first_name', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
									<div class="col-lg-6 mb-4">
										<?php // echo form_label('Last name','last_name'); ?>
								        <?php echo form_input('last_name',set_value('last_name', $user->last_name),'class="form-control" placeholder="Last name"'); ?>
								        <?php echo form_error('last_name', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 mb-4">
										<?php // echo form_label('Organization name','company'); ?>
								        <?php echo form_input('company',set_value('company', $user->company),'class="form-control" placeholder="Organization name"'); ?>
								        <?php echo form_error('company', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
									<div class="col-lg-6 mb-4">
										<?php // echo form_label('Country','country'); ?>
										<?php
										
											$options = array(
															"" => "- Select -",
															"AF" => "Afghanistan",
															"AL" => "Albania",
															"DZ" => "Algeria",
															"AS" => "American Samoa",
															"AD" => "Andorra",
															"AO" => "Angola",
															"AI" => "Anguilla",
															"AQ" => "Antarctica",
															"AG" => "Antigua and Barbuda",
															"AR" => "Argentina",
															"AM" => "Armenia",
															"AW" => "Aruba",
															"AU" => "Australia",
															"AT" => "Austria",
															"AZ" => "Azerbaijan",
															"BS" => "Bahamas",
															"BH" => "Bahrain",
															"BD" => "Bangladesh",
															"BB" => "Barbados",
															"BY" => "Belarus",
															"BE" => "Belgium",
															"BZ" => "Belize",
															"BJ" => "Benin",
															"BM" => "Bermuda",
															"BT" => "Bhutan",
															"BO" => "Bolivia",
															"BA" => "Bosnia and Herzegovina",
															"BW" => "Botswana",
															"BV" => "Bouvet Island",
															"BR" => "Brazil",
															"IO" => "British Indian Ocean Territory",
															"BN" => "Brunei Darussalam",
															"BG" => "Bulgaria",
															"BF" => "Burkina Faso",
															"BI" => "Burundi",
															"KH" => "Cambodia",
															"CM" => "Cameroon",
															"CA" => "Canada",
															"CV" => "Cape Verde",
															"KY" => "Cayman Islands",
															"CF" => "Central African Republic",
															"TD" => "Chad",
															"CL" => "Chile",
															"CN" => "China",
															"CX" => "Christmas Island",
															"CC" => "Cocos (Keeling) Islands",
															"CO" => "Colombia",
															"KM" => "Comoros",
															"CG" => "Congo",
															"CD" => "Congo, the Democratic Republic of the",
															"CK" => "Cook Islands",
															"CR" => "Costa Rica",
															"CI" => "Cote D'Ivoire",
															"HR" => "Croatia",
															"CU" => "Cuba",
															"CY" => "Cyprus",
															"CZ" => "Czech Republic",
															"DK" => "Denmark",
															"DJ" => "Djibouti",
															"DM" => "Dominica",
															"DO" => "Dominican Republic",
															"EC" => "Ecuador",
															"EG" => "Egypt",
															"SV" => "El Salvador",
															"GQ" => "Equatorial Guinea",
															"ER" => "Eritrea",
															"EE" => "Estonia",
															"ET" => "Ethiopia",
															"FK" => "Falkland Islands (Malvinas)",
															"FO" => "Faroe Islands",
															"FJ" => "Fiji",
															"FI" => "Finland",
															"FR" => "France",
															"GF" => "French Guiana",
															"PF" => "French Polynesia",
															"TF" => "French Southern Territories",
															"GA" => "Gabon",
															"GM" => "Gambia",
															"GE" => "Georgia",
															"DE" => "Germany",
															"GH" => "Ghana",
															"GI" => "Gibraltar",
															"GR" => "Greece",
															"GL" => "Greenland",
															"GD" => "Grenada",
															"GP" => "Guadeloupe",
															"GU" => "Guam",
															"GT" => "Guatemala",
															"GN" => "Guinea",
															"GW" => "Guinea-Bissau",
															"GY" => "Guyana",
															"HT" => "Haiti",
															"HM" => "Heard Island and Mcdonald Islands",
															"VA" => "Holy See (Vatican City State)",
															"HN" => "Honduras",
															"HK" => "Hong Kong",
															"HU" => "Hungary",
															"IS" => "Iceland",
															"IN" => "India",
															"ID" => "Indonesia",
															"IR" => "Iran, Islamic Republic of",
															"IQ" => "Iraq",
															"IE" => "Ireland",
															"IL" => "Israel",
															"IT" => "Italy",
															"JM" => "Jamaica",
															"JP" => "Japan",
															"JO" => "Jordan",
															"KZ" => "Kazakhstan",
															"KE" => "Kenya",
															"KI" => "Kiribati",
															"KP" => "Korea, Democratic People's Republic of",
															"KR" => "Korea, Republic of",
															"KW" => "Kuwait",
															"KG" => "Kyrgyzstan",
															"LA" => "Lao People's Democratic Republic",
															"LV" => "Latvia",
															"LB" => "Lebanon",
															"LS" => "Lesotho",
															"LR" => "Liberia",
															"LY" => "Libyan Arab Jamahiriya",
															"LI" => "Liechtenstein",
															"LT" => "Lithuania",
															"LU" => "Luxembourg",
															"MO" => "Macao",
															"MK" => "Macedonia, the Former Yugoslav Republic of",
															"MG" => "Madagascar",
															"MW" => "Malawi",
															"MY" => "Malaysia",
															"MV" => "Maldives",
															"ML" => "Mali",
															"MT" => "Malta",
															"MH" => "Marshall Islands",
															"MQ" => "Martinique",
															"MR" => "Mauritania",
															"MU" => "Mauritius",
															"YT" => "Mayotte",
															"MX" => "Mexico",
															"FM" => "Micronesia, Federated States of",
															"MD" => "Moldova, Republic of",
															"MC" => "Monaco",
															"MN" => "Mongolia",
															"MS" => "Montserrat",
															"MA" => "Morocco",
															"MZ" => "Mozambique",
															"MM" => "Myanmar",
															"NA" => "Namibia",
															"NR" => "Nauru",
															"NP" => "Nepal",
															"NL" => "Netherlands",
															"AN" => "Netherlands Antilles",
															"NC" => "New Caledonia",
															"NZ" => "New Zealand",
															"NI" => "Nicaragua",
															"NE" => "Niger",
															"NG" => "Nigeria",
															"NU" => "Niue",
															"NF" => "Norfolk Island",
															"MP" => "Northern Mariana Islands",
															"NO" => "Norway",
															"OM" => "Oman",
															"PK" => "Pakistan",
															"PW" => "Palau",
															"PS" => "Palestinian Territory, Occupied",
															"PA" => "Panama",
															"PG" => "Papua New Guinea",
															"PY" => "Paraguay",
															"PE" => "Peru",
															"PH" => "Philippines",
															"PN" => "Pitcairn",
															"PL" => "Poland",
															"PT" => "Portugal",
															"PR" => "Puerto Rico",
															"QA" => "Qatar",
															"RE" => "Reunion",
															"RO" => "Romania",
															"RU" => "Russian Federation",
															"RW" => "Rwanda",
															"SH" => "Saint Helena",
															"KN" => "Saint Kitts and Nevis",
															"LC" => "Saint Lucia",
															"PM" => "Saint Pierre and Miquelon",
															"VC" => "Saint Vincent and the Grenadines",
															"WS" => "Samoa",
															"SM" => "San Marino",
															"ST" => "Sao Tome and Principe",
															"SA" => "Saudi Arabia",
															"SN" => "Senegal",
															"CS" => "Serbia and Montenegro",
															"SC" => "Seychelles",
															"SL" => "Sierra Leone",
															"SG" => "Singapore",
															"SK" => "Slovakia",
															"SI" => "Slovenia",
															"SB" => "Solomon Islands",
															"SO" => "Somalia",
															"ZA" => "South Africa",
															"GS" => "South Georgia and the South Sandwich Islands",
															"ES" => "Spain",
															"LK" => "Sri Lanka",
															"SD" => "Sudan",
															"SR" => "Suriname",
															"SJ" => "Svalbard and Jan Mayen",
															"SZ" => "Swaziland",
															"SE" => "Sweden",
															"CH" => "Switzerland",
															"SY" => "Syrian Arab Republic",
															"TW" => "Taiwan, Province of China",
															"TJ" => "Tajikistan",
															"TZ" => "Tanzania, United Republic of",
															"TH" => "Thailand",
															"TL" => "Timor-Leste",
															"TG" => "Togo",
															"TK" => "Tokelau",
															"TO" => "Tonga",
															"TT" => "Trinidad and Tobago",
															"TN" => "Tunisia",
															"TR" => "Turkey",
															"TM" => "Turkmenistan",
															"TC" => "Turks and Caicos Islands",
															"TV" => "Tuvalu",
															"UG" => "Uganda",
															"UA" => "Ukraine",
															"AE" => "United Arab Emirates",
															"GB" => "United Kingdom",
															"US" => "United States",
															"UM" => "United States Minor Outlying Islands",
															"UY" => "Uruguay",
															"UZ" => "Uzbekistan",
															"VU" => "Vanuatu",
															"VE" => "Venezuela",
															"VN" => "Viet Nam",
															"VG" => "Virgin Islands, British",
															"VI" => "Virgin Islands, U.s.",
															"WF" => "Wallis and Futuna",
															"EH" => "Western Sahara",
															"YE" => "Yemen",
															"ZM" => "Zambia",
															"ZW" => "Zimbabwe"
											);
										
										?>
								        <?php echo form_dropdown('country', $options, set_value('country', $user->country), 'class="custom-select"'); ?>
								        <?php echo form_error('country', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 d-none">
										<?php // echo form_label('Country Code','country_code'); ?>
								        <?php echo form_input('country_code',set_value('country_code', $user->country_code),'id="country_code" class="form-control" placeholder="Country Code"'); ?>
								        <?php echo form_error('country_code', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
									<div class="col-lg-12">
										<?php // echo form_label('Phone','phone'); ?>
								        <?php echo form_input('phone',set_value('phone', $user->phone),'class="form-control" placeholder="Mobile no"'); ?>
								        <?php echo form_error('phone', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
								</div>
							</div>
								
						</div>
						<div class="profile-bottom-container py-5">
						
							<div class="col-lg-8 p-0 d-block mx-auto my-4">
								<div class="row">
									<div class="d-none"> 
								 		<?php // echo form_label('Username','username'); ?>
								        <?php echo form_input('username',set_value('username', $user->username),'id="username" class="form-control" placeholder="Username" readonly="readonly"'); ?>
								        <?php echo form_error('username', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
								 	</div>
									<div class="col-lg-12 mb-4">
										<?php // echo form_label('Email','email'); ?>
								        <?php echo form_input('email',set_value('email', $user->email),'id="email" class="form-control" placeholder="Email" readonly="readonly"'); ?>
								        <?php echo form_error('email', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 mb-4">
										<?php // echo form_label('Password','password'); ?>
								        <?php echo form_password('password','','class="form-control" placeholder="Password"'); ?>
								        <?php echo form_error('password', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 mb-4">
										<?php // echo form_label('Confirm password','confirm_password'); ?>
								        <?php echo form_password('confirm_password','','class="form-control" placeholder="Confirm password"'); ?>
								        <?php echo form_error('confirm_password', '<p class="mt-2 mb-0 text-danger">', '</p>'); ?>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-9">
										<?php echo form_submit('profile', 'Save', 'id="btn-register" class="btn btn-red btn-block btn-save"');?>
									</div>
									<div class="col-lg-3">
										<a href="<?php echo base_url('/');?>" class="btn btn-red btn-block btn-save text-white">Cancel</a>
									</div>
								</div>
								
							</div>
							
						</div>
						<?php echo form_close(); ?>
						
						
					</div>
					
				</div>
			</section>
			
		</div>
		



<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/admin/css/intlTelInput.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/admin/js/intlTelInput.js'); ?>"></script>
<script type="text/javascript">
    
	var input = document.querySelector("#country_code");
  	var iti = window.intlTelInput(input);
   	    
    jQuery(document).ready( function() {
        	
    	jQuery("#country_code").on("countrychange", function(e, data) {
    		var countryData = iti.getSelectedCountryData();
	        var countrycode = countryData.dialCode;
	        jQuery('#country_code').val('+'+countrycode);
	    });
    	   
    });
    
</script>