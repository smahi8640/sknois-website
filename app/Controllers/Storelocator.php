<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Storelocator extends BaseController
{
    public function index()
    {

	    $data['title'] = 'Store Locator';
	    
        $query = "SELECT * from storelocator where 1";
        if(isset($_POST['country']) && !empty($_POST['country'])){
            $query.= " and country LIKE '%".$_POST['country']."%'";
        }
        if(isset($_POST['zip_code']) && !empty($_POST['zip_code'])){
            $query.= " and zip_code LIKE '%".$_POST['zip_code']."%'";
        }
        $query.= " order by title asc";
	    $data['records'] = $this->db->query($query)->getResultArray();
	    $data['countries'] = $this->db->query("SELECT country from storelocator group by country ORDER BY country ASC")->getResultArray();
	    $data['states'] = $this->db->query("SELECT * from states where country_id='231'")->getResultArray();
	    return view('frontend/pages/store_locator',$data);
        
    }  
    
    public function send()
    {   $session = session();
        	helper('form');
			if($this->validate(['name'  => 'required']))
			{
            $name = $this->request->getPost('name');
            $email=$this->request->getPost('email');
            $phone=$this->request->getPost('phone');
            $subject=$this->request->getPost('subject');
            $message=$this->request->getPost('message');
             $id=$this->request->getPost('id');
            $title=$this->request->getPost('title');
            $state=$this->request->getPost('state');
            $city=$this->request->getPost('city');
            $datetime=date('Y-m-d H:i:s',strtotime($this->request->getPost('datetime')));
            //$captcha=$this->request->getPost('captcha');
            //if($captcha===$session->get('captcha_code')){
            $cart=[
                    'id'=>$id,
                    'name'=>$title,
                    'state'=>$state,
                    'city'=>$city,
                    'datetime'=>$datetime,
                ];    
            $data = [
                    'name' => $name,
                    'email'  => $email,
                    'phone'  => $phone,
                    'subject'  => $subject,
                    'message'  => $message,
                    'store_details'  => json_encode($cart),
                    'is_type'  => '2',
                    'created_at'  => date('Y-m-d H:i:s')
            ];
            $this->db->table('contact')->insert($data);
            
            
            $msg='<!DOCTYPE html>
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
                        
                        <h3 class="text-center mb-4">Store Locator</h3>
                    <div class="form-row">
                        
                        <div class="col-md-6">
                            <h6><i>Customer Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                <tr>
                                        <th>Store id : '.$id.' </th>
                                    </tr>
                                    <tr>
                                        <th>State: '.$state.' </th>
                                    </tr>
                                    <tr>
                                        <th>City: '.$city.' </th>
                                    </tr>
                                    <tr>
                                        <th>Date Time: '.$datetime.' </th>
                                    </tr>
                                    <tr>
                                        <th>'.$name.' </th>
                                    </tr>
                                    <tr>
                                        <td>'.$email.'</td>
                                    </tr>
                                    <tr>
                                        <td>'.$phone.'</td>
                                    </tr>
                                    <tr>
                                        <td>'.$subject.'</td>
                                    </tr>
                                    <tr>
                                        <td>'.$message.'</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                        </body></html>';
                $this->email->setMailType('html');
    			$this->email->setFrom('info@bebabybridal.com', 'Bebaby');
                $this->email->setTo('sp@treasta.com');
                $this->email->setSubject('Bebaby : Store locator');
                $this->email->setMessage($msg);
                $this->email->send();
                
                
		//$this->email->printDebugger(['headers']);
                echo json_encode(array('status'=>1,'message'=>'Message sent Succesfully'));
            /*}else{
                echo json_encode(array('status'=>0,'message'=>'Captcha code was not match, please try again')); 
				exit(0);
            }*/
        }
        else
        {
          echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
        }
    }
}