<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\MailChimp;

class Forms extends BaseController
{
	public function help() 
	{
	    
		 $this->db      = \Config\Database::connect();
		 
        helper(['form', 'url']);
       
        $id  = $this->request->getPost('help_id');
        $is_set  = $this->request->getPost('is_set');
		$fullname  = $this->request->getPost('fullname');
        $email  = $this->request->getPost('email');
        $mobile  = $this->request->getPost('mobile');
        $query  = $this->request->getPost('query');
        
        if($is_set=='0'){
            $product=$this->db->query("select * from products where id='".$id."'")->getRowArray();
        }else{
            $product=$this->db->query("select * from products_set where id='".$id."'")->getRowArray();   
        }
         $data = array(
            'type' => '1',
            'product_details_id' => $id,
            'fullname' => $fullname,
            'email' => $email,
            'mobile' => $mobile,
            'query' => $query,
            'is_set'=>$is_set,
           'created_at'=>date('Y-m-d H:i:s'),
        );
         $this->db->table('forms')->insert($data);
     
       $message='<!DOCTYPE html>
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
                        
                        <h3 class="text-center mb-4">Help</h3>
                    <div class="form-row">
                        
                        <div class="col-md-6">
                            <h6><i>Details</i></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Product Name: '.$product['title'].' </th>
                                    </tr>
                                    <tr>
                                        <th> Name: '.$fullname.' </th>
                                    </tr>
                                    
                                     <tr>
                                        <th>Email: '.$email.' </th>
                                    </tr>
                                     <tr>
                                        <th>Mobile: '.$mobile.' </th>
                                    </tr>
                                    <tr>
                                        <th>Query: '.$query.' </th>
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
               // $this->email->setBcc('hello@vcaretechnologies.net');
                $this->email->setSubject('Joyari : Help');
                $this->email->setMessage($message);
                $this->email->send();
                
        echo json_encode(array('status'=>1,'message'=>'We will contact you soon!!'));
           
    			
	}
	
    
}
?>