<?php namespace App\Controllers;
use App\Controllers\BaseController;

class Session extends BaseController
{
    public function __construct()
	{

		$this->session       = \Config\Services::session();

	}
	
	public function diamondtype()
	{
	   $session = session();
	   
	   $session->set('diamondtype', $this->request->getPost('id'));
	   echo json_encode(array('status'=>1,'message'=>'Success'));
	}
	
	public function country()
	{
	   $session = session();
	   
	   $session->set('country', $this->request->getPost('id'));
	   echo json_encode(array('status'=>1,'message'=>'Success'));
	}
	
	public function currency()
	{
	   $session = session();
	   
	   $session->set('currency', $this->request->getPost('id'));
	   echo json_encode(array('status'=>1,'message'=>'Success'));
	}
	

	//--------------------------------------------------------------------

}
