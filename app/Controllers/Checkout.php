<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CartModel;

class Checkout extends BaseController {

	public function __construct()
	{

		$this->ionAuth    = new \IonAuth\Libraries\IonAuth();
		$this->validation = \Config\Services::validation();
		helper(['form', 'url']);
		$this->configIonAuth = config('IonAuth');
		$this->session       = \Config\Services::session();
        $this->db      = \Config\Database::connect();
		$this->CartModel = new CartModel();

		if (! empty($this->configIonAuth->templates['errors']['list']))
		{
			$this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
		}

	}

        
	public function index() {
		
        $currentuser = $this->ionAuth->user()->row();
        
			$records = vc_getcartitems();
		$carttotal = vc_carttotal();
		$cartcount = vc_cartcount();
        //$this->data['stockstatus'] = $check['status'];
		$this->data['records'] = $records;
		$this->data['carttotal'] = $carttotal;
		$this->data['cartcount'] = $cartcount;
		
		if(!empty($currentuser)) {	
			$this->data['current_user'] = $currentuser;
			return view('frontend/pages/checkout/checkout', $this->data);				
		} else {
		    
			return view('frontend/pages/checkout/checkout_guest', $this->data);
		}
			
		
		
	}
	
	public function confirm(){

		$customer_firstname = $this->request->getPost('customer_firstname');
		$customer_lastname = $this->request->getPost('customer_lastname');
		$customer_address = $this->request->getPost('customer_address');
		$customer_permanent_address = $this->request->getPost('customer_permanent_address');
		$customer_pincode = $this->request->getPost('customer_pincode');
		$customer_city = $this->request->getPost('customer_city');
		$customer_country = $this->request->getPost('customer_country');
		$customer_state = $this->request->getPost('customer_state');
		$customer_email = $this->request->getPost('customer_email');
		$customer_phonenumber = $this->request->getPost('customer_phonenumber');
		$user_id = $this->request->getPost('user_id');

		$data = array();
		$data['first_name'] = $customer_firstname;
		$data['last_name'] = $customer_lastname;
		$data['phone'] = $customer_phonenumber;
		$data['customer_address'] = $customer_address;
		$data['customer_permanent_address'] = $customer_permanent_address;
		$data['customer_pincode'] = $customer_pincode;
		$data['customer_city'] = $customer_city;
		$data['country'] = $customer_country;
		$data['customer_state'] = $customer_state;
        
		if($user_id != '') {
		     $this->db->table('users')->where('id',$user_id)->update($data);
		//	$this->ionAuth->update($user_id, $data);
		}
		
		$data['email'] = $customer_email;

		$records = vc_getcartitems();



		$carttotal = vc_carttotal();
		$cartcount = vc_cartcount();

		$this->data['records'] = $records;
		$this->data['carttotal'] = $carttotal;
		$this->data['cartcount'] = $cartcount;

		$this->data['user_id'] = $user_id;
		$this->data['user_details'] = $data;

		
		return redirect()->to('confirm'); 
            
		}

		public function otp() {
		    $return_url = $this->request->getVar('return_url'); 
    		if($return_url != '') {
    			$return_url = base64_decode($return_url);
    		} else {
    			$return_url = site_url();
    		}
			$session_id = session_id();
				$otp_number = $this->request->getPost('digit-1').$this->request->getPost('digit-2').$this->request->getPost('digit-3').$this->request->getPost('digit-4');
		
			    $email=$this->request->getPost('email');
			$user=$this->db->query("select * from users where email='".$email."' and otp_number='".$otp_number."'")->getRow();
			if($user){
			 $record['user_id'] = $user->id;
			 $this->db->table('cart')->where('session_id',$session_id)->update($record);
			$data = array(
				'active' => 1,
			);
			
			 $this->db->table('users')->where('otp_number',$otp_number)->update($data);
			 
			if ($this->ionAuth->login_otp($user->email, $otp_number,'email', '','email'))
			{
			$users = $this->ionAuth->user()->row();
            $record['user_id'] = $user->id;
		    $this->db->table('cart')->where('session_id',$session_id)->update($record);
			//print_r($users);exit;

		/*	$record['user_id'] = $users->id;
			$this->db->where('session_id', $global_cart_session);
			$this->db->update('cart', $record);*/
            
            
			 echo json_encode(array('message_type'=>'success','message'=>'successfull','url'=>$return_url));
			}
			}else{
			echo json_encode(array('message_type'=>'error','message'=>'error'));
			}
			
		}	
	
	// LOGIN
	public function login()
	{	
	    $session_id = session_id();
		if(!empty($this->request->getPost('email'))){
           $identity_column = 'email';
           $identity = $this->request->getPost('email'); 
        }else if(!empty($this->request->getPost('phone'))){
            $identity_column = 'phone';
            $identity = $this->request->getPost('phone');
        }else{
            $identity_column = 'username';
            $identity = $this->request->getPost('username');
        }
			$remember = 1;
			if ($this->ionAuth->login($identity, $this->request->getPost('password'), $remember))
			{
			    $user = $this->ionAuth->user()->row();
			    $record['user_id'] = $user->id;
			    $this->db->table('cart')->where('session_id',$session_id)->update($record);
				echo json_encode(array('message_type'=>'success','message'=>'successfull'));
			}
			else
			{
				echo json_encode(array('message_type'=>'error','message'=>strip_tags($this->ionAuth->errors($this->validationListTemplate))));
			}
		
	}
	
	public function resendotp()
	{
	    $otp_number = rand(1000, 9999);
	     $email = $this->request->getPost('email');
	    $check=$this->db->query("select * from users where email='".$email."'")->getRow();
        if($check){
            
            $record['otp_number'] = $otp_number;
			$this->db->table('users')->where('email',$email)->update($record);
            
            $settings=$this->db->query("SELECT * FROM settings_siteconfiguration")->getRow();
		    $otp['otp_number']=$otp_number;            
            $html = view('frontend/pages/emails/otp',$otp);  
	        //$this->load->library('email');				
	        
	            $this->email->setMailType('html');
                $this->email->setFrom($settings->site_email, 'Joyari');
                $this->email->setTo($email);
                $this->email->setBCC($settings->site_email);
                $this->email->setSubject('Joyari : OTP');
                $this->email->setMessage($html);
                $this->email->send();
                echo json_encode(array('message_type'=>'success','message'=>'successfull-'.$otp_number));
        }
	}

    // REGISTER 
    public function guestregister()
	{
	    
	
        //$this->form_validation->set_rules('email','Email','trim|valid_email|required|is_unique[users.email]');
        $otp_number = rand(1000, 9999);
			
            $phone = $this->request->getPost('phone');
            $email = $this->request->getPost('email');
			$identity = $this->request->getPost('email');
 
            $additional_data = array(
                //'phone' => $phone,
                'photo' => 'avatars/3.jpg',
				'otp_number' => $otp_number
            );
             //print_r($this->ion_auth->register($username,$phone,$email,$additional_data));
             //exit(0);
             $check=$this->db->query("select * from users where email='".$email."'")->getRow();
             
             if(empty($check)){
            $insert_id  = $this->ionAuth->register($identity, $email, $email, $additional_data, array('3'));
			
            if($insert_id) {
				
				$settings=$this->db->query("SELECT * FROM settings_siteconfiguration")->getRow();
			    $otp['otp_number']=$otp_number;            
                $html = view('frontend/pages/emails/otp',$otp);  
		        //$this->load->library('email');				
		        
		            $this->email->setMailType('html');
                    $this->email->setFrom($settings->site_email, 'Joyari');
                    $this->email->setTo($email);
                    $this->email->setBCC($settings->site_email);
                    $this->email->setSubject('Joyari : OTP');
                    $this->email->setMessage($html);
                    $this->email->send();
        
				/*$this->email->from($settings->site_email, 'Joyari');
				$this->email->to($email);								
				$this->email->subject('Joyari : OTP');
				$this->email->message($html);				
				$this->email->send();*/
				
				
				/*$param['mobileno'] = $phone;
    			$param['text'] = "OTP number :".$otp_number;
    			//$param['apikey'] = "5fc7789ba25d9";
    			//$param['route'] = "promo_dnd";
    			//$param["sender"] = "NOTIFC";
    			
    			$url = $settings->site_sms_api.http_build_query($param);
    			$ch = curl_init($url);
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    			$curl_scraped_page = curl_exec($ch);
    			curl_close($ch);
    			$response = ($curl_scraped_page!="")?explode("|", $curl_scraped_page):'';*/
            	
               /* $this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('message', $this->ion_auth->messages());*/
				
		       //redirect('/checkout/otp'); 
		        echo json_encode(array('message_type'=>'success','message'=>'successfull-'.$otp_number));
                
            } else {                
                /*$this->session->set_flashdata('message_type', 'danger');
				$this->session->set_flashdata('message', $this->ion_auth->errors());*/ 
                echo json_encode(array('message_type'=>'error','message'=>'error'));
            }
            }else{
                
                $data = array(
				'otp_number' => $otp_number,
    			);
    			
    			 $this->db->table('users')->where('email',$email)->update($data);
			 
                	$settings=$this->db->query("SELECT * FROM settings_siteconfiguration")->getRow();
			    $otp['otp_number']=$otp_number;            
                $html = view('frontend/pages/emails/otp',$otp);  
                
                    $this->email->setMailType('html');
                    $this->email->setFrom($settings->site_email, 'Joyari');
                    $this->email->setTo($email);
                    $this->email->setBCC($settings->site_email);
                    $this->email->setSubject('Joyari : OTP');
                    $this->email->setMessage($html);
                    $this->email->send();
                echo json_encode(array('message_type'=>'error','message'=>'email already registered'));
            }
            /*$this->output
        		->set_content_type("application/json")
        		->set_output(json_encode($data));*/
        		 
        
		
	}
	
	

public function getstates() {
       $user = $this->ionAuth->user()->row();
        $country_id = $this->request->getPost('country_id');

        $where = array();
        $where['country_id'] = $country_id;
        
        //$where1['country_id'] = '101';
        
        $states_list = $this->db->query("select * from states where country_id='".$country_id."'")->getResult();
        
        $html = '';
        $options[''] = '--';
        foreach ($states_list AS $state) {
            $options[$state->id] = $state->name;
            
          //  $html .= '<option value="'.$state->id.'">'.$state->name.'</option>';
        }
        /*print_r($options);
        exit(0);*/
       // if($user->customer_state!=""){ echo form_dropdown('customer_state', $options, $user->customer_state, 'class="form-control" id="customer_state" required ');
			               /* }else{*/ echo form_dropdown('customer_state', $options, $user->customer_state, 'class="form-control" id="customer_state" required');//}
       // echo form_dropdown('customer_state', $options, set_value('customer_state', $user->customer_state), 'class="form-control" id="customer_state"');

        //echo $html;
        
        exit;

    }
	
}
