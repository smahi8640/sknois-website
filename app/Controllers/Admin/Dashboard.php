<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    
	
	public function index()
	{
	    
	    if (! $this->ionAuth->loggedIn())
		{
            return redirect()->to('admin');
        }
        
	    $data['title'] = 'Dashboard';	
	    $data['subscription'] = $this->db->query("select count(*) as counts from subscribers")->getRow();
	    $data['products'] = $this->db->query("select count(*) as counts from products")->getRow();	
	    return view('admin/pages/index',$data);
	}
	
	
}