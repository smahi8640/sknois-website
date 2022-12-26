<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Enquiry extends BaseController
{

   
    public function index()
    {
        helper('captcha');
	    $data['title'] = 'Contact Us';
	    $data['brands'] = $this->db->query("select * from brands")->getResultArray();
	    $data['categories'] = $this->db->query("select * from categories")->getResultArray();
	    
	    $session = session();
        $captcha= create_captcha();
        $session->set('captcha_code',$captcha['word']);
	    $data['captcha']=$captcha['image'];
	    
	    return view('frontend/pages/enquiry',$data);
	    
        
    }
    
    public function reload()
    {
        helper('captcha');
       $session = session();
        $captcha= create_captcha();
        $session->set('captcha_code',$captcha['word']);
        echo $captcha['image'];
	    //echo json_encode(array('status'=>1,'message'=>$captcha_code));
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
            $captcha=$this->request->getPost('captcha');
            if($captcha===$session->get('captcha_code')){
            
            $data = [
                    'name' => $name,
                    'email'  => $email,
                    'subject'  => $subject,
                    'message'  => $message,
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
                        
                        <h3 class="text-center mb-4">Contact</h3>
                    <div class="form-row">
                        
                        <div class="col-md-6">
                            <h6><i>Customer Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
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
    			$this->email->setFrom('$settings->site_email', 'Joyari');
                $this->email->setTo('$settings->site_email');
                $this->email->setSubject('Joyari : Contact');
                $this->email->setMessage($msg);
                $this->email->send();
                
                echo json_encode(array('status'=>1,'message'=>'Messsage sent successfully.'));
            }else{
                echo json_encode(array('status'=>0,'message'=>'Captcha code was not match, please try again')); 
				exit(0);
            }
        }
        else
        {
          echo json_encode(array('status'=>0,'message'=>$this->validator->listErrors()));
        }
    }
    

}