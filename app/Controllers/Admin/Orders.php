<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Slug;   // use the Slug Library

class Orders extends BaseController
{

	public $data = [];
	
	
	public function __construct()
	{
		
		
        $this->db      = \Config\Database::connect();
	}


	public function index()
	{
		if (! $this->ionAuth->loggedIn())
		{
			// redirect them to the login page
			return redirect()->to('login');
		}
		else if (! $this->ionAuth->isAdmin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			//show_error('You must be an administrator to view this page.');
			throw new \Exception('You must be an administrator to view this page.');
		}
		else
		{

			$task = $this->request->getPost('task');

			if($task == 'delete') {				
				$record_ids = $this->request->getPost('record_id');				
				$this->delete($record_ids);
			}

			$this->data['title'] = 'Orders';

			// set the flash data error message if there is one
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
			
			//list the groups
			//$this->data['records'] = $this->ionAuth->groups()->result();

			$this->data['records'] = $this->db->query("select * from orders order by id desc")->getResult();
			//$this->data['pager'] = $this->OrdersModel->pager;
			
			return view('admin/pages/orders/index', $this->data);
		}
	}


	

	public function view(int $id)
	{
		$this->data['title'] = 'Orders : View';

		if (! $this->ionAuth->loggedIn() || (! $this->ionAuth->isAdmin() && ! ($this->ionAuth->user()->row()->id == $id)))
		{
			return redirect()->to('login');
		}
		
		
		$this->currentuser = $this->ionAuth->user()->row();
		
		$record = $this->db->query("select * from orders where id='".$id."'")->getRow();

		// set the flash data error message if there is one
		$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : ($this->ionAuth->errors() ? $this->ionAuth->errors() : $this->session->getFlashdata('message'));

		$this->data['record']  = $record;

		return view('admin/pages/orders/view', $this->data);

	}


    public function edit(int $id)
	{

		$this->data['title'] = 'Order : Edit';
		if (! $this->ionAuth->loggedIn() || (! $this->ionAuth->isAdmin() && ! ($this->ionAuth->user()->row()->id == $id)))
		{
			return redirect()->to('login');
		}		

		$this->currentuser = $this->ionAuth->user()->row();
		if (! empty($this->request->getPost()))
		{

            // validate form input
			$this->validation->setRule('order_status', 'Order Status', 'trim|required');			

			// do we have a valid request?
			if ($id !== $this->request->getPost('id', FILTER_VALIDATE_INT))
			{
				//show_error(lang('Auth.error_security'));
				throw new \Exception(lang('Auth.error_security'));
			}

			if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
			{			

				$record = array();
				$record['id'] = $id;
                $record['order_status'] = $this->request->getPost('order_status');
                $record['docket_no'] = $this->request->getPost('docket_no');
                $record['courrier_name'] = $this->request->getPost('courrier_name');
				$record['updated_by'] = $this->currentuser->id;
				$record['updated_at'] = date('Y-m-d H:i:s');				

				$this->OrdersModel->save($record);

				$this->session->setFlashdata('message', 'Record updated successfully.');
				

				/*$redirect_url = site_url('admin/orders');
				$currentpage = 1;
				if($currentpage > 1) {
					$redirect_url = site_url('admin/orders?page='.$currentpage);
				}*/
                $redirect_url = site_url('admin/orders/view/'.$id);

				return redirect()->to($redirect_url);

			}

		}

	}

    
    public function generateShipping($id="")
	{
	
	       $orders=$this->db->query("select * from db_ems_orders where id='".$id."'")->getRow();
           $order_details = json_decode($orders->order_details);
           $orders->order_userdetails = trim(preg_replace('/\s\s+/', ' ', $orders->order_userdetails));
           $order_userdetails = json_decode($orders->order_userdetails);
           
           $sdata = $this->db->query("select * from db_ems_states where id='".$order_userdetails->state_id."'")->getRow();
    	   $cdata = $this->db->query("select * from db_ems_countries where id='".$order_userdetails->country_id."'")->getRow();
           
            if(!empty($orders)){
                $orderdetails=[];
                foreach($order_details AS $order_detail) {
                    
                    $pid="";
                    if(isset($order_detail->product_id)) {
                        $pid = $order_detail->product_id;
                    } else {
                        $pid = $order_detail->id;
                    }
                    
                    $sku=$this->db->query("select * from db_ems_products where id='".$pid."'")->getRow();
                    $orderdetails[] = array(
                        "name" => $order_detail->name, 
                        "sku"=>$sku->sku,
                        "selling_price"=>$order_detail->price,
                        "units"=>$order_detail->qty,
                        "discount"=>"",
                        "tax"=>"",
                        "hsn"=>"",
                        );
                }
                       
          
                            
            $client = \Config\Services::curlrequest();
            
            $response1 = $client->request('POST', 'https://apiv2.shiprocket.in/v1/external/auth/login', [
                'form_params' => [
                    'email' => 'support@writeway.in',
                    'password' => 'Write123???'
                ],
            ]);
            $body1 = json_decode((string) $response1->getBody());
            
            $response = $client->request('POST', 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', [
                    'headers' => [                 
                        'Authorization' => 'Bearer '.$body1->token,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'order_id' => $orders->order_number,
                        'order_date' => $orders->created_at,
                        'pickup_location' => 'Primary',
                        'channel_id' => '',
                        'comment' => '',
                        'billing_customer_name' => $order_userdetails->first_name,
                        'billing_last_name' => $order_userdetails->last_name,
                        'billing_address' => $order_userdetails->address,
                        'billing_address_2' => $order_userdetails->landmark,
                        'billing_city' => $order_userdetails->city,
                        'billing_pincode' => $order_userdetails->pincode,
                        'billing_state' => $sdata->name,
                        'billing_country' => $cdata->name,
                        'billing_email' => $order_userdetails->email,
                        'billing_phone' => $order_userdetails->phone,
                        'shipping_is_billing' => true,
                        'payment_method' => 'Prepaid',
                        'order_items'=>$orderdetails,
                        'shipping_charges' => '0',
                        'giftwrap_charges' => '0',
                        'transaction_charges' => '0',
                        'total_discount' => '0',
                        'sub_total' => $orders->total_amount,
                        'length' => '10',
                        'breadth' => '15',
                        'height' => '20',
                        'weight' => '2.5',
                    ]
                    
            ]);
            
            
            $body = $response->getBody();
            $this->data['message'] =  'Shipment generated successfully.';

            $this->data['record']  = $orders;
            return view('admin/ems/orders/view', $this->data);
            }

	}

	public function delete($ids)
	{		
		$this->data['title'] = 'Order(s) : Delete';

		if (! $this->ionAuth->loggedIn() || (! $this->ionAuth->isAdmin() && ! ($this->ionAuth->user()->row()->id == $id)))
		{
			return redirect()->to('login');
		}

		if(!is_array($ids)) {
			$ids = array($ids);
		}

		foreach($ids AS $id) {

			$this->OrdersModel->delete($id);
			$this->session->setFlashdata('message', 'Record deleted successfully.');

		}

		return redirect()->to(site_url('admin/orders'));

	}


    public function print($id=NULL){
        $db = \Config\Database::connect();
		
		$record = $this->db->query("select * from orders where order_number='".$id."'")->getRow();
		$this->data['order_number']  = $record->order_number;
		return view('frontend/pages/emails/orders', $this->data);
			
		
        
    }
}
