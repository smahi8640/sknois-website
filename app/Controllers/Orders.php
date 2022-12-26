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

class Orders extends INDRA_Controller {

	
	function __construct()
	{
		
		parent::__construct();

        $this->load->model('orders_model');
        $this->load->model('products_model');
        $this->load->model('categories_model');
        if(!$this->ion_auth->logged_in()) {	
            redirect('login', 'refresh');
		}        
	}
	
        
	public function index() {
		
		$this->data['page_title'] = $this->data['page_title'].' - Orders';

        $user = $this->ion_auth->user()->row();

        $this->config->load('pagination', TRUE);
        $settings = $this->config->item('pagination');
        $settings['total_rows'] = $this->orders_model->record_count();
        $settings['base_url'] =  base_url() . "admin/orders";

        // use the settings to initialize the library
        $this->pagination->initialize($settings);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $where = array();
        $where['user_id'] = $user->id;
        $this->data['records'] = $this->orders_model->recordlistWhere($where, $settings["per_page"], $page);
        $this->data['pagination'] = $this->pagination->create_links();
		
		$this->render('order_history');
	}
	
	public function cancel_order() {
	    $user = $this->ion_auth->user()->row();
	    $order_details=$this->db->query("select * from orders where order_number='".$this->input->post('oid')."'")->row(); 
		
		$ordercart_details = json_decode($order_details->order_details);

		if($this->input->post('status')=="3"){
			$status="Cancellation";
		}else if($this->input->post('status')=="9"){
			$status="Return";
		}
		$cart = array();
		foreach ($ordercart_details AS $order) {
			if($order->id==$this->input->post('itemid')){
				$order_item_status=$this->input->post('status');
				$cartlogs = array(
					'order_id'=>$order_details->id,
					'order_item_id'=>$order->id,
					'status'=>$order_item_status,
					'created_by'=>'0',
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_by'=>'0',
					'updated_at'=>date('Y-m-d H:i:s'),
					'remarks'=> '' 
				);
				$this->db->insert('order_item_statuslogs', $cartlogs);
			}else{
				$order_item_status=$order->order_item_status;
			}
			$cart[] = array(
				'id' => $order->id,
				'user_id' => $order->user_id,
				'session_id'=>$order->session_id,
				'cart_row_id'=>$order->cart_row_id,
				'product_id'=>$order->product_id,
				'sku'=>$order->sku,
				'title'=>$order->title,
				'attributes'=>$order->attributes,
				'image'=>$order->image,
				'qty'=>$order->qty,
				'price'=>$order->price,
				'mrp'=>$order->mrp,
				'color'=>$order->color,
				'size'=>$order->size,
				'type'=>$order->type,
				'order_amount'=>$order->order_amount,
				'coupon_id'=>$order->coupon_id,
				'coupon_amount'=>$order->coupon_amount,
				'attributes_id'=>$order->attributes_id,
				'json_data'=>$order->json_data,
				'order_item_status'=>$order_item_status,
				'created_by'=>$order->created_by,
				'created_date'=>$order->created_date,
				'updated_by'=>$order->updated_by,
				'updated_date'=>$order->updated_date  
			);		
			
		
		}
		$updatecart=array('order_details'=>json_encode($cart));
		 $this->db->where('id', $order_details->id);
		 $this->db->update('orders', $updatecart);

		
		 $settings=$this->db->query("SELECT * FROM settings_siteconfiguration")->row();
		 $customer_details=$this->db->get_where('customers', array('order_id' => $order_details->id))->result();
		 	
                
                $html='<!DOCTYPE html>
				<html lang="en">
				    <head>
				        <style>
				            .col-md-6{
				                width: 50%;
				                float: left;
				            }
				            h3 { font-size: 32px; text-align: center; margin: 0 0 20px; }
				            h6 {
                                font-size: 16px;
                                color: #3d5170;
                                margin: 0;
                                font-weight: 400;
                            }
                            .table th { font-weight: bold; }
                            b { font-weight: 500; }
                            .table td, .table th {
                                padding: .75rem;
                                font-size: 15px;
                                color: #5a6169;
                            }
                            .table {
                                width: 100%;
                                margin-bottom: 16px;
                                
                                text-align: left;
                            }
				            .table-bordered td, .table-bordered th {
                                border: 1px solid #dee2e6;
                            }
                        </style>
				    </head>
					<body>
                        <table width="100%">
                                <tr>
                                    <td align="center"><img src="'.base_url('').'media/source/joyari-logo.png" width="30%" /></td>
                                </tr>
                    </table>
                    <h6>Order No. : <b>'.$this->input->post('oid').'</b></h6>
                    <h6>Order Date: '. $order_details->created_date.'</h6>
                    <div class="form-row">
                        <div class="col-md-12">
                        your order item '.$status.' request is recieved as below
						<table class="table table-bordered" width="100%">
						<tr>
							<th>#</th>
							<th>Image</th>
							<th width="40%">Product</th>
							<th>Qty</th>
							<th>MRP</th>
							<th>Disc.</th>
							<th>Price</th>
							<th>Subtotal</th>
						</tr>';
						$i = 1; foreach ($ordercart_details AS $order) {
							if($order->id==$this->input->post('itemid')){
							$html.='<tr>
							<td>'.$i.'</td>
						<td>';
							 if(file_exists(FCPATH."media/source/".$order->image)) { 
									$img = base_url('media/source/').$order->image;
								} else { 
									$img = base_url('media/source/joyari-logo.png');
								}
							 
								$html.='<img src="'.$img.'" height="160px" />
							</td>
						<td width="40%">
                                   '.$order->title.'
                                           <h6 class="mb-0 text-small"><small> 
                        SKU: '.$order->sku.'<br/> 
                                                Color: '.$order->color;
                            if(!empty($order->size) && $order->size!="-"){ 
                        	$html.=' / Size: '.$order->size; 
                                                }
                            if($order->type=="2"){
                        	$html.='<br/><span style="color:red"><b>Made to order</b></span>';
                                                }
                                                 
                         	$html.='</small></h6>                                     
                               </td>
                               <td>'.$order->qty.'</td>
                               <td>'.number_format($order->mrp, 2).'</td>
                               <td>'.number_format($order->mrp-$order->price, 2).'</td>
                               <td>'.number_format($order->price, 2).'</td>
                               <td class="text-right">'.number_format($order->price*$order->qty, 2).'</td>
                           </tr>';
						 }
						$i++;}
								$html.='</table>;

                        </div>
                    </div>
                        </body></html>';
                
                
            //     //$html = $orderstatus_details[0]->email_text;
            //     //$html = str_replace('[MESSAGE]', $recorda['order_message'], $html);

			$this->load->library('email');				
			$this->email->from($settings->site_email, 'Treasta-Orders');
			$this->email->to($customer_details[0]->customer_email);	
			$this->email->cc($settings->site_email);							
			$this->email->subject('Treasta : Orders item '.$status.' request');
			$this->email->message($html);				
			$this->email->send();
			
			
			// $htmlmsg = "your order cancellation request for Order No : ".$data[0]->order_number."  is recieved ";
            // //$html = str_replace('[MESSAGE]', $recorda['order_message'], $html);
            // $mobile_message = $htmlmsg;
            
            // $param['mobiles'] = $customer_details[0]->customer_phonenumber;
			// $param['message'] = $mobile_message;
			
			// $url = $query->site_sms_api.http_build_query($param);
			// $ch = curl_init($url);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// $curl_scraped_page = curl_exec($ch);
			// curl_close($ch);
			// $response = ($curl_scraped_page!="")?explode("|", $curl_scraped_page):'';
			

		$query=$this->db->query("SELECT * FROM settings_siteconfiguration")->row();
		if($order_item_status=="3"){
		echo json_encode(array('status'=>1,'message'=>'Cancellation request sent successfully'));
		}else if($order_item_status=="9"){
			echo json_encode(array('status'=>1,'message'=>'Return request sent successfully'));
			}
	 
  
	}
	
	public function insertorderreviews() {
	
	
		$rating  = $this->input->post('rating');
		$comment  = $this->input->post('comment');
		$user_id  = $this->input->post('user_id');
		$order_id  = $this->input->post('order_id');
		$product_id  = $this->input->post('product_id');
		$return_url  = $this->input->post('return_url');
		
		if($return_url == 'orders') {
			$order_details = $this->orders_model->recordlist($order_id);
			$order_details_data = json_decode($order_details[0]->order_details);
			
			foreach($order_details_data AS $order_detail) {
			
				$record = array();
				$record['user_id'] = $user_id;
				$record['order_id'] = $order_id;
				$record['product_id'] = $order_detail->id;
				$record['rating'] = $rating;
				$record['comment'] = $comment;
				$record['created_by'] = $user_id;
				$record['created_date'] = date('Y-m-d H:i:s');
				$this->db->insert('product_reviews', $record);
			
			}
		} else {
		
			$record = array();
			$record['user_id'] = $user_id;
			$record['product_id'] = $product_id;
			$record['rating'] = $rating;
			$record['comment'] = $comment;
			$record['created_by'] = $user_id;
			$record['created_date'] = date('Y-m-d H:i:s');
			$this->db->insert('product_reviews', $record);
					
		}
		
		$this->session->set_flashdata('message_type','success');
		$this->session->set_flashdata('message', 'Review Added.');
	   		
		// This will show insert data in cart.
		redirect($return_url ,'refresh');	
	}
		
	
	public function track() {
		
		$this->data['page_title'] = $this->data['page_title'].' - Track Orders';

        $user = $this->ion_auth->user()->row();

        $this->data["tracks"]=$this->db->query("select *,ordersstatus_logs.order_status as orstatus from ordersstatus_logs left join orders on orders.id=ordersstatus_logs.order_id where orders.order_number='".$this->input->post('order_number')."'")->result();
		
		$this->render('order_track');
	}
}
