<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\MailChimp;

class Contact extends BaseController
{

   
    public function index()
    {
        
	    $data['title'] = 'Contact Us';
	    $data['siteconfiguration'] = $this->db->query("select * from settings_siteconfiguration")->getRow();
	    
	    return view('frontend/pages/contact',$data);
	    
        
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
            $phone=$this->request->getPost('mobile');
            $subject=$this->request->getPost('subject');
            $message=$this->request->getPost('message');
            //$captcha=$this->request->getPost('captcha');
            //if($captcha===$session->get('captcha_code')){
                
            $data = [
                    'name' => $name,
                    'email'  => $email,
                    'mobile'  => $phone,
                    'subject'  => $subject,
                    'description'  => $message,
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
                            <h6><i>Customer Contact Details</i></h6>
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
                $settings=$this->db->query("SELECT * FROM settings_siteconfiguration")->getRow();                        
                $this->email->setMailType('html');
               
    			$this->email->setFrom($settings->site_email, 'Joyari');
                $this->email->setTo($settings->site_email);
                //$this->email->setBCC('abdeali@vcaretechnologies.net');
                $this->email->setSubject('Joyari : Contact');
                $this->email->setMessage($msg);
                $this->email->send();
                
                
		
                echo json_encode(array('status'=>'1','message'=>'Message sent Succesfully'));
              
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
    
    public function subscribe()
    {
        
	        helper('form');
			if($this->validate(['email'  => 'required|valid_email|is_unique[subscribers.email_address]']))
			{
            $email = $this->request->getPost('email');
            
            $data = [
                    'email_address' => $email,
                    'created_date'  => date('Y-m-d H:i:s')
            ];
            $this->db->table('subscribers')->insert($data);
            
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
                        
                        <h3 class="text-center mb-4">Subscription</h3>
                    <div class="form-row">
                        
                        <div class="col-md-6">
                            <h6><i>Subscriber Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Email: '.$email.'</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                        </body></html>';
                        $settings=$this->db->query("SELECT * FROM settings_siteconfiguration")->getRow();  
                 $this->email->setMailType('html');
    			$this->email->setFrom($settings->site_email, 'Joyari');
                $this->email->setTo($settings->site_email);
                //$this->email->setBCC('abdeali@vcaretechnologies.net');
                $this->email->setSubject('Joyari : Subscriber');
                $this->email->setMessage($msg);
                $this->email->send();
    			
             echo json_encode(array('status'=>1,'message'=>'Subscription successfull.'));
            
        }
        else
        {
          echo json_encode(array('status'=>0,'message'=>strip_tags($this->validator->listErrors())));
        }
	    
        
    }

}