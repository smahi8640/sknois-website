<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CartModel;

class Confirm extends BaseController {

	
	function __construct()
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
	

    public function index(){
        $user = $this->ionAuth->user()->row();
        	$records = vc_getcartitems();
		$carttotal = vc_carttotal();
		$cartcount = vc_cartcount();
        //$this->data['stockstatus'] = $check['status'];
		$this->data['records'] = $records;
		$this->data['carttotal'] = $carttotal;
		$this->data['cartcount'] = $cartcount;
        $where="";
		if(empty($user)){
			$where="where session_id='".$this->session->userdata('global_cart_session')."'";
		}else{
			$where="where user_id='".$user->id."'";
		}
		$this->data['sum'] = $this->db->query("select sum(price) as gr,sum(mrp) as gr_mrp from cart ".$where)->getRow();        
		$cart_detail = $this->db->query("select * from cart ".$where)->getResultArray();
        if(empty($cart_detail)){
            return redirect()->to('cart');
        }

		
	
		$this->data['cart_check'] =$cart_detail;
		
		 $record1 = array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'customer_address' => $user->customer_address,
                'customer_permanent_address' => $user->customer_permanent_address,
				'customer_city' => $user->customer_city,
				'customer_state' => $user->customer_state,
				'customer_pincode' => $user->customer_pincode,
				'country' => $user->country,
				'phone' => $user->phone
            );
		
		$states=$this->db->query("select * from states where id='".$user->customer_state."'")->getRow();


		$this->data['current_data'] = $user;
		
		
		return view('frontend/pages/checkout/confirm', $this->data);
    }
    
   
        
	public function confirm() {
		
			$records = vc_getcartitems();
		$carttotal = vc_carttotal();
		$cartcount = vc_cartcount();
        //$this->data['stockstatus'] = $check['status'];
		
		
		$siteconfiguration = $this->db->query("select * from settings_siteconfiguration")->getResult();
        //$siteconfiguration = $query->result();
	
        $user = $this->ionAuth->user()->row();		
		//print_r($this->session->userdata('global_cart_session'));exit;
		$where="";
		if(empty($user)){
			$where="where session_id='".$this->session->userdata('global_cart_session')."'";
		}else{
			$where="where user_id='".$user->id."'";
		}
		$cart_details = $this->db->query("select * from cart ".$where)->getResult();
        if(empty($cart_details)){
            return redirect()->to('cart');
        }
		
		/*print_r(json_encode($cart_data));
		exit;*/
		$sum= $this->db->query("select distinct(coupon_id) as coupon_id,sum(price) as gr,sum(mrp) as gr_mrp from cart ".$where." group by coupon_id")->getRow();
		
		$this->data['sum'] =$sum;		
		
		
			$user_id = $this->request->getPost('user_id');
			$customer_firstname = $this->request->getPost('customer_firstname');
            $customer_lastname = $this->request->getPost('customer_lastname');
            $customer_company = $this->request->getPost('customer_company');
            $customer_email = $this->request->getPost('customer_email');
            $customer_address = $this->request->getPost('customer_address');
            $customer_permanent_address = $this->request->getPost('customer_permanent_address');
            $customer_city = $this->request->getPost('customer_city');
            $customer_state = $this->request->getPost('customer_state');
			$customer_pincode = $this->request->getPost('customer_pincode');
			$customer_country = $this->request->getPost('customer_country');
			$country_code = $this->request->getPost('country_code');
			$customer_phonenumber = $this->request->getPost('customer_phonenumber');
			$payment_method = $this->request->getPost('payment_method');
			$shipping = ($this->request->getPost('shipping_method')) ? $this->request->getPost('shipping_method') : "0";
			$tax = ($this->request->getPost('tax')) ? $this->request->getPost('tax') : "0";

			//$cart = $this->cart->contents();
			
			
			
			/*$total_amount = 0;
			foreach ($cart_details as $item):
				$total_amount = $total_amount + $item->subtotal;
			
			endforeach;*/
			
			$order_number = 'J'.date('YmdHis');
	
            
			if($payment_method == 'Paypal') {
			   // $shipping='0';
			    $record = array(
                'user_id' => $user_id,
                'customer_id' => $user_id,
                'order_number' => $order_number,
                'order_details' => json_encode($cart_details),
                'mrp_amount' => $sum->gr_mrp,
                'discount_amount' => $sum->gr_mrp-$sum->gr,
                'final_amount' => $sum->gr,
                'shipping' => $shipping,
                'total_amount' => $carttotal['total_price']+$shipping+$tax,
                'payment_method' => $payment_method,
                'order_status' => '1',
                'status' => '0',
				'created_by' => $user_id,
				'created_date' => date('Y-m-d H:i:s')
            );
			
                $this->db->table('orders')->insert($record);
			$order_id=$this->db->insertID();
			
			$recordc = array(
                'user_id' => $user_id,
                'customer_firstname' => $customer_firstname,
                'customer_lastname' => $customer_lastname,
                //'customer_company' => $customer_company,
                'customer_email' => $customer_email,
                'customer_address' => $customer_address,
                'customer_permanent_address' => $customer_permanent_address,
				'customer_city' => $customer_city,
				'customer_state' => $customer_state,
				'customer_pincode' => $customer_pincode,
				'customer_country' => $customer_country,
				'country_code' => $country_code,
				'customer_phonenumber' => $customer_phonenumber,
				'customer_orderdetails' => json_encode($cart_details),
				'order_id' => $order_id,
				'created_by' => $user_id,
				'created_date' => date('Y-m-d H:i:s')
            );
             $this->db->table('customers')->insert($recordc);
			$customer_id=$this->db->insertID();
			
			
			$recorda = array();
                    $recorda['order_id'] = $order_id;
                    $recorda['order_status'] = '1';
                    $recorda['order_message'] = '';
                    $recorda['created_by'] = $user_id;
                    $recorda['created_date'] = date('Y-m-d H:i:s');
                     $this->db->table('ordersstatus_logs')->insert($recorda);
			        $log_id=$this->db->insertID();
			
    		$order_details = $this->db->query("select * from orders where order_number='".$order_number."'")->getRow();
    		$customer_details=$this->db->query("select * from customers where order_id='".$order_id."'")->getRow();
    		//$customer_details = $this->orders_model->customerdetails((int) $order_id);
    		$ordercart_details = json_decode($order_details->order_details);
    		
    		$sdata = $this->db->query("select * from states where id='".$customer_details->customer_state."'")->getRow();
    		
    		$cdata =$this->db->query("select * from countries where id='".$customer_details->customer_country."'")->getRow();
                            		
            
			
                $payment_action = base_url('paypal/create_payment_with_paypal');
                //$redirect_url = base_url('payment/ccaveneupayDone');
                //$cancel_url = base_url('payment/ccaveneucancelPayment');
               // $redirect_url = base_url('payment/paymentSuccess');
                $redirect_url = base_url('payment/ccaveneuResponseHandler');
               // $cancel_url = base_url('payment/ccaveneuResponseHandler');
                $grtotat=$carttotal['total_price']+$shipping+$tax;
                $paymentHTML = '<html>
                                    <head>
                                          <script>
                                             window.onload = function() {
                                                var d = new Date().getTime();
                                                document.getElementById("tid").value = d;
                                             };
                                          </script>
                                    </head>
                                    <body>
                                        <form method="POST" name="customerData" action="' . $payment_action . '">
                                             
                                            <input type="hidden" name="order_id" value="' . $order_number . '"/>
                                            <input type="hidden" name="merchant_param1" value="' . json_encode($record) . '"/>
                                            <input type="hidden" name="merchant_param2" value="' . $user_id . '"/>
                                            <input type="hidden" name="amount" value="' . $grtotat . '"/>
                                            <input type="hidden" name="currency" value="INR"/>
                                            <input type="hidden" name="redirect_url" value="' . $redirect_url . '"/>
                                            
                                            <input type="hidden" name="billing_name" value="' . $customer_firstname . ' ' . $customer_lastname . '"/>
                                            <input type="hidden" name="billing_email" value="' . $customer_email .'"/>
                                            <input type="hidden" name="billing_address" value="' . $customer_address . ' ' . $customer_permanent_address . '"/>
                                            <input type="hidden" name="billing_city" value="' . $customer_city . '"/>
                                            <input type="hidden" name="billing_state" value="' . $customer_state . '"/>
                                            <input type="hidden" name="billing_zip" value="' . $customer_pincode . '"/>
                                            <input type="hidden" name="billing_country" value="' . $customer_country . '"/>
                                            <input type="hidden" name="billing_tel" value="' . $customer_phonenumber . '"/>
                                        </form>
                                        <script language=\'javascript\'>document.customerData.submit();</script>
                                      </body>
                                    </html>';
                $paymentHTML1 = '<html>
                                    <head>
                                          <script>
                                             window.onload = function() {
                                                var d = new Date().getTime();
                                                document.getElementById("tid").value = d;
                                             };
                                          </script>
                                    </head>
                                    <body>
                                        <form method="POST" name="customerData" action="' . $payment_action . '">
                                            <input title="item_name" name="item_name" type="hidden" value="'.$order_number.'">
                                            <input title="item_number" name="item_number" type="hidden" value="1">
                                            <input title="item_description" name="item_description" type="hidden" value="">
                                            <input title="item_tax" name="item_tax" type="hidden" value="0">
                                            <input title="item_price" name="item_price" type="hidden" value="'.$grtotat.'">
                                            <input title="details_tax" name="details_tax" type="hidden" value="0">
                                            <input title="details_subtotal" name="details_subtotal" type="hidden" value="'.$grtotat.'">
                                        </form>
                                        <script language=\'javascript\'>document.customerData.submit();</script>
                                      </body>
                                    </html>';                    
                                
                                
			    
                /*$this->db->where('session_id', $this->session->userdata('global_cart_session'));
		        $this->db->delete('cart');
		        
                $this->cart->destroy();*/
                echo $paymentHTML1;
                exit;

            } 
            else {
                /*if($total_amount <= '100'){
					    $shipping="30";
					} else if($total_amount >= '201'){
					    $shipping="0";
					} else if($total_amount >= '101' && $total_amount <= '200'){
					    $shipping="20";
					}*/
				
				//$shipping='0';
                $record = array(
                'user_id' => $user_id,
                'customer_id' => $user_id,
                'order_number' => $order_number,
                'order_details' => json_encode($cart_details),
                'mrp_amount' => $sum->gr_mrp,
                'discount_amount' => $sum->gr_mrp-$sum->gr,
                'final_amount' => $sum->gr,
                'coupon_code' => $coupon_data->code,
                'coupon_amount' => $discount,
                'shipping' => $shipping,
                'tax' => $tax,
                'total_amount' => $final_cost+$shipping+$tax,
                'payment_method' => $payment_method,
                'order_status' => '1',
                'status' => '0',
				'created_by' => $user_id,
				'created_date' => date('Y-m-d H:i:s')
            );
			
			$order_id = $this->checkout_model->save_orderrecord($record);
			
			$record = array(
                'user_id' => $user_id,
                'customer_firstname' => $customer_firstname,
                'customer_lastname' => $customer_lastname,
                'customer_company' => $customer_company,
                'customer_email' => $customer_email,
                'customer_address' => $customer_address,
                'customer_permanent_address' => $customer_permanent_address,
				'customer_city' => $customer_city,
				'customer_state' => $customer_state,
				'customer_pincode' => $customer_pincode,
				'customer_country' => $customer_country,
				'country_code' => $country_code,
				'customer_phonenumber' => $customer_phonenumber,
				'customer_orderdetails' => json_encode($cart_details),
				'order_id' => $order_id,
				'created_by' => $user_id,
				'created_date' => date('Y-m-d H:i:s')
            );
			
			$customer_id = $this->checkout_model->save_record($record);
			
			$recorda = array();
                    $recorda['order_id'] = $order_id;
                    $recorda['order_status'] = '1';
                    $recorda['order_message'] = '';
                    $recorda['created_by'] = $user_id;
                    $recorda['created_date'] = date('Y-m-d H:i:s');
    				$log_id = $this->orders_model->save_orderlogrecord($recorda);
			
		  	$this->db->select ('*');
            $this->db->where('order_number',$order_number);
            $this->db->from('orders');
    		$order_details = $this->db->get()->row();
    		$customer_details=$this->db->get_where('customers', array('order_id' => $order_id))->result();
    		//$customer_details = $this->orders_model->customerdetails((int) $order_id);
    		$ordercart_details = json_decode($order_details->order_details);
    		
    		$this->db->select ('*');
            $this->db->where('id',$customer_details[0]->customer_state);
            $this->db->from('states');
    		$sdata = $this->db->get()->row();
    		
    		$this->db->select ('*');
            $this->db->where('id',$customer_details[0]->customer_country);
            $this->db->from('countries');
    		$cdata = $this->db->get()->row();
                            		
                    $data['order_number']=$order_number;            
                    $html = $this->load->view('emails/orders',$data,true);  
                    $this->load->library('email');				
        			$this->email->from($settings->site_email, 'Treasta-Orders');
        			$this->email->to($customer_details[0]->customer_email);								
        			$this->email->subject('Treasta : Orders');
        			$this->email->message($html);				
        			$this->email->send();
					
					//$this->email->from('orders@choicecorner.in', 'Choice Corner');
					//$this->email->to($data['email']);
				//	$this->email->subject('Order');
				//	$this->email->message($msg);
					//$this->email->send();
                
                    $html = 'Your order with '.$order_details->order_number.' is successfully placed';
                    //$html = str_replace('[MESSAGE]', $recorda['order_message'], $html);
                    $mobile_message = $html;
                    
                    $param['mobiles'] = $customer_phonenumber;
        			$param['message'] = $mobile_message;
    			
        			$url = $siteconfiguration[0]->site_sms_api.http_build_query($param);
        			$ch = curl_init($url);
        			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        			$curl_scraped_page = curl_exec($ch);
        			curl_close($ch);
        			$response = ($curl_scraped_page!="")?explode("|", $curl_scraped_page):'';
			    
			    
			    
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('message', 'Order placed successfully.');
                
                $this->db->where('session_id', $this->session->userdata('global_cart_session'));
		        $this->db->delete('cart');
		        
                $this->cart->destroy();
               return redirect()->to('/payment/paymentSuccess/'.$customer_id); 

            }
            
            
                
            
            
            //$this->data['current_data']=$record;
            //print_r($record);
            //$this->render('checkout/confirm');
			return redirect()->to('/payment/paymentSuccess');
		
		
	}
	
	
	// LOGIN
	public function login()
	{	
			
		if($this->ion_auth->logged_in()) {
			return redirect()->to('profile', 'refresh');
		}
		
		$this->data['page_title'] = 'Login';
		if($this->input->post())
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('identity', 'Identity', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('remember','Remember me','integer');
			if($this->form_validation->run()===TRUE)
			{
				$remember = (bool) $this->input->post('remember');
				if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
				{
					return redirect()->to('/checkout', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'danger');
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					return redirect()->to('login', 'refresh');
				}
			}
		}
		$this->render('checkout/confirm');
		
	}


	public function getstates() {

        $country_id = $this->input->post('country_id');

        $where = array();
        $where['country_id'] = $country_id;

        $states_list = $this->checkout_model->statelistwhere($where);

        $html = '';
        foreach ($states_list AS $state) {
            $html .= '<option value="'.$state->id.'">'.$state->name.'</option>';
        }

        echo $html;
        exit;

    }
	
}
