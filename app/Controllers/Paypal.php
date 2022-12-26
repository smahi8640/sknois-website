<?php namespace App\Controllers;
use App\Controllers\BaseController;
//require_once(APPPATH . 'libraries/checkout-php-sdk/samples/bootstrap.php'); // require paypal files
require_once(APPPATH . 'Libraries/vendor/autoload.php'); // require paypal files
//require __DIR__ . '/vendor/autoload.php';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;


/*use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Amount;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;*/


class Paypal extends BaseController
{
    public $_api_context;

    function  __construct()
    {
        /*$this->config['client_id'] = 'AQNnVTAPlsF6BW4rTwyHXsm4IPy3tJBviFVhdpxJtRbl9_X7sShXsLV05HqF8XQa2JWWNe3gn_OINAnN';
        $this->config['secret'] = 'EB-Bo53UNETJBqFVFyW8ADVfbAdbVGGe1ahmcNygUSKQv7qvQM-k2hLw6_0mfxwIMj9mSys7dUuPOHbn';
        $this->config['mode'] ='sandbox';*/
        
        $this->config['client_id'] = 'AWvnfYbED754yT7a3ntxDhs6s_bpYM8MrKbPeF46SxNajkiI1UQEH_UibhBkzoBy4915t1EMmex5jeyg';
        $this->config['secret'] = 'EP7ISGG-pJ6T4cKdlAGA9tjmWqZCxioL-795ok9geX8_0p6TevAT_gYX18CAABwTqQCqMdGiGN53Z8wN';
        $this->config['mode'] ='live';
    }

    function create_payment_with_paypal(){
        $baseUrl = base_url();
        $clientId = $this->config['client_id'];
        $clientSecret = $this->config['secret'];
        if($this->config['mode']=='live'){
        $environment = new ProductionEnvironment($clientId, $clientSecret);
        }else if($this->config['mode']=='sandbox'){
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        }
        $client = new PayPalHttpClient($environment);
        //$this->load->view('payment_credit_form');
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                             "intent" => "CAPTURE",
                             "purchase_units" => [[
                                 "reference_id" => $this->request->getPost('item_name'),
                                 "amount" => [
                                     "value" => $this->request->getPost('item_price'),
                                     "currency_code" => "USD"
                                 ]
                             ]],
                             "application_context" => [
                                  "cancel_url" => $baseUrl."/paypal/getPaymentStatus?id=".$this->request->getPost('item_name'),
                                  "return_url" => $baseUrl."/paypal/getPaymentStatus?id=".$this->request->getPost('item_name')
                             ] 
                         ];
        
        try {
            
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
           $results=$response->result->links;
            //print_r($response);exit;
            foreach($results as $link) {
            if($link->rel == 'approve') {
                $redirect_url = $link->href;
                break;
                }
            }
    
            if(isset($redirect_url)) {
                
                return redirect()->to($redirect_url);
            }
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
             throw new Exception("Payment not processed");
        }catch (Exception $ex) {
           // echo $ex->statusCode;
           // print_r($ex->getMessage());
            //$this->session->set_flashdata('success_msg',$ex->getMessage());
            //$this->render('payment/payment_cancel');
            return redirect()->to('paypal/cancel?id='.$order_number.'&error='.$ex->getMessage());
        }
       
    }


  
    public function getPaymentStatus()
    {
        $order_number=$this->request->getVar("id");
        // paypal credentials

        /** Get the payment ID before session clear **/
        //$payment_id = $this->input->get("paymentId") ;
        $PayerID = $this->request->getVar("PayerID") ;
        $token = $this->request->getVar("token") ;
        
        $baseUrl = base_url();
        $clientId = $this->config['client_id'];
        $clientSecret = $this->config['secret'];
        if($this->config['mode']=='live'){
        $environment = new ProductionEnvironment($clientId, $clientSecret);
        }else if($this->config['mode']=='sandbox'){
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        }
        $client = new PayPalHttpClient($environment);
        
        /** clear the session payment ID **/

        if (empty($PayerID) || empty($token)) {
            
            //$this->session->set_flashdata('success_msg','Payment failed');
            
            $this->cancel_check($order_number,'Payment Failed');
            return redirect()->to('paypal/cancel?id='.$order_number.'&error=Payment Failed');
        }

        $request = new OrdersCaptureRequest($token);
        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            $statuscode=$response->statusCode;
            //  DEBUG RESULT, remove it later **/
            if ($statuscode=="201" && $response->result->status == 'COMPLETED') {
                
                //$this->session->set_flashdata('success_msg','Payment success');
                
                //$this->render('payment/payment_success');
                try {
                $this->success_check($order_number);
                return redirect()->to('paypal/success/'.$order_number);
                }catch (Exception $ex) {
                    $error= $ex->getMessage();
                    $this->cancel_check($order_number,$error);

                return redirect()->to('paypal/cancel?id='.$order_number.'&error='.$error);
                }
                //$this->render('payment/payment_success');
                
            }else{
               $error=json_decode($response->getMessage())->details['0']->issue;
               $error.="<br>".json_decode($response->getMessage())->details['0']->description;
               //print_r($error);exit;
            //$this->session->set_flashdata('success_msg','Payment failed');
            
            $this->cancel_check($order_number,'Payment Failed');

            return redirect()->to('paypal/cancel?id='.$order_number.'&error='.$error);
            }
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //print_r($response);exit;
        }catch (HttpException $ex) {
           // echo $ex->statusCode;
            print_r($ex->getMessage());exit;
            //$this->session->set_flashdata('success_msg',$ex->getMessage());
            
            
            $this->cancel_check($order_number,$ex->getMessage());
            return redirect()->to('paypal/cancel?id='.$order_number.'&error='.$ex->getMessage());
        }

        //$response = $client->execute(new OrdersGetRequest($token));
        //print_r($response);exit;
        
    }

    public  function success($order_number=NULL){   
       
        $order_details=$this->db->query("select * from orders where order_number='".$order_number."'")->getRow();
        if($order_details->order_status=='2'){
            $this->data['order_details']=$order_details;
            return view('frontend/pages/payment/payment_success', $this->data);
        }else{
            return redirect()->to('cart', 'refresh');
        }
    }

  public  function success_check($order_number=NULL){     
        // if(!$this->ion_auth->logged_in()) {	
        //     redirect('login', 'refresh');
		// }                     
        //$user = $this->ion_auth->user()->row_array();          
//$order_details=$this->db->query("select * from orders where order_number='".$order_number."' and user_id='".$user['id']."' and order_status='2'")->row();
$order_details=$this->db->query("select * from orders where order_number='".$order_number."'")->getRow();
if($order_details->order_status=='1'){ 


$ordercart_details = json_decode($order_details->order_details);
/*foreach ($ordercart_details AS $order) {
$product_stock=$this->db->query("select  * from product_stock where product_sku='".$order->sku."'")->row();    
$record = array();
$record['stock'] = $product_stock->stock - $order->qty;
$this->db->where('sku', $order->sku);
$this->db->update('product_details', $record);
}*/


$record1['order_status'] = "2";
$record1['tracking_id'] = "";
$this->db->table('orders')->where('id',$order_details->id)->update($record1);

/*$this->db->where('order_id', $order_details->id);
$this->db->update('ordersstatus_logs', $record1);*/

$recorda = array();
$recorda['order_id'] = $order_details->id;
$recorda['order_status'] = '2';
$recorda['order_message'] = '';
//$recorda['created_by'] = $user_id;
$recorda['created_date'] = date('Y-m-d H:i:s');
$this->db->table('ordersstatus_logs')->insert($recorda);

$siteconfiguration = $this->db->query("select * from settings_siteconfiguration")->getResult();
$customer_details=$this->db->query("Select * from customers where order_id='".$order_details->id."'")->getResult();

$ordercart_details = json_decode($order_details->order_details);
$cart = array();
foreach ($ordercart_details AS $order) {
    $cart[] = array(
        'id' => $order->id,
            'user_id' => $order->user_id,
            'session_id'=>$order->session_id,
            'cart_row_id'=>$order->cart_row_id,
            'product_id'=>$order->product_id,
            'product_stock_id'=>$order->product_stock_id,
            'product_set_id'=>$order->product_set_id,
            'set_product_json'=>$order->set_product_json,
            'sku'=>$order->sku,
            'title'=>$order->title,
            'image'=>$order->image,
            'qty'=>$order->qty,
            'price'=>$order->price,
            'mrp'=>$order->mrp,
            'color'=>$order->color,
            'size'=>$order->size,
            'purity'=>$order->purity,
            'types'=>$order->types,
            'order_amount'=>$order->order_amount,
            'coupon_id'=>$order->coupon_id,
            'coupon_amount'=>$order->coupon_amount,
            'created_by'=>$order->created_by,
            'created_date'=>$order->created_date,
            'updated_by'=>$order->updated_by,
            'updated_date'=>$order->updated_date  
    );
    
    

    $cartlogs = array(
        'order_id'=>$order_details->id,
        'order_item_id'=>$order->id,
        'status'=>'2',
        'created_by'=>'0',
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_by'=>'0',
        'updated_at'=>date('Y-m-d H:i:s'),
        'remarks'=> '' 
    );
    
    //$this->db->table('order_item_statuslogs')->insert($cartlogs);

}
    $updatecart=array('order_details'=>json_encode($cart));
    
    $this->db->table('orders')->where('id',$order_details->id)->update($updatecart);

$sdata = $this->db->query("select * from states where id='".$customer_details[0]->customer_state."'")->getRow();
    		
$cdata =$this->db->query("select * from countries where id='".$customer_details[0]->customer_country."'")->getRow();
$this->data['order_details']=$order_details;

					$data['order_number']=$order_number;            
                    $html = view('frontend/pages/emails/orders',$data);  
                    
                    
                    $this->email->setMailType('html');
                    $this->email->setFrom($siteconfiguration[0]->site_email, 'Joyari-Orders');
                    $this->email->setTo($customer_details[0]->customer_email);
                    $this->email->setCC($siteconfiguration[0]->site_email);
                    //$this->email->setBCC('abdeali@vcaretechnologies.net');
                    $this->email->setSubject('Joyari : Orders');
                    $this->email->setMessage($html);
                    $this->email->send();
        
					
					//$this->email->from('orders@choicecorner.in', 'Choice Corner');
					//$this->email->to($data['email']);
				//	$this->email->subject('Order');
				//	$this->email->message($msg);
					//$this->email->send();
                
                    $html = 'Your order with '.$order_details->order_number.' is successfully placed';
                    //$html = str_replace('[MESSAGE]', $recorda['order_message'], $html);
                    $mobile_message = $html;
                    
                    $param['mobileno'] = $customer_details[0]->customer_phonenumber;
        			$param['text'] = $mobile_message;
    			
        			$url = $siteconfiguration[0]->site_sms_api.http_build_query($param);
        			$ch = curl_init($url);
        			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        			$curl_scraped_page = curl_exec($ch);
        			curl_close($ch);
        			$response = ($curl_scraped_page!="")?explode("|", $curl_scraped_page):'';
    		    
    		    //$session_id = session_id();
		        
		        $this->db->table('cart')->where('user_id',$order_details->user_id)->delete();
		        //$session_id->destroy();
		        
                //$this->cart->destroy();
        
        
        }
    
        //$this->load->view("payment/payment_success");
    }

    function cancel_check($order_number=NULL,$error=NULL){

        $order_details=$this->db->query("select * from orders where order_number='".$order_number."'")->getRow();  

    $ordercart_details = json_decode($order_details->order_details);
    $cart = array();
    foreach ($ordercart_details AS $order) {
        $cart[] = array(
            'id' => $order->id,
            'user_id' => $order->user_id,
            'session_id'=>$order->session_id,
            'cart_row_id'=>$order->cart_row_id,
            'product_id'=>$order->product_id,
            'product_stock_id'=>$order->product_stock_id,
            'product_set_id'=>$order->product_set_id,
            'set_product_json'=>$order->set_product_json,
            'sku'=>$order->sku,
            'title'=>$order->title,
            'image'=>$order->image,
            'qty'=>$order->qty,
            'price'=>$order->price,
            'mrp'=>$order->mrp,
            'color'=>$order->color,
            'size'=>$order->size,
            'types'=>$order->types,
            'order_amount'=>$order->order_amount,
            'coupon_id'=>$order->coupon_id,
            'coupon_amount'=>$order->coupon_amount,
            'created_by'=>$order->created_by,
            'created_date'=>$order->created_date,
            'updated_by'=>$order->updated_by,
            'updated_date'=>$order->updated_date  
        );
        
        

        $cartlogs = array(
            'order_id'=>$order_details->id,
            'order_item_id'=>$order->id,
            'status'=>'8',
            'created_by'=>'0',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>'0',
            'updated_at'=>date('Y-m-d H:i:s'),
            'remarks'=> '' 
        );
       // $this->db->table('order_item_statuslogs')->insert($cartlogs);

    }
    $updatecart=array('order_details'=>json_encode($cart));
    $this->db->table('orders')->where('id',$order_details->id)->update($updatecart);


        $this->data['error']=$error;
            $record = array(
                    'order_status' => "8"
                );
            $this->db->table('orders')->where('order_number',$order_number)->update($record);
            $order_details=$this->db->query("select * from orders where order_number='".$order_number."'")->getRow();
            $recorda = array();
            $recorda['order_id'] = $order_details->id;
            $recorda['order_status'] = '8';
            $recorda['order_message'] = '';
            //$recorda['created_by'] = $user_id;
            $recorda['created_date'] = date('Y-m-d H:i:s');
            $this->db->table('ordersstatus_logs')->insert($recorda);   				
       
     }

    function cancel(){
        $this->data['order_number']=$this->request->getVar("id");
    	$this->data['error']=$this->request->getVar("error");
    	return view('frontend/pages/payment/payment_cancel', $this->data);
       // $this->load->view("payment/payment_cancel");
    }

   
}